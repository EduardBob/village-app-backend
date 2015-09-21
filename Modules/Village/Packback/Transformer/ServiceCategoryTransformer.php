<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\ServiceCategory;

class ServiceCategoryTransformer extends TransformerAbstract
{
    /**
     * Turn user object into generic array
     *
     * @param ServiceCategory $serviceCategory
     * @return array
     */
    public function transform(ServiceCategory $serviceCategory)
    {
        return [
            'id' =>  $serviceCategory->id,
            'title' => $serviceCategory->title,
        ];
    }
}