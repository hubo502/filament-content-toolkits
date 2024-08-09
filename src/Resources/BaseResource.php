<?php

namespace Darko\FilamentContentToolkits\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class BaseResource extends Resource
{
    protected static ?string $model;

    protected const FORM_COLUMNS = 2;

    protected static ?array $paginated = [10, 20, 50];

    protected static function schema(): array
    {
        return [];
    }

    protected static function columns(): array
    {
        return [];
    }

    public static function form(Form $form): Form
    {
        return $form->columns(static::FORM_COLUMNS)->schema(static::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::columns())
            ->filters(static::filters())
            ->actions(static::actions())
            ->bulkActions(BulkActionGroup::make(static::bulkActions()))
            ->paginated(static::$paginated);
    }

    protected static function filters(): array
    {
        return [];
    }

    protected static function actions(): array
    {
        return [
            EditAction::make()->iconButton(),
            DeleteAction::make()->iconButton(),
        ];
    }

    protected static function bulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}
