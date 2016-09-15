<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\Document;
use Modules\Village\Repositories\DocumentCategoryRepository;
use Modules\Village\Repositories\DocumentRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;


class DocumentController extends AdminController
{

    /**
     * @var ArticleCategoryRepository
     */
    protected $categoryRepository;

    public function __construct(DocumentRepository $document, DocumentCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct($document, Document::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return ['village__documents.*'];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
          ->leftJoin('village__villages', 'village__documents.village_id', '=', 'village__villages.id')
          ->where('village__villages.deleted_at', null)
          ->with(['village']);

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__documents.village_id', $this->getCurrentUser()->village->id);
            // Global admin can protect items, documents are hidden from other user groups.
            $query->where('village__documents.is_protected', 0);
        }

        if (!$this->getCurrentUser()->hasAccess('village.documents.makePersonal')) {
            $query->where('village__documents.is_personal', 0);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {

        $builder
          ->addColumn(['data' => 'id', 'name' => 'village__documents.id', 'title' => $this->trans('table.id')]);

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
              ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')]);
        }
        $builder
         ->addColumn(['data' => 'category_title', 'name' => 'village__document_categories.title', 'title' => $this->trans('table.category_id')])
          ->addColumn(['data' => 'title', 'name' => 'village__documents.title', 'title' => $this->trans('table.title')])
          ->addColumn(['data' => 'created_at', 'name' => 'village__documents.created_at', 'title' => $this->trans('table.created_at')])
          ->addColumn(['data' => 'published_at', 'name' => 'village__documents.published_at', 'title' => $this->trans('table.published_at')])
          ->addColumn(['data' => 'active', 'name' => 'village__documents.active', 'title' => $this->trans('table.active')]);

        if ($this->getCurrentUser()->hasAccess('village.documents.makePersonal')) {
            $builder->addColumn(['data' => 'is_personal', 'name' => 'village__documents.is_personal', 'title' => $this->trans('table.is_personal')]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
              ->editColumn('village_name', function (Document $document) {
                  if (!is_null($document->village) && $this->getCurrentUser()->hasAccess('village.villages.edit')) {
                      return '<a href="' . route('admin.village.village.edit', ['id' => $document->village->id]) . '">' . $document->village->name . '</a>';
                  } elseif (!is_null($document->village)) {
                      return $document->village->name;
                  }
              });
        }

        $dataTable
          ->editColumn('category_title', function (Document $document) {
              if ($this->getCurrentUser()->hasAccess('village.documentcategories.edit') && $document->category) {
                  return '<a href="' . route('admin.village.documentcategory.edit', ['id' => $document->category->id]) . '">' . $document->category->title . '</a>';
              }
              if($document->category)
              return $document->category->title;
          });

        $dataTable
          ->addColumn('published_at', function (Document $document) {
              return localizeddate($document->published_at);
          });

        $dataTable
          ->addColumn('created_at', function (Document $document) {
              return localizeddate($document->created_at);
          });

        $dataTable
          ->addColumn('active', function (Document $document) {
              return boolField($document->active);
          });

        $dataTable
          ->addColumn('is_personal', function (Document $document) {
              return boolField($document->is_personal);
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
        if ($request->get('is_personal') == 1 && empty($request->get('users'))) {
            $model->users()->sync([]);
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
     * @param array $data
     * @param Document $document
     *
     * @return Validator
     */
    public function validate(array $data, Document $document = null)
    {
        $rules = [
          'title'  => "required|max:255",
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
