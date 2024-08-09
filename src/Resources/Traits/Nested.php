<?php

namespace Darko\FilamentContentToolkits\Resources\Traits;

use Filament\Facades\Filament;
use Guava\FilamentNestedResources\Ancestor;
use Illuminate\Database\Eloquent\Model;

trait Nested
{
    abstract public static function getAncestor(): ?Ancestor;

    protected static function resolveIndexUrlByParent(Model $record): ?string
    {
        $resource = static::class;

        $ancestor = $resource::getAncestor();

        if (!$ancestor) {
            return null;
        }

        $parent = $ancestor->getRelatedRecord($record);
        $relationship = $ancestor->getRelationshipName();
        $parentResource = Filament::getModelResource($parent);

        if ($parentResource::hasPage($relationship)) {
            return $parentResource::getUrl($relationship, ['record' => $parent]);
        } else {
            return null;
        }
    }

    public static function getBreadcrumbs(Model $record, string $operation): array
    {
        $resource = static::class;
        $indexUrlByParent = static::resolveIndexUrlByParent($record);
        $indexUrl = match (true) {
            !empty($indexUrlByParent) => $indexUrlByParent,
            $resource::hasPage('index') => $resource::getUrl('index'),
            default => null,
        };

        $detailUrl = match (true) {
            $resource::hasPage($operation) => $resource::getUrl($operation, [
                'record' => $record,
            ]),

            $resource::hasPage('view') => $resource::getUrl('view', [
                'record' => $record,
            ]),

            $resource::hasPage('edit') => $resource::getUrl('edit', [
                'record' => $record,
            ]),
        };

        $indexUrl ??= "$detailUrl#list";

        return [
            $indexUrl => $resource::getBreadcrumb(),
            $detailUrl => static::getBreadcrumbRecordLabel($record),
        ];
    }

    public static function getBreadcrumbRecordLabel(Model $record)
    {
        return $record->getRouteKey();
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (static::getAncestor()) {
            return false;
        }

        return parent::shouldRegisterNavigation();
    }
}
