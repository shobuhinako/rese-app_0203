<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'area_id',
        'genre_id',
        'name',
        'detail',
        'image_path',
    ];

    /**
     * エリアに基づいて店舗を取得するメソッド
     *
     * @param string $area
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByArea($area)
    {
        return self::where('area', $area)->get();
    }

    /**
     * ジャンルに基づいて店舗を取得するメソッド
     *
     * @param string $genre
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByGenre($genre)
    {
        return self::where('genre', $genre)->get();
    }

    /**
     * 店舗名に基づいて店舗を取得するメソッド
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchByName($name)
    {
        return self::where('name', 'like', "%$name%")->get();
    }

    public function is_bookmarked_by_auth_user()
    {
        // 認証されたユーザーを取得
        $user = Auth::user();

        if ($user) {
            // ユーザーがこの店舗をお気に入りにしているかどうかを確認
            return $this->favorites()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isOwner($userId)
    {
        return $this->user_id === $userId;
    }
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
