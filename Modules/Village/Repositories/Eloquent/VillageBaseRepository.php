<?php namespace Modules\Village\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

abstract class VillageBaseRepository extends EloquentBaseRepository
{
    /**
     * Get an array with the values of a given column.
     *
     * @param array  $attributes
     * @param string $column
     * @param string $key
     * @param array  $order
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists(array $attributes, $column, $key = null, array $order = null)
    {
        $collection = $this->findAllByAttributes($attributes, $order);

        $results = [];
        foreach($collection as $model) {
            $results[$model->$key] = $model->$column;
        }

        return collect($results);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->orderBy('created_at', 'DESC')->get();
        }

        return $this->model->orderBy('id', 'DESC')->get();
    }

    /**
     * Find all resources by an array of attributes
     *
     * @param array $attributes
     * @param array $order
     *
     * @return Model[]
     */
    public function findAllByAttributes(array $attributes, array $order = null)
    {
        if (!$order) {
            $order = ['id' => 'DESC'];
        }

        $query = $this->model;

        if (method_exists($this->model, 'translations')) {
            $query = $query
                ->with('translations')
            ;
        }
        else {
            foreach ($attributes as $field => $value) {
                $query = $query->where($field, $value);
            }
        }

        foreach ($order as $field => $direction) {
            $query = $query->orderBy($field, $direction);
        }

        return $query->get();
    }
}
