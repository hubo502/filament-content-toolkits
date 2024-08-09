<?php

namespace Darko\FilamentContentToolkits\Resources;

use Filament\Forms\Components\Group;

class NestedResourceWithSidebar extends NestedResource
{
    protected const FORM_COLUMNS = 3;

    protected static function schema_main(): array
    {
        return [];
    }

    protected static function schema_sidebar(): array
    {
        return [];
    }

    protected static function schema(): array
    {
        return [
            Group::make()->schema(static::schema_main())->columnSpan(2),
            Group::make()->schema(static::schema_sidebar())->columnSpan(1),
        ];
    }
}
