<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
    ];

    public function userBoard(): HasMany
    {
        return $this->hasMany(UserBoard::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_boards');
    }

    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

}
