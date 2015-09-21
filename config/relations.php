<?php

return [
    'User' => [
        'building' => function (Illuminate\Database\Eloquent\Model $self) {
            return $self->belongsTo('Modules\Village\Entities\Building', 'building_id', 'id');
        }
    ]
];