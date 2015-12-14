<?php namespace Modules\Village\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Village\Entities\Village;

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

    /**
     * @param int     $count
     * @param Village $village
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function latest($count, Village $village = null)
    {
        $query = $this->model;

        if ($village) {
            $query->leftJoin('village_id', $village->id);
        }

        return $query
            ->orderBy('id', 'DESC')
            ->paginate($count)
        ;
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $query = $this->model;

        return $query->paginate($perPage, $columns, $pageName, $page);
    }
}
