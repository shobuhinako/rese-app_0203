<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

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
}
