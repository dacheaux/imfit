<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use RuntimeException;

abstract class AbstractRepository
{
    /**
     * @var mixed
     */
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    /**
     * @return mixed
     */
    public function all($paginate = null)
    {
        return $this->processPagination($this->entity, $paginate);
    }

    /**
     * @param  mixed  $id
     * @return mixed
     */
    public function find($id)
    {
        $model = $this->entity->find($id);

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  mixed  $paginate
     * @return mixed
     */
    public function findWhere($column, $value, $paginate = null)
    {
        $query = $this->entity->where($column, $value);

        return $this->processPagination($query, $paginate);
    }

    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return mixed
     */
    public function findWhereFirst($column, $value)
    {
        $model = $this->entity->where($column, $value)->first();

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel())
            );
        }

        return $model;
    }

    /**
     * @param  string|array  $columns
     * @param  mixed  $value
     * @param  mixed  $paginate
     * @return mixed
     */
    public function findWhereLike($columns, $value, $paginate = null)
    {
        $query = $this->entity;

        if (is_string($columns)) {
            $columns = [$columns];
        }

        foreach ($columns as $column) {
            $query->orWhere($column, 'like', $value);
        }

        return $this->processPagination($query, $paginate);
    }

    /**
     * @param  int  $perPage
     * @return mixed
     */
    public function paginate($perPage = 10)
    {
        return $this->entity->paginate($perPage);
    }

    /**
     * @return mixed
     */
    public function create(array $properties)
    {
        return $this->entity->create($properties);
    }

    /**
     * @param  mixed  $id
     * @return mixed
     */
    public function update($id, array $properties)
    {
        return $this->find($id)->update($properties);
    }

    /**
     * @param  mixed  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * @return mixed
     */
    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->entity = $criterion->apply($this->entity);
        }

        return $this;
    }

    protected function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new RuntimeException('No entity defined on repository.');
        }

        return app($this->entity());
    }

    private function processPagination($query, $paginate)
    {
        return $paginate ? $query->paginate($paginate) : $query->get();
    }
}
