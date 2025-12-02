<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    /**
     * Your migration created table "design" (singular),
     * so we keep this.
     */
    protected $table = 'design';

    protected $fillable = [
        'rows',
        'cols',
        'background_image',
        'placed_assets',
        'layout_id',
        'user_id',
    ];

    protected $casts = [
        'placed_assets' => 'array',
    ];
}
