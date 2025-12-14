<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassCode extends Model
{
    protected $fillable = [
        'class_id',
        'code',
        'expires_at',
        'used_at',        // ✅ add this if you add the column
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at'    => 'datetime', // ✅ add this if you add the column
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
