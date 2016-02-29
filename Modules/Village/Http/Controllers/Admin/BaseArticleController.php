<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\BaseArticle;
use Modules\Village\Repositories\BaseArticleRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class BaseArticleController extends AdminController
{
    /**
     * @param BaseArticleRepository $article
     */
    public function __construct(BaseArticleRepository $article)
    {
        parent::__construct($article, BaseArticle::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'basearticles';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__base__articles.id',
            'village__base__articles.title',
            'village__base__articles.active',
            'village__base__articles.created_at'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__base__articles.active', 1);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'title' => $this->trans('table.id')])
            ->addColumn(['data' => 'title', 'name' => 'village__base__articles.title', 'title' => $this->trans('table.title')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'active', 'name' => 'village__base__articles.active', 'title' => $this->trans('table.active')])
            ;
        }

        $builder
            ->addColumn(['data' => 'created_at', 'name' => 'village__base__articles.created_at', 'title' => $this->trans('table.created_at')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
            ->addColumn('created_at', function (BaseArticle $article) {
                return localizeddate($article->created_at);
            })
        ;

        $dataTable
            ->addColumn('active', function (BaseArticle $article) {
                if($article->active) {
                    return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                }
                else {
                    return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                }
            })
        ;
    }

    /**
     * @param array   $data
     * @param BaseArticle $article
     *
     * @return Validator
     */
    public function validate(array $data, BaseArticle $article = null)
    {
        $rules = [
            'title' => "required|max:255",
            'text' => "required",
            'active' => "required|boolean",
        ];

        return Validator::make($data, $rules);
    }
}
