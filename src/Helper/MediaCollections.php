<?php

namespace Darko\FilamentContentToolkits\Helper;

class MediaCollections
{
    public static function cover($model)
    {
        $model->addMediaCollection('cover');
    }

    public static function images($model)
    {
        $model->addMediaCollection('images');
    }
}
