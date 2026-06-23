<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'url',
        'caption',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'caption'   => 'array',
        'is_active' => 'boolean',
    ];
}