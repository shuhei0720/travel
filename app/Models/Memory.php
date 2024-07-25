<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    use HasFactory;

    // ホワイトリスト方式で保存するフィールドを指定
    protected $fillable = [
        'title',
        'destination',
        'nights',
        'days',
        'departure_time',
        'departure_location',
        'schedule',
        'thoughts',
        'images',
    ];

    // imagesは配列として扱う
    protected $casts = [
        'images' => 'array',
    ];
}