<?php

return [
    'smallThumb' => [
        'resize' => [
            'width' => 33,
            'height' => null,
            'callback' => function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            },
        ],
    ],
    'mediumThumb' => [
        'resize' => [
            'width' => 110,
            'height' => null,
            'callback' => function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            },
        ],
    ],
];
