<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Margin;
use Modules\Village\Repositories\MarginRepository;

use Validator;

class MarginController extends AdminController
{
    /**
     * @param MarginRepository $margin
     */
    public function __construct(MarginRepository $margin)
    {
        parent::__construct($margin, Margin::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'margins';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Model $model)
    {
        if (!$model->is_removable)
        {
            flash()->error($this->trans('messages.not_removable', ['name' => $this->trans('title.margin')]));

            return redirect()->route($this->getRoute('index'));
        } else {
            return parent::destroy($model);
        }
    }

    /**
     * @param array  $data
     * @param Margin $margin
     *
     * @return Validator
     */
    static function validate(array $data, Margin $margin = null)
    {
        $marginId = $margin ? $margin->id : '';

        return Validator::make($data, [
            'title' => "required|max:255|unique:village__margins,title,{$marginId}",
            'value' => 'required|numeric|min:0',
            'type' => 'required|in:'.implode(',', Margin::getTypes()),
            'order' => 'required|integer|min:1',
            'is_removable' => 'boolean'
        ]);
    }
}
