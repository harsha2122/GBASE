<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Machine extends Model
{
    protected $fillable = ['name', 'category', 'slug', 'description', 'image', 'page', 'order'];

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_machines')
            ->withPivot('position')
            ->withTimestamps()
            ->orderBy('position');
    }
}
