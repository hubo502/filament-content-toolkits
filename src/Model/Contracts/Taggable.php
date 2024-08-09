<?php

namespace Darko\FilamentContentToolkits\Model\Contracts;

use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface Taggable
{
    public function scopeWithAnyTagsByLocale(
        Builder $query,
        string | array | ArrayAccess $tags,
        ?string $type = null,
        ?string $locale = null
    ): Builder;

    public function tags(): MorphToMany;
}
