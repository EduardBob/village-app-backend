<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\DocumentCategory;
use Modules\Village\Repositories\DocumentCategoryRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class DocumentCategoryController extends AdminController
{
    /**
     * @param DocumentCategoryRepository $documentCategory
     */
    public function __construct(DocumentCategoryRepository $documentCategory)
    {
        parent::__construct($documentCategory, DocumentCategory::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'documentcategories';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return ['village__document_categories.*'];
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
          ->addColumn(['data' => 'id', 'name' => 'village__document_categories.id', 'title' => $this->trans('table.id')])
          ->addColumn(['data' => 'title', 'name' => 'village__document_categories.title', 'title' => $this->trans('table.title')])
          ->addColumn(['data' => 'order', 'name' => 'village__document_categories.order', 'title' => $this->trans('table.order')])
          ->addColumn(['data' => 'active', 'name' => 'village__document_categories.active', 'title' => $this->trans('table.active')])
          ->addColumn(['data' => 'is_global', 'name' => 'village__document_categories.active', 'title' => $this->trans('title.is_global')]);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
          ->addColumn('active', function (DocumentCategory $documentCategory) {
              return boolField($documentCategory->active);
          })
          ->addColumn('is_global', function (DocumentCategory $documentCategory) {
              return boolField($documentCategory->is_global);
          });
    }

    /**
     * @inheritdoc
     */
    public function successStoreMessage()
    {
        flash()->success(trans('village::admin.messages.you_can_add_image'));
    }

    /**
     * @param array $data
     * @param DocumentCategory $documentCategory
     *
     * @return mixed
     */
    public function validate(array $data, DocumentCategory $documentCategory = null)
    {
        $rules = [
          'title'     => "required|max:255",
          'active'    => "boolean",
          'is_global' => "boolean",
        ];

        return Validator::make($data, $rules);
    }

    /**
     * @param Model   $model
     */
    public function preDestroy(Model $model)
    {

        if (!$model instanceof Model) {
            $model = $this->getRepository()->find($model);
        }

        $redirect = $this->checkPermissionDenied($model);
        if ($redirect !== false) {
            return $redirect;
        }
        if ($model->documents) {
            foreach ($model->documents as $document) {
                $document->delete();
            }
        }

    }
}
