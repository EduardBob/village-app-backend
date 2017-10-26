<?php

return [
    'village.packet' => [
       'change',
       'pay'
     ],
    'village.villages' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'packetchange'
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
        'baseCopy',
        'makePersonal',
    ],
    'village.articlecategories' => [
      'index',
      'create',
      'store',
      'edit',
      'update',
      'destroy',
    ],
    'village.documentcategories' => [
      'index',
      'create',
      'store',
      'edit',
      'update',
      'destroy',
    ],
    'village.documents' => [
      'index',
      'create',
      'store',
      'edit',
      'update',
      'destroy',
      'makePersonal',
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
        'baseCopy',
        'getChoicesByVillage',
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
	    'setPaymentDone',
	    'setPaymentAndStatusDone',
    ],
    'village.productorderchanges' => [
        'index',
    ],
    'village.baseservices' => [
        'index',
        'show',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'village.services' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
        'baseCopy',
        'getChoicesByVillage',
    ],
    'village.servicecategories' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
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
	    'setPaymentDone',
	    'setPaymentAndStatusDone',
    ],
    'village.serviceorderssc' => [
        'index',
    ],
    'village.serviceordersscnew' => [
        'index',
        'create',
        'store',
        'setStatusDoneAndOpenDoor',
        'setStatusDoneAndOpenBarrier',
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
