<?php

namespace Darko\FilamentContentToolkits\Pages\Traits\EditRecord;

use Filament\Resources\Pages\EditRecord\Concerns\Translatable as BaseTranslatable;
use Illuminate\Support\Facades\Cache;

trait Translatable
{
    use BaseTranslatable;

    // protected function getDefaultTranslatableLocale(): string
    // {
    //     return Cache::get('activeLocale', config('app.fallback_locale'));
    // }

    // public function updatedActiveLocale(): void
    // {
    //     Cache::set('activeLocale', $this->activeLocale);
    //     $this->js('window.location.reload()');
    // }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getUrl(['record' => $this->getRecord()]);
    // }
}
