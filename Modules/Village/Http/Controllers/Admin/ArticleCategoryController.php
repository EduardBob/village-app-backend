<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ArticleCategory;
use Modules\Village\Repositories\ArticleCategoryRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ArticleCategoryController extends AdminController
{
    /**
     * @param ArticleCategoryRepository $ArticleCategory
     */
    public function __construct(ArticleCategoryRepository $ArticleCategory)
    {
        parent::__construct($ArticleCategory, ArticleCategory::class);
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
        return [
            'village__article_categories.id',
            'village__article_categories.title',
            'village__article_categories.order',
            'village__article_categories.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
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
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
            ->addColumn('active', function (ArticleCategory $ArticleCategory) {
                if($ArticleCategory->active) {
                    return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                }
                else {
                    return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                }
            })
        ;
    }

	/**
	 * @inheritdoc
	 */
	public function successStoreMessage()
	{
		flash()->success(trans('village::admin.messages.you_can_add_image'));
	}

    /**
     * @param array           $data
     * @param ArticleCategory $ArticleCategory
     *
     * @return mixed
     */
    public function validate(array $data, ArticleCategory $ArticleCategory = null)
    {
        $rules = [
            'title' => "required|max:255",
            'active' => "boolean",
        ];

        return Validator::make($data, $rules);
    }
}