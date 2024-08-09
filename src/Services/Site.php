<?php

namespace Darko\FilamentContentToolkits\Services;

use Darko\FilamentContentToolkits\Model\Tag;

class Site
{
    public function abbv()
    {
        return 'test';
    }

    public function intro()
    {
        return 'Ea exercitation magna laboris quis non.';
    }

    public function baseLocale(): string
    {
        return config('auto-translate.base_locale', config('app.fallback_locale'));
    }

    public function transLocales(): array
    {
        return config('auto-translate.trans_locales', []);
    }

    public function seoUseBrand(): bool
    {
        return true;
    }

    public function categories(): array
    {
        return config('site.categories', []);
    }

    public function seoTitleMaxLength(): int
    {
        return 70;
    }

    public function seoDescriptionMaxLength(): int
    {
        return 160;
    }

    public function seoTitleSuffixes(): array
    {
        return ['brand', 'brand2'];
    }

    public function TagModel(): string
    {
        return config('site.models.tag', Tag::class);
    }
}
