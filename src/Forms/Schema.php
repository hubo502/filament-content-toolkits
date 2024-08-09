<?php
namespace Darko\FilamentContentToolkits\Forms;

use Darko\FilamentContentToolkits\Facades\Site;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;

class Schema
{
    public static function SEO(): Fieldset
    {
        return Fieldset::make()->label("SEO")->columns(1)
            ->schema([
                Textarea::make('seo_title')->label('Title')->rows(2)->helperText(HelperText::charLimit(Site::seoTitleMaxLength()))->reactive(),
                Textarea::make('seo_desc')->label('Description')->rows(4)->helperText(HelperText::charLimit(Site::seoDescriptionMaxLength()))->reactive(),
            ]);
    }
}
