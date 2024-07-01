<?php

namespace App\Http\Middleware;

use App\Services\BaseService;
use Closure;

class OwnerMiddleware
{
    protected $baseService;
    public function __construct(BaseService $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $model
     * @param  string  $param
     * @return mixed
     */
    public function handle($request, Closure $next, $model, $param = 'id')
    {
        $user = auth()->user();
        $resourceId = $request->route($param);
        $resource = app($model)->find($resourceId);

        if (!$resource || $resource->user_id != $user->id) {
            return $this->baseService->apiResponse(null, 'Unauthorized', 401);
        }

        return $next($request);
    }
}
