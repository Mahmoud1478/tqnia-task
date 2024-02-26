<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Api\Response\HasApiResponse;
use App\Services\Cache\Contract\CacheContract;

class StatsController extends Controller
{
    use HasApiResponse;
    public function __invoke(CacheContract $cacheLayer)
    {
        return $this->successResponse($cacheLayer->getTotals());
    }
}
