<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignComment extends Model
{
    protected $fillable = [
        'design_id', 'class_id', 'student_name', 'session_id', 'text'
    ];

    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class);
    }
}
