<?php

namespace Darko\FilamentContentToolkits\Model;

use ArrayAccess;
use Darko\FilamentContentToolkits\Model\Concerns\HasSeo;
use Darko\FilamentContentToolkits\Model\Concerns\HasSitemap;
use Darko\FilamentContentToolkits\Model\Contracts\Seoable;
use Darko\FilamentContentToolkits\Model\Contracts\Sitemapable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasSlug;
use Spatie\Translatable\HasTranslations;

class Tag extends Model implements Sortable, Seoable, HasMedia, Sitemapable
{
    use InteractsWithMedia;
    use HasSeo;
    use SoftDeletes;
    use HasSitemap;
    use SortableTrait;
    use HasTranslations;
    use HasSlug;
    use HasFactory;

    public array $translatable = ['name', 'slug'];

    public $guarded = [];

    public static function getCurrentLocale()
    {
        return app()->getLocale();
    }

    public function scopeWithType(Builder $query, string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->ordered();
    }

    public function scopeContaining(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? static::getCurrentLocale();

        return $query->whereRaw('lower(' . $this->getQuery()->getGrammar()->wrap('name->' . $locale) . ') like ?', ['%' . mb_strtolower($name) . '%']);
    }

    public static function findOrCreate(
        string | array | ArrayAccess $values,
        string | null $type = null,
        string | null $locale = null,
    ): Collection | Tag | static {
        $tags = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->get();
    }

    public static function findFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? static::getCurrentLocale();

        return static::query()
            ->where('type', $type)
            ->where(function ($query) use ($name, $locale) {
                $query->where("name->{$locale}", $name)
                    ->orWhere("slug->{$locale}", $name);
            })
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, string $locale = null)
    {
        $locale = $locale ?? static::getCurrentLocale();

        return static::query()
            ->where("name->{$locale}", $name)
            ->orWhere("slug->{$locale}", $name)
            ->get();
    }

    public static function findOrCreateFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? static::getCurrentLocale();

        $tag = static::findFromString($name, $type, $locale);

        if (!$tag) {
            $tag = static::create([
                'name' => [$locale => $name],
                'type' => $type,
            ]);
        }

        return $tag;
    }

    public static function getTypes(): Collection
    {
        return static::groupBy('type')->pluck('type');
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatable) && !is_array($value)) {
            return $this->setTranslation($key, static::getCurrentLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }
}
