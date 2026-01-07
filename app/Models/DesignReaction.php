<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignReaction extends Model
{
    protected $fillable = [
        'design_id', 'class_id', 'session_id', 'reaction'
    ];

    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class);
    }
}
