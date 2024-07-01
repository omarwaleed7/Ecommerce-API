<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Create a new model instance.
     *
     * @param string $model
     * @param array $items
     * @return array
     */
    public function create(string $model, array $items): mixed;

    /**
     * Get a model instance by its primary key.
     *
     * @param string $model
     * @param int $id
     * @return mixed
     */
    public function get(string $model, int $id): mixed;

    /**
     * Get all model instances.
     *
     * @param string $model
     * @return mixed
     */
    public function getAll(string $model): mixed;

    /**
     * Get all model instances paginated.
     *
     * @param string $model
     * @param int $perPage
     * @return mixed
     */
    public function getAllPaginated(string $model, int $perPage): mixed;

    /**
     * Update a model instance.
     *
     * @param int $id
     * @param string $model
     * @param array $items
     * @return mixed
     */
    public function update(int $id, string $model, array $items): mixed;

    /**
     * Delete a model instance.
     *
     * @param int $id
     * @param string $model
     * @return mixed
     */
    public function delete(string $model, int $id): mixed;
}
