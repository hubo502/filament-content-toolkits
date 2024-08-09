<?php

namespace Darko\FilamentContentToolkits\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class TitleDescColumn
{
    public static function make(?string $title = 'title', ?string $desc = 'content')
    {
        return TextColumn::make($title)->description(
            function (Model $record) use ($desc): View {
                return view('filament-content-toolkits::tables.columns.title-desc', ['text' => $record?->$desc]);
            }
        )->wrap();
    }
}
