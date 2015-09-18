<?php

return [
    'User' => [
        'profile' => function (Illuminate\Database\Eloquent\Model $self) {
            return $self->belongsTo('Modules\Village\Entities\Profile', 'id', 'user_id')->first();
        }
    ]
];