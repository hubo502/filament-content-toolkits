<?php

namespace Darko\FilamentContentToolkits\Resources\Traits;

use Darko\AutoTranslate\Facades\AutoTranslator;
use Filament\Resources\Concerns\Translatable as Base;

trait Translatable
{
    use Base;

    public static function getDefaultTranslatableLocale(): string
    {
        return AutoTranslator::base_locale();
    }

    public static function getTranslatableLocales(): array
    {
        return AutoTranslator::locales();
    }
}
