<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Survey;
use Modules\Village\Repositories\SurveyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SurveyController extends AdminBaseController
{
    /**
     * @var SurveyRepository
     */
    private $survey;

    public function __construct(SurveyRepository $survey)
    {
        parent::__construct();

        $this->survey = $survey;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$surveys = $this->survey->all();
        
        return view('village::admin.surveys.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->survey->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::surveys.title.surveys')]));

        return redirect()->route('admin.village.survey.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Survey $survey
     * @return Response
     */
    public function edit(Survey $survey)
    {
        return view('village::admin.surveys.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Survey $survey
     * @param  Request $request
     * @return Response
     */
    public function update(Survey $survey, Request $request)
    {
        $this->survey->update($survey, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::surveys.title.surveys')]));

        return redirect()->route('admin.village.survey.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Survey $survey
     * @return Response
     */
    public function destroy(Survey $survey)
    {
        $this->survey->destroy($survey);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::surveys.title.surveys')]));

        return redirect()->route('admin.village.survey.index');
    }
}
