<?php

namespace Darko\FilamentContentToolkits\Forms;

class HelperText
{
    public static function charLimit(int $limit = 200): \Closure
    {
        return fn (?string $state) => strlen($state) . " / {$limit} characters";
    }
}
