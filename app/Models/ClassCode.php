<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassCode extends Model
{
    protected $fillable = [
        'class_id',
        'code',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at'    => 'datetime',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
