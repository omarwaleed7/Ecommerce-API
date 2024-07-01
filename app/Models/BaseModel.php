<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BaseModel extends Model
{
    /**
     * Boot method to register model event listeners.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            $model->clearCache(get_class($model));
        });

        static::updated(function ($model) {
            $model->clearCache(get_class($model));
        });

        static::deleted(function ($model) {
            $model->clearCache(get_class($model));
        });
    }

    /**
     * Clear cache associated with this model.
     **
     * @param string $modelName
     * @return void
     */
    public function clearCache(string $modelName): void
    {
        $cacheKey = 'cached_' . $modelName;

        Cache::forget($cacheKey);
    }
}
