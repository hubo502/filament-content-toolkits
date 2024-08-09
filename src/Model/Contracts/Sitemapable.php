<?php

namespace Darko\FilamentContentToolkits\Model\Contracts;

interface Sitemapable
{
    public static function generateSitemap(): void;
}
