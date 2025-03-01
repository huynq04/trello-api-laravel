<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'column_id',
        'order_index',
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
