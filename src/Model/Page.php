<?php

namespace Darko\FilamentContentToolkits\Model;

use Darko\FilamentContentToolkits\Model\Concerns\HasRelated;
use Darko\FilamentContentToolkits\Model\Concerns\HasSearch;
use Darko\FilamentContentToolkits\Model\Concerns\HasSeo;
use Darko\FilamentContentToolkits\Model\Concerns\HasSitemap;
use Darko\FilamentContentToolkits\Model\Concerns\HasSlug;
use Darko\FilamentContentToolkits\Model\Concerns\HasTags;
use Darko\FilamentContentToolkits\Model\Contracts\Relatable;
use Darko\FilamentContentToolkits\Model\Contracts\Searchable;
use Darko\FilamentContentToolkits\Model\Contracts\Seoable;
use Darko\FilamentContentToolkits\Model\Contracts\Sitemapable;
use Darko\FilamentContentToolkits\Model\Contracts\Sluggable;
use Darko\FilamentContentToolkits\Model\Contracts\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

abstract class Page extends Model implements HasMedia, Seoable, Sitemapable, Searchable, Sluggable, Relatable, Taggable
{
    use SoftDeletes, HasSlug, HasSeo, HasSitemap, HasSearch, HasRelated, HasTags, InteractsWithMedia;

    protected $casts = ['blocks' => 'array'];
    protected $slugColumn = "title";

    public function hasPageBlock($type): bool
    {
        return $this?->blocks ?
            collect($this->blocks)->contains('type', $type) :
            false;
    }
}
