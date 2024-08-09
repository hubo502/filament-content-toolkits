<?php

use Spatie\Image\Enums\Fit;

return [
    'conversion' => [
        'cover' => [
            'cover' => [Fit::Crop, 1000, 500],
            'thumbnail' => [Fit::Crop, 800, 450],
        ],
    ],
    'seo' => [
        'title_max_length' => 60,
        'desc_max_length' => 160,
    ],
];
