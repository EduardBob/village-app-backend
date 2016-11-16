<?php

return [
    'smallThumb' => [
        'fit' => [
            'width' => 33,
            'height' => 33,
            'position' => 'center',
            'callback' => function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            },
        ],
    ],
    'mediumThumb' => [
        'fit' => [
            'width' => 110,
            'height' => 110,
            'position' => 'center',
            'callback' => function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            },
        ],
    ],
    'bigThumb' => [
        'resize' => [
            'width' => 415,
            'height' => null,
            'callback' => function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            },
        ],
    ],
    'biggerThumb' => [
      'resize' => [
        'width' => 1080,
        'callback' => function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        },
      ],
    ],
];
