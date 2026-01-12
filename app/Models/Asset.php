<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    use HasFactory;


    protected $fillable = [
        'slug',
        'label',
        'image_url',
        'width',
        'height',
        'is_available',
    ];
}
