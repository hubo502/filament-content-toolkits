<?php

namespace Darko\FilamentContentToolkits\Helper;

use Spatie\MediaLibrary\HasMedia;

class MediaConversions
{
    public static function cover(HasMedia $model)
    {
        static::conversion($model, 'cover');
    }

    public static function thumbnail() {}

    protected static function conversion(HasMedia $model, string $collection): void
    {
        collect(config("site.conversion.{$collection}", []))->each(function ($fit, $conversion) use ($model, $collection) {
            $model->addMediaConversion($conversion)->performOnCollections($collection)->fit(...$fit)->format('webp');
        });
    }
}
