<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected BaseServiceInterface $baseService;

    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Create a new model instance.
     *
     * @param string $model
     * @param array $items
     * @return mixed
     */
    public function create(string $model, array $items): mixed
    {
        $data = $model::create($items);

        return $data;
    }

    /**
     * Get a model instance.
     *
     * @param string $model
     * @param int $id
     * @return mixed
     */
    public function get(string $model, int $id): mixed
    {
        $data = $model::find($id);

        if ($data == null) {
            return null;
        }

        return $data;
    }

    /**
     * Get all model instances.
     *
     * @param string $model
     * @return mixed
     */
    public function getAll(string $model): mixed
    {
        $data = Cache::rememberForever('cached_' . $model, function () use ($model) {
            return $model::all();
        });

        if ($data->isEmpty()) {
            return null;
        }

        return $data;
    }

    /**
     * Get all model instances paginated.
     *
     * @param string $model
     * @param int $perPage
     * @return mixed
     */
    public function getAllPaginated(string $model, int $perPage): mixed
    {
        $data = Cache::rememberForever('cached_' . ($model), function () use ($perPage, $model) {
            return $model->paginate($perPage);
        });

        if ($data->isEmpty()) {
            return null;
        }

        return $data;
    }

    /**
     * Update a model instance.
     *
     * @param int $id
     * @param string $model
     * @param array $items
     * @return mixed
     */
    public function update(int $id, string $model, array $items): mixed
    {
        $data = $model::find($id);

        if ($data == null) {
            return null;
        }

        $data->update($items);

        $data = $model::find($id);

        return $data;
    }

    /**
     * Delete a model instance.
     *
     * @param string $model
     * @param int $id
     * @return bool
     */
    public function delete(string $model, int $id): bool
    {
        $modelInstance = $model::find($id);

        if ($modelInstance == null) {
            return false;
        }

        $modelInstance->delete();

        return true;
    }
}
