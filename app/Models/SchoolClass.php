<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SchoolClass extends Model
{
    use HasFactory;
    protected $table = 'classes';

    protected $fillable = ['teacher_id', 'name'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function codes(): HasMany
    {
        return $this->hasMany(ClassCode::class, 'class_id');
    }

    public function activeCode(): HasOne
    {
        return $this->hasOne(ClassCode::class, 'class_id')->latestOfMany();
    }
}
