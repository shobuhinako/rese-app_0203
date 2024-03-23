<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breakstamp extends Model
{
    use HasFactory;
    protected $fillable = ['timestamp_id', 'breakIn', 'breakOut'];

    public function timestamp()
    {
        return $this->belongsTo(Timestamp::class);
    }

}
