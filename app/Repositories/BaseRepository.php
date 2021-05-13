<?php

/**
 * The BaseRepository class
 * PHP version 7.4
 *
 * @category Repositories
 *
 * @package Model
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    /**
     * The BaseRepository constructor
     *
     * @param Model $model The model instance
     */

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Begin quering the model
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->query();
    }

    /**
     * Apply conditions to the query
     *
     * @param array $where The conditions
     *
     * @return Builder
     */
    public function findWhere(array $where): Builder
    {
        return $this->model->where($where);
    }

    /**
     * Find resource by specific field
     *
     * @param string $field
     * @param string $value
     *
     * @return Builder
     */
    public function findByField(
        string $field,
        string $value
    ): Builder {
        return $this->model
            ->where($field, $value);
    }

    /**
     * Get the model instance
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Retrieve a single resource
     *
     * @param int $id The id of the resource
     *
     * @return Model
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Store a new resource
     *
     * @param array $data The payload
     *
     * @return Model
     */
    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing resource
     *
     * @param array $data The payload
     * @param string $id The id of the resource
     *
     * @return Model
     */
    public function update(array $data, int $id): Model
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record->refresh();
    }
    /**
     * Destroy an existing resource
     *
     * @param string $id The id of the resource
     *
     * @return int
     *
     * @throws \Exception
     */
    public function delete(int $id): int
    {
        $record = $this->findById($id);
        return $record->delete();
    }

    public function getAll()
    {
        return $this->model->get();
    }
}
