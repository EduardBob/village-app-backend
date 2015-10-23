<?php namespace Modules\Village\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepository extends \Modules\Core\Repositories\BaseRepository
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
    public function lists(array $attributes, $column, $key = null, array $order = null);

    /**
     * Find all resources by an array of attributes
     *
     * @param array $attributes
     * @param array $order
     *
     * @return Model[]
     */
    public function findAllByAttributes(array $attributes, array $order = null);
}
