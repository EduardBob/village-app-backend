<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\DocumentCategory;

class DocumentCategoryTransformer extends BaseTransformer
{
    /**
     * Turn user object into generic array
     *
     * @param DocumentCategory $category
     * @return array
     */
    public function transform(DocumentCategory $category)
    {
        return [
          'id'    => $category->id,
          'title' => $category->title,
        ];
    }
}
