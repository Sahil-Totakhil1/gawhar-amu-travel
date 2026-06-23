<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'video_url',
        'price',
        'location',
        'category',
        'status',
        'views',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    /**
     * دا اعلان کوم کاروونکي لیکلی.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}