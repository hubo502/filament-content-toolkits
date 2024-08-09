<?php

namespace Darko\FilamentContentToolkits\Pages;

use Darko\FilamentAutoTranslate\Actions\LocaleSwitcher;
use Darko\FilamentAutoTranslate\Actions\Translate;
use Filament\Actions\CreateAction;
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
