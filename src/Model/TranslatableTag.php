<?php

namespace Darko\FilamentContentToolkits\Model;

use Darko\AutoTranslate\Contracts\Models\AutoTranslatable;
use Darko\AutoTranslate\Models\Traits\JustAutoTranslate;
use Illuminate\Database\Eloquent\Model;

class TranslatableTag extends Tag implements AutoTranslatable
{
    use JustAutoTranslate;

    public static function bootHasSlug()
    {
        static::saving(function (Model $model) {

            if (empty($model->slug)) {
                $model->slug = $model->generateSlug(config('app.fallback_locale'));
            }
        });
    }

    public static function findFromString(string $name, ?string $type = null, ?string $locale = null)
    {
        $locale = $locale ?? config('app.fallback_locale', 'en');

        return static::query()
            ->where('type', $type)
            ->where(function ($query) use ($name, $locale) {
                $query->where("name->{$locale}", $name)
                    ->orWhere('slug', $name);
            })
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, ?string $locale = null)
    {
        $locale = $locale ?? config('app.fallback_locale');

        return static::query()
            ->where("name->{$locale}", $name)
            ->orWhere('slug', $name)
            ->get();
    }
}
