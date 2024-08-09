<?php

namespace Darko\FilamentContentToolkits\Pages;

use Darko\FilamentContentToolkits\Pages\Traits\NestedCreateRelatedRecord\Translatable;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord as BasePage;

class NestedCreateRelatedRecord extends BasePage
{
    use NestedPage;
    use Translatable;

    protected static bool $canCreateAnother = false;

    protected static string $resource;

    protected static string $relationship;

    protected function getRedirectUrl(): string
    {
        return $this->getUrl(['record' => $this->getOwnerRecord()]);
    }
}
