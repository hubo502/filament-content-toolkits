<?php

namespace Darko\FilamentContentToolkits\Pages;

use Filament\Actions\CreateAction;
use Darko\FilamentAutoTranslate\Actions\Translate;
use Darko\FilamentAutoTranslate\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ManageRecords as BasePage;
use Filament\Resources\Pages\ManageRecords\Concerns\Translatable;


class ManageRecords extends BasePage
{
    use Translatable;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
            Translate::make()->modelForAll(static::$resource::getModel())->outlined(),
        ];
    }
}
