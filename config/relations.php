<?php

return [
    'User' => [
        'profile' => function ($self) {
            return $self->belongsTo('Modules\Village\Entities\Profile', 'id', 'user_id')->first();
        }
    ]
];