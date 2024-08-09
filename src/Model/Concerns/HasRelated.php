<?php

namespace Darko\FilamentContentToolkits\Model\Concerns;

use Darko\FilamentContentToolkits\Facades\Site;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasRelated
{
    protected function related(): Attribute
    {
        return Attribute::make(get: fn () => $this->getRelated(Site::defaultTagType()))->shouldCache();
    }

    public function getRelated(?string $type)
    {
        static::withAnyTags($this->tags->pluck('name')->toArray(), $type ?? Site::defaultTagType())->whereNot('id', $this->id)->get();
    }
}
