<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Bookmark extends Model
{
    /**Database\Factories\BookmarkFactory> */
    use HasFactory;
    protected $fillable=[
    'user_id',
    'title',
    'url',
    'notes',
    'is_favorite',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
