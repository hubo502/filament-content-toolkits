<?php

namespace Darko\FilamentContentToolkits\Resources;

use Darko\FilamentContentToolkits\Resources\Traits\Nested;
use Guava\FilamentNestedResources\Ancestor;
use Illuminate\Database\Eloquent\Model;

class NestedResource extends Resource
{
    use Nested;

    public static function getBreadcrumbRecordLabel(Model $record)
    {
        return "{$record->name}";
    }

    public static function getAncestor(): ?Ancestor
    {
        return null;
    }
}
