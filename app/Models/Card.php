<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'image', 'page', 'page_id', 'order'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
