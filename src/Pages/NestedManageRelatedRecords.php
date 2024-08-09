<?php

namespace Darko\FilamentContentToolkits\Pages;

use Darko\FilamentAutoTranslate\Actions\Table\LocaleSwitcher;
use Darko\FilamentAutoTranslate\Actions\Table\Translate;
use Darko\FilamentContentToolkits\Pages\Traits\NestedManageRelatedRecords\Translatable;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Concerns\NestedRelationManager;

class NestedManageRelatedRecords extends ManageRelatedRecords
{
    use NestedPage;
    use NestedRelationManager;
    use Translatable;

    protected static string $resource;
    protected static string $relationship;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $titleColumn = 'name';

    protected static function schema(): array
    {
        return [];
    }

    protected static function columns(): array
    {
        return [];
    }

    protected static function filters(): array
    {
        return [
            TrashedFilter::make(),
        ];
    }

    protected static function actions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            Translate::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $this->configTable(
            $table->recordTitleAttribute(static::$titleColumn)
                ->columns(static::columns())
                ->filters(static::filters())
                ->headerActions(static::headerActions())
                ->actions(static::actions())
                ->bulkActions(BulkActionGroup::make(static::bulkActions()))
        );
    }

    protected function configTable(Table $table): Table
    {
        return $table;
    }

    protected static function bulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema(static::schema());
    }

    protected static function headerActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
