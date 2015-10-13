<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\ServiceCategory;

class ServiceCategoryTransformer extends BaseTransformer
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
            'image' => $this->getImage($serviceCategory->files()->first()),
        ];
    }
}