<?php

return [
    'village.villages' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.buildings' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'getChoicesByVillage'
    ],
    'village.basearticles' => [
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.articles' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'baseCopy'
    ],
    'village.margins' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.baseproducts' => [
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.products' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'baseCopy'
    ],
    'village.productcategories' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.productorders' => [
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'setStatusRunning',
        'setStatusDone',
    ],
    'village.productorderchanges' => [
        'index',
    ],
    'village.services' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.servicecategories' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'getChoicesByVillage',
    ],
    'village.serviceorders' => [
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'setStatusRunning',
        'setStatusDone',
    ],
    'village.serviceorderchanges' => [
        'index',
    ],
    'village.basesurveys' => [
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.surveys' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'baseCopy',
    ],
    'village.surveyvotes' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.sms' => [
//        'index',
//        'create',
//        'store',
//        'edit',
//        'update',
//        'destroy',
        'send',
    ],
//    'village.tokens' => [
//        'index',
//        'create',
//        'store',
//        'edit',
//        'update',
//        'destroy',
//    ],
];
