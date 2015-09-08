<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Article;
use Modules\Village\Repositories\ArticleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ArticleController extends AdminBaseController
{
    /**
     * @var ArticleRepository
     */
    private $article;

    public function __construct(ArticleRepository $article)
    {
        parent::__construct();

        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$articles = $this->article->all();

        return view('village::admin.articles.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->article->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::articles.title.articles')]));

        return redirect()->route('admin.village.article.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Article $article
     * @return Response
     */
    public function edit(Article $article)
    {
        return view('village::admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Article $article
     * @param  Request $request
     * @return Response
     */
    public function update(Article $article, Request $request)
    {
        $this->article->update($article, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::articles.title.articles')]));

        return redirect()->route('admin.village.article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article $article
     * @return Response
     */
    public function destroy(Article $article)
    {
        $this->article->destroy($article);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::articles.title.articles')]));

        return redirect()->route('admin.village.article.index');
    }
}
