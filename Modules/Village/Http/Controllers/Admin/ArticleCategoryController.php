<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Village\Entities\ArticleCategory;
use Modules\Village\Repositories\ArticleCategoryRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ArticleCategoryController extends AdminController
{
    /**
     * @param ArticleCategoryRepository $articleCategory
     */
    public function __construct(ArticleCategoryRepository $articleCategory)
    {
        parent::__construct($articleCategory, ArticleCategory::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'articlecategories';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return ['village__article_categories.*'];
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
          ->addColumn(['data' => 'id', 'name' => 'village__article_categories.id', 'title' => $this->trans('table.id')])
          ->addColumn(['data' => 'title', 'name' => 'village__article_categories.title', 'title' => $this->trans('table.title')])
          ->addColumn(['data' => 'order', 'name' => 'village__article_categories.order', 'title' => $this->trans('table.order')])
          ->addColumn(['data' => 'active', 'name' => 'village__article_categories.active', 'title' => $this->trans('table.active')])
          ->addColumn(['data' => 'is_global', 'name' => 'village__article_categories.active', 'title' => $this->trans('title.is_global')]);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
          ->addColumn('active', function (ArticleCategory $articleCategory) {
              if ($articleCategory->active) {
                  return '<span class="label label-success">' . trans('village::admin.table.active.yes') . '</span>';
              }
              return '<span class="label label-danger">' . trans('village::admin.table.active.no') . '</span>';
          })
          ->addColumn('is_global', function (ArticleCategory $articleCategory) {
              if ($articleCategory->is_global) {
                  return '<span class="label label-success">' . trans('village::admin.table.active.yes') . '</span>';
              }
              return '<span class="label label-danger">' . trans('village::admin.table.active.no') . '</span>';
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
     * @param ArticleCategory $articleCategory
     *
     * @return mixed
     */
    public function validate(array $data, ArticleCategory $articleCategory = null)
    {
        $rules = [
          'title'     => "required|max:255",
          'active'    => "boolean",
          'is_global' => "boolean",
        ];

        return Validator::make($data, $rules);
    }
}
