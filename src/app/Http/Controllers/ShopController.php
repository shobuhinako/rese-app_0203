<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Reservation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function showDetail($id){
        $shop = Shop::find($id);
        $userId = auth()->id();
        $user = User::find($userId);

        $review = Review::where('user_id', $userId)->where('shop_id', $shop->id)->first();

        $reservation = Reservation::where('user_id', $userId)->where('shop_id', $shop->id)->first();

        $isPastReservation = false;
        if ($reservation) {
            $reservationDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
            $currentDateTime = Carbon::now();
            $isPastReservation = $currentDateTime->greaterThan($reservationDateTime);
        }

        $area = $shop->area->area;
        $genre = $shop->genre->genre;

        // 店舗代表者の場合のみQRコードを生成
        $qrCode = null;
        if ($user && $user->role_id === 2 && $shop->isOwner($userId)) {
            $url = route('reservation.status', ['id' => $shop->id]);
            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($url));
        }

        return view('detail', compact('shop', 'user', 'review', 'isPastReservation', 'area', 'genre', 'qrCode'));
    }


    public function favorite(Request $request, Shop $shop){
        // 認証済みユーザーを取得
        $user = Auth::user();

        if ($user) {
            // Userのid取得
            $user_id = Auth::id();

            // 既にいいねしているかチェック
            $existingFavorite = Favorite::where('shop_id', $shop->id)
                ->where('user_id', $user_id)
                ->first();

            // 既にいいねしている場合は削除し、そうでない場合は新しいいいねを作成する
            if ($existingFavorite) {
                $existingFavorite->delete();
                $isFavorite = false;
            } else {
                $favorite = new Favorite();
                $favorite->shop_id = $shop->id;
                $favorite->user_id = $user_id;
                $favorite->save();
                $isFavorite = true;
            }

            session()->put('isFavorite', $isFavorite);
            session()->put('favoriteShopId', $shop->id);
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $favorite = Favorite::where('shop_id', $request->shop_id)->first();
        if ($favorite) {
            $favorite->delete();
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $areaInput = $request->input('area');
        $genreInput = $request->input('genre');
        $name = $request->input('name');

        $query = Shop::query();

        switch (true) {
            case ($areaInput !== 'all' && $genreInput !== 'all' && !empty($name)):
                // エリア、ジャンル、店舗名がすべて指定されている場合
                $query->where('area_id', $areaInput)
                      ->where('genre_id', $genreInput)
                      ->where('name', 'like', "%$name%");
                break;

            case ($areaInput !== 'all' && $genreInput !== 'all'):
                // エリアとジャンルが指定されている場合
                $query->where('area_id', $areaInput)
                      ->where('genre_id', $genreInput);
                break;

            case ($areaInput !== 'all' && !empty($name)):
                // エリアと店舗名が指定されている場合
                $query->where('area_id', $areaInput)
                      ->where('name', 'like', "%$name%");
                break;

            case ($genreInput !== 'all' && !empty($name)):
                // ジャンルと店舗名が指定されている場合
                $query->where('genre_id', $genreInput)
                      ->where('name', 'like', "%$name%");
                break;

            case ($genreInput !== 'all'):
                // ジャンルが指定されていて、エリアが「すべて」の場合
                $query->where('genre_id', $genreInput);
                break;

            case ($areaInput !== 'all'):
                // エリアが指定されていて、ジャンルが「すべて」の場合
                $query->where('area_id', $areaInput);
                break;

            case (!empty($name)):
                // 店舗名が指定されている場合
                $query->where('name', 'like', "%$name%");
                break;

            default:
                // エリアとジャンルが「すべて」で店舗名も指定されていない場合
                // すべての店舗を取得する
                break;
        }

        $shops = $query->get();

        return view('index', ['shops' => $shops]);
    }

    public function sort(Request $request)
    {
        $sortType = $request->input('sort__type');

        $query = Shop::query()
            ->withCount(['reviews as average_rating' => function ($query) {
                $query->select(DB::raw('avg(rating)'));
            }]);

        switch ($sortType) {
            case 'random':
                $query->inRandomOrder();
                break;

            case 'rating_asc':
                $query->orderbyDesc('average_rating')
                      ->orderBy('id');
                break;

            case 'rating_desc':
                $query->orderByRaw('average_rating IS NULL')
                      ->orderBy('average_rating')
                      ->orderBy('id');
                break;

            default:
                $query->orderBy('id');
                break;
        }

        $shops = $query->get();

        return view('index', compact('shops', 'sortType'));
    }

    public function showImportForm()
    {
        return view ('import');
    }

    public function uploadImage(UploadImageRequest $request)
    {
        $image = $request->file('image');

        $path = Storage::disk('public')->putFile('images', $image);

        $fileName = basename($path);

        return back()->with('success','画像情報を保存しました')->with('fileName', $fileName);
    }

    public function importCsv(Request $request)
    {
        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();
        $fileContents = file_get_contents($filePath);
        $fileContents = mb_convert_encoding($fileContents, 'UTF-8', 'SJIS-win');

        $lines = preg_split('/\r\n|\n/', $fileContents);
        $lines = array_filter($lines, fn($line) => !empty(trim($line)));

        $csvData = array_map(fn($line) => str_getcsv($line, ","), $lines);

        $header = array_shift($csvData);

        $headerMapping = [
            'ユーザーID' => 'user_id',
            '店舗名' => 'name',
            'エリア' => 'area',
            'ジャンル' => 'genre',
            '店舗情報' => 'detail',
            '画像ファイル名' => 'image_path',
        ];

        $errors = [];
        $insertData = [];

        foreach ($csvData as $index => $row) {
            $mappedData = [];

            foreach ($header as $key => $columnName) {
                if (isset($headerMapping[$columnName])) {
                    $mappedData[$headerMapping[$columnName]] = $row[$key];
                }
            }

            $rowErrors = [];

            // user_idのバリデーション
            if (empty($mappedData['user_id']) || !User::find($mappedData['user_id'])) {
                $rowErrors[] = 'ユーザーIDは必須項目です。';
            }

            // 店舗名のバリデーション
            if (empty($mappedData['name'])) {
                $rowErrors[] = '店舗名は必須項目です。';
            } elseif (strlen($mappedData['name']) > 50) {
                $rowErrors[] = '店舗名は50文字以内で入力してください。';
            }

            // エリアのバリデーション
            if (empty($mappedData['area'])) {
                $rowErrors[] = 'エリアは必須項目です。';
            } else {
                $area = Area::where('area', $mappedData['area'])->first();
                if (!$area) {
                    $rowErrors[] = "エリアは「東京都」「大阪府」「福岡県」のいずれかを指定してください。";
                } else {
                    $mappedData['area_id'] = $area->id;
                }
            }

            // ジャンルのバリデーション
            if (empty($mappedData['genre'])) {
                $rowErrors[] = 'ジャンルは必須項目です。';
            } else {
                $genre = Genre::where('genre', $mappedData['genre'])->first();
                if (!$genre) {
                    $rowErrors[] = "ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを指定してください。";
                } else {
                    $mappedData['genre_id'] = $genre->id;
                }
            }

            // 店舗情報のバリデーション
            if (empty($mappedData['detail'])) {
                $rowErrors[] = '店舗情報は必須項目です。';
            } elseif (strlen($mappedData['detail']) > 400) {
                $rowErrors[] = '店舗情報は400文字以内で入力してください。';
            }

            // 画像ファイル名のバリデーション
            if (empty($mappedData['image_path'])) {
                $rowErrors[] = '画像ファイル名は必須項目です。';
            } elseif (!preg_match('/\.(jpeg|jpg|png)$/i', $mappedData['image_path'])) {
                $rowErrors[] = '画像ファイル名はjpeg、jpg、またはpng形式の画像ファイル名である必要があります。';
            }

            if (!empty($rowErrors)) {
                $errors[$index + 2] = $rowErrors;
            } else {
                $insertData[] = [
                    'user_id' => $mappedData['user_id'],
                    'name' => $mappedData['name'],
                    'detail' => $mappedData['detail'],
                    'image_path' => $mappedData['image_path'],
                    'area_id' => $mappedData['area_id'],
                    'genre_id' => $mappedData['genre_id'],
                ];
            }
        }

        if (!empty($errors)) {
            $formattedErrors = [];
            foreach ($errors as $line => $lineErrors) {
                $formattedErrors[] = "行 {$line}：" . implode(' / ', $lineErrors);
            }

            return redirect()->back()->withErrors(['csv_errors' => $formattedErrors])->withInput();
        }

        if (!empty($insertData)) {
            Shop::insert($insertData);
        }

        return redirect()->route('show.import.form')->with('success', 'CSVのインポートが完了しました。');
    }

    public function showUpdateStorePage(){

        $userId = Auth::id();
        $shops = Shop::where('user_id', $userId)->get();

        $imageFiles = Storage::disk('public')->files('images');
        $images = [];
        foreach ($imageFiles as $file) {
        $images[] = 'storage/app/public/' . $file;
        }

        $userId = Auth::id();

        return view ('update-shop', ['images' => $images, 'shops' => $shops]);
    }

    public function updateStore(Request $request)
    {
        $shopId = $request->input('name');
        $shop = Shop::findOrFail($shopId);

        $relativeImagePath = ltrim(str_replace(asset('storage/'), '', $request->input('image_path')), '/');

        $shop->update([
            'area' => $request->input('area'),
            'genre' => $request->input('genre'),
            'detail' => $request->input('detail'),
            'image_path' => $relativeImagePath,
        ]);

        session()->flash('success_message', '店舗情報を更新しました');

        return redirect('/update/shop');
    }

}
