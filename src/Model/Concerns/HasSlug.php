<?php

namespace Darko\FilamentContentToolkits\Model\Concerns;

use Spatie\Sluggable\HasSlug as HasSpatieSlug;
use Spatie\Sluggable\SlugOptions;

trait HasSlug
{
    use HasSpatieSlug;

    public function getSlugOptions(): SlugOptions
    {
        $slugColumn = $this?->slugColumn ?: 'name';

        return SlugOptions::create()->generateSlugsFrom(function ($model) use ($slugColumn) {
            return method_exists($model, 'resolveSlug') ? $model->resolveSlug() : $model->$slugColumn;
        })->saveSlugsTo('slug')->preventOverwrite();
    }
}
