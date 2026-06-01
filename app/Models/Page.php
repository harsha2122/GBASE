<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'meta_description', 'content', 'hero_image', 'breadcrumb', 'has_form', 'form_type'];

    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(Machine::class, 'page_machines')
            ->withPivot('position')
            ->withTimestamps()
            ->orderBy('position');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
