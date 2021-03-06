<?php

namespace App\Domain\Repository;

abstract class BaseRepository
{

    /**
     * Model class for repo.
     *
     * @var string
     */
    protected $modelClass;

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int                               $take
     * @param bool                              $paginate
     *
     * @return EloquentCollection|Paginator
     */
    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }
        if (true == $paginate) {
            return $query->paginate($take);
        }
        if ($take > 0 || false !== $take) {
            $query->take($take);
        }
        return $query->get();
    }

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    protected function newQuery()
    {
        return app()->make($this->modelClass)->newQuery();
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     * @return EloquentCollection|Paginator
     */
    public function all($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return Model
     */
    public function find($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }
        return $this->newQuery()->find($id);
    }

    /**
     * Get all single record by a field.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @param  string  $operator
     * @param  boolean $fail
     * @return mixed
     */
    public function findBy($field, $value, $operator = '=', $fail = false)
    {
        if ($fail) {
            return $this->newQuery()->where($field, $operator, $value)->firstOrFail();
        }

        return $this->newQuery()->where($field, $operator, $value)->first();
    }

    /**
     * Get multiple records by a field.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @param  string  $operator
     * @return mixed
     */
    public function findAllBy($field, $value, $operator = '=')
    {
        return $this->newQuery()->where($field, $operator, $value)->get();
    }
}
