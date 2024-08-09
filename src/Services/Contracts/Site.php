<?php

namespace Darko\FilamentContentToolkits\Services\Contracts;

interface Site
{
    public function name(): string;

    public function abbv(): string;

    public function setSeo(string $title, string $description, ?string $url): void;

    public function seoUseBrand(): bool;
}
