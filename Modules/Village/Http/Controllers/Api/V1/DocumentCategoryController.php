<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\DocumentCategory;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\DocumentCategoryTransformer;

class DocumentCategoryController extends ApiController
{
    /**
     * Get all DocumentCategory
     *
     * @return Response
     */
    public function index()
    {
        $categories = DocumentCategory::api()->orderBy('order', 'asc')->get();
        return $this->response->withCollection($categories, new DocumentCategoryTransformer);
    }
}
