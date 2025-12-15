<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'class_id',
        'student_name',
        'feedback',
        'layout_id',
        'user_id',
    ];

    protected $casts = [
        'placed_assets' => 'array',
    ];


    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
