<?php

namespace Darko\FilamentContentToolkits\Resources;

use Darko\FilamentAutoTranslate\Actions\Table\Translate;
use Darko\FilamentContentToolkits\Resources\Traits\Translatable;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class Resource extends BaseResource
{
    use Translatable;

    protected static function actions(): array
    {
        return [
            EditAction::make()->iconButton(),
            DeleteAction::make()->iconButton(),
            Translate::make()->iconButton(),
        ];
    }
}
