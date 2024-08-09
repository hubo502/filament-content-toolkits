<?php

namespace Darko\FilamentContentToolkits\Enums;

trait AsOptions
{
    abstract public static function cases();

    public static function asOptions(): array
    {
        $cases = static::cases();

        return collect($cases)
            ->mapWithKeys(static fn (self $enum): array => [
                strval($enum->value) => strtolower($enum->value),
            ])->toArray();
    }
}
