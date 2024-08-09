<?php

namespace Darko\FilamentContentToolkits\Pages;

use Darko\FilamentAutoTranslate\Actions\LocaleSwitcher;
use Darko\FilamentAutoTranslate\Actions\Translate;
use Darko\FilamentContentToolkits\Pages\Traits\EditRecord\Translatable;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as BaseEditRecord;

class EditRecord extends BaseEditRecord
{
    use Translatable;

    protected static string $resource;

    protected function getActions(): array
    {
        return [
            LocaleSwitcher::make(),
            DeleteAction::make(),
            Translate::makeGroup(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getUrl(['record' => $this->getRecord()]);
    }
}
