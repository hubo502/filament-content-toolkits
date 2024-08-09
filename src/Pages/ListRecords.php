<?php

namespace Darko\FilamentContentToolkits\Pages;

use Darko\FilamentAutoTranslate\Actions\LocaleSwitcher;
use Darko\FilamentAutoTranslate\Actions\Translate;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords as BasePage;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

abstract class ListRecords extends BasePage
{
    use Translatable;

    protected static string $resource;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
            Translate::make()->modelForAll(static::$resource::getModel())->outlined(),
        ];
    }
}
