<?php

namespace Darko\FilamentContentToolkits\Pages;

use Darko\FilamentAutoTranslate\Actions\LocaleSwitcher;
use Filament\Resources\Pages\CreateRecord as BaseCreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateRecord extends BaseCreateRecord
{
    use Translatable;

    protected static string $resource;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
