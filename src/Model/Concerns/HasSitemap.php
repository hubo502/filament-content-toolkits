<?php

namespace Darko\FilamentContentToolkits\Model\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url as SitemapUrl;

/**
 * @property-read string $url
 * @property-read string $updated_at
 */
trait HasSitemap
{
    protected static function resolveSitemapRecords(): Collection
    {
        return static::all();
    }

    protected static function resolveSitemapFilename(): string
    {
        $basename = Str::of(get_called_class())->classBasename()->snake()->plural();
        return "sitemap_{$basename}.xml";
    }

    public static function generateSitemap(): void
    {
        $locales = Site::transLocales();
        $sitemap = Sitemap::create();

        static::resolveSitemapRecords()->each(function ($item) use ($locales, $sitemap) {
            foreach ($locales as $locale) {
                $link = SitemapUrl::create(URL::localize($item->url, $locale))->setLastModificationDate($item->updated_at);
                $sitemap->add($link);
            }
        });

        $sitemap->writeToFile(public_path(static::resolveSitemapFilename()));
    }
}
