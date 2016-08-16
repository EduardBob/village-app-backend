<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\Article;
use Modules\Village\Entities\BaseArticle;
use Modules\Village\Repositories\ArticleRepository;
use Modules\Village\Repositories\ArticleCategoryRepository;
use Modules\Village\Entities\ArticleCategory;


use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ArticleController extends AdminController
{



    /**
     * @var ProductCategoryRepository
     */
    protected $categoryRepository;

    public function __construct(ArticleRepository $article,  ArticleCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct($article, Article::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__articles.id',
            'village__articles.village_id',
            'village__articles.title',
            'village__articles.active',
            'village__articles.created_at',
            'village__articles.published_at'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__articles.village_id', '=', 'village__villages.id')
            ->leftJoin('village__article_categories', 'village__articles.category_id', '=', 'village__article_categories.id')
            ->where('village__villages.deleted_at', null)
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__articles.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {

        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__articles.id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'category_title', 'name' => 'village__article_categories.title', 'title' => $this->trans('table.category')])
            ->addColumn(['data' => 'title', 'name' => 'village__articles.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'active', 'name' => 'village__articles.active', 'title' => $this->trans('table.active')])
            ->addColumn(['data' => 'created_at', 'name' => 'village__articles.created_at', 'title' => $this->trans('table.created_at')])
            ->addColumn(['data' => 'published_at', 'name' => 'village__articles.published_at', 'title' => $this->trans('table.published_at')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
              ->editColumn('category_title', function (Article $article) {
                  if ($this->getCurrentUser()->hasAccess('village.articlecategories.edit')) {

                      return '<a href="'.route('admin.village.articlecategory.edit', ['id' => 3]).'">xxx</a>';
                      return 'zzz';
                  }
                  else {
                      return $article->category->title;
                  }
              })
                ->editColumn('village_name', function (Article $article) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $article->village->id]).'">'.$article->village->name.'</a>';
                    }
                    else {
                        return $article->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('created_at', function (Article $article) {
                return localizeddate($article->created_at);
            })
        ;

        $dataTable
            ->addColumn('active', function (Article $article) {
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
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preStore(Model $model, Request $request)
    {
        parent::preStore($model, $request);

        if ($request->get('show_all')) {
            $baseModel = new BaseArticle();
            $data = $model->toArray();
            $data['active'] = 1;
            $baseModel->fill($data)->save();
        }
    }

	/**
	 * @inheritdoc
	 */
	public function successStoreMessage()
	{
		flash()->success(trans('village::admin.messages.you_can_add_image'));
	}

    /**
     * @param int $baseId
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function baseCopy($baseId)
    {
        $model = BaseArticle::find($baseId);

        if (!$this->getCurrentUser()->inRole('admin') && !$model->active) {
            return redirect()->route($this->getRoute('index'));
        }

	    view()->share('baseCopy', true);

        return view($this->getView('baseCopy'), $this->mergeViewData(compact('model')));
    }

    /**
     * @param array   $data
     * @param Article $article
     *
     * @return Validator
     */
    public function validate(array $data, Article $article = null)
    {
        $rules = [
            'title' => "required|max:255",
            'text' => "required",
            'active' => "required|boolean",
        ];

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        $attributes = [];
        if (!$this->getCurrentUser()->inRole('admin')){
            if ($this->getCurrentUser()->village) {
                $attributes = ['active' => 1];
            }
        }

        return $this->categoryRepository->lists($attributes, 'title', 'id', ['order' => 'desc']);
    }


}
