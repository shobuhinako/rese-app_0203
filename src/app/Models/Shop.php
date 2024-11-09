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
        'name',
        'area',
        'genre',
        'detail',
        'image_path',
    ];

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
}
