<?php

namespace Darko\FilamentContentToolkits\Pages;

use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord as BasePage;
use Darko\FilamentContentToolkits\Pages\Traits\NestedCreateRelatedRecord\Translatable;

class NestedCreateRelatedRecord extends BasePage
{
    use NestedPage, Translatable;

    protected static bool $canCreateAnother = false;
    protected static string $resource;
    protected static string $relationship;

    protected function getRedirectUrl(): string
    {
        return $this->getUrl(['record' => $this->getOwnerRecord()]);
    }
}
