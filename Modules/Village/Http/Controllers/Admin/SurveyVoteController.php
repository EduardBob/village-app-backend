<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\SurveyVote;
use Modules\Village\Repositories\SurveyVoteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SurveyVoteController extends AdminBaseController
{
    /**
     * @var SurveyVoteRepository
     */
    private $surveyVote;

    public function __construct(SurveyVoteRepository $surveyVote)
    {
        parent::__construct();

        $this->surveyVote = $surveyVote;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$surveyVotes = $this->surveyVote->all();

        return view('village::admin.surveyvotes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.surveyvotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->surveyVote->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::surveyvotes.title.surveyvotes')]));

        return redirect()->route('admin.village.surveyvote.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SurveyVote $surveyVote
     * @return Response
     */
    public function edit(SurveyVote $surveyVote)
    {
        return view('village::admin.surveyvotes.edit', compact('surveyvote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SurveyVote $surveyVote
     * @param  Request $request
     * @return Response
     */
    public function update(SurveyVote $surveyVote, Request $request)
    {
        $this->surveyVote->update($surveyVote, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::surveyvotes.title.surveyvotes')]));

        return redirect()->route('admin.village.surveyvote.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SurveyVote $surveyVote
     * @return Response
     */
    public function destroy(SurveyVote $surveyVote)
    {
        $this->surveyVote->destroy($surveyVote);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::surveyvotes.title.surveyvotes')]));

        return redirect()->route('admin.village.surveyvote.index');
    }
}
