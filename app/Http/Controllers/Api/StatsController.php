<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\Response\HasApiResponse;
use App\Services\Cache\Contract\CacheContract;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    use HasApiResponse;
    public function __invoke(CacheContract $cacheLayer)
    {
        return $this->successResponse($cacheLayer->getTotals());
    }
}
