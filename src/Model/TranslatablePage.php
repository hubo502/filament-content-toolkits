<?php

namespace Darko\FilamentContentToolkits\Model;

use Darko\AutoTranslate\Contracts\Models\AutoTranslatable;
use Darko\AutoTranslate\Models\Traits\HasAutoTranslate;

abstract class TranslatablePage extends Page implements AutoTranslatable
{
    use HasAutoTranslate;

    public $json_translatable = ['title', 'description', 'content'];

    protected $casts = [
        'blocks' => 'array',
    ];

}
