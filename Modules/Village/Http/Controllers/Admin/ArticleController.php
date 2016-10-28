<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\Article;
use Modules\Village\Entities\BaseArticle;
use Modules\Village\Repositories\ArticleCategoryRepository;
use Modules\Village\Repositories\ArticleRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;


class ArticleController extends AdminController
{

    /**
     * @var ArticleCategoryRepository
     */
    protected $categoryRepository;

    public function __construct(ArticleRepository $article, ArticleCategoryRepository $categoryRepository)
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
        return ['village__articles.*'];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
          ->leftJoin('village__villages', 'village__articles.village_id', '=', 'village__villages.id')
          ->leftJoin('village__article_categories', 'village__articles.category_id', '=', 'village__article_categories.id')
          ->where('village__villages.deleted_at', null)
          ->with(['village']);

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__articles.village_id', $this->getCurrentUser()->village->id);
            // Global admin can protect articles, articles are hidden from other user groups.
            $query->where('village__articles.is_protected', 0);
        }

        if (!$this->getCurrentUser()->hasAccess('village.articles.makePersonal')) {
            $query->where('village__articles.is_personal', 0);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {

        $builder
          ->addColumn(['data' => 'id', 'name' => 'village__articles.id', 'title' => $this->trans('table.id')]);

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
              ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')]);
        }
        $builder
          ->addColumn(['data' => 'category_title', 'name' => 'village__article_categories.title', 'title' => $this->trans('table.category')])
          ->addColumn(['data' => 'title', 'name' => 'village__articles.title', 'title' => $this->trans('table.title')])
          ->addColumn(['data' => 'active', 'name' => 'village__articles.active', 'title' => $this->trans('table.active')])
          ->addColumn(['data' => 'is_important', 'name' => 'village__articles.is_important', 'title' => $this->trans('table.is_important')])

          ->addColumn(['data' => 'created_at', 'name' => 'village__articles.created_at', 'title' => $this->trans('table.created_at')])
          ->addColumn(['data' => 'published_at', 'name' => 'village__articles.published_at', 'title' => $this->trans('table.published_at')]);
        if($this->getCurrentUser()->hasAccess('village.articles.makePersonal')){
            $builder ->addColumn(['data' => 'is_personal', 'name' => 'village__articles.is_personal', 'title' => $this->trans('table.is_personal')]);
              }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
              ->editColumn('village_name', function (Article $article) {
                  if (!is_null($article->village) && $this->getCurrentUser()->hasAccess('village.villages.edit')) {
                      return '<a href="' . route('admin.village.village.edit', ['id' => $article->village->id]) . '">' . $article->village->name . '</a>';
                  } elseif (!is_null($article->village)) {
                      return $article->village->name;
                  }
              });
        }

        $dataTable
          ->editColumn('category_title', function (Article $article) {
              if ($this->getCurrentUser()->hasAccess('village.articlecategories.edit')) {
                  return '<a href="' . route('admin.village.articlecategory.edit', ['id' => $article->category->id]) . '">' . $article->category->title . '</a>';
              }
              return $article->category->title;
          });

        $dataTable
          ->addColumn('published_at', function (Article $article) {
              return localizeddate($article->published_at);
          });

        $dataTable
          ->addColumn('created_at', function (Article $article) {
              return localizeddate($article->created_at);
          });

        $dataTable
          ->addColumn('active', function (Article $article) {
             return boolField($article->active);
          });

        $dataTable
          ->addColumn('is_important', function (Article $article) {
              return boolField($article->is_important);
          });

        $dataTable
          ->addColumn('is_personal', function (Article $article) {
              return boolField($article->is_personal);
          });

    }

    /**
     * Store a newly created resource in storage. Add users to article
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStore(Model $model, Request $request)
    {
        parent::preStore($model, $request);
        if ($request->get('users')) {
            $users = $request->get('users');
            $model->users()->attach($users);
        }
        if ($request->get('buildings')) {
            $buildings = $request->get('buildings');
            $model->buildings()->attach($buildings);
        }
        if ($request->get('show_all')) {
            $baseModel      = new BaseArticle();
            $data           = $model->toArray();
            $data['active'] = 1;
            $baseModel->fill($data)->save();
        }
    }

    /**
     * Store a newly created resource in storage. Add users to article
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preUpdate(Model $model, Request $request)
    {
        parent::preStore($model, $request);
        if ($request->get('users')) {
            $users = $request->get('users');
            $model->users()->sync($users);
        }
        if ($request->get('buildings')) {
            $buildings = $request->get('buildings');
            $model->buildings()->sync($buildings);
        }
        // Attaching all users from selected user group to an article.
        if ($request->get('is_personal') == 1 && empty($request->get('users'))) {
            $model->users()->sync([]);
        }
        if ($request->get('is_personal') == 1 && empty($request->get('buildings'))) {
            $model->buildings()->sync([]);
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
     * @param array $data
     * @param Article $article
     *
     * @return Validator
     */
    public function validate(array $data, Article $article = null)
    {
        $rules = [
          'title'  => "required|max:255",
          'text'   => "required",
          'active' => "required|boolean",
        ];
        
        if ($this->getCurrentUser()->inRole('admin')) {
             $rules['village_id'] = 'exists:village__villages,id';
        }
        if ((bool)$data['is_personal']) {
            $rules['village_id'] = 'required:village__villages,id';
            $rules['role_id'] = 'exists:roles,id';
        }
        if ((bool)$data['is_personal'] && $data['role_id'] == '') {
            $rules['users'] = "required|exists:users,id";
        }

        if ((bool)$data['is_personal'] && empty($data['users'])) {
            $rules['role_id'] = "required";
        }

        return Validator::make($data, $rules);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        $attributes = [];
        if (!$this->getCurrentUser()->inRole('admin') && $this->getCurrentUser()->village) {
                $attributes = ['is_global' => 1, 'active' => 1];
        }

        return $this->categoryRepository->lists($attributes, 'title', 'id', ['order' => 'desc']);
    }
}
