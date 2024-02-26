<?php

namespace App\Observers;



use App\Services\Cache\Contract\CacheContract;
use Illuminate\Database\Eloquent\Model;

class RestCacheObserver
{
    public function __construct(private readonly CacheContract $cacheLayer)
    {}

    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $this->cacheLayer->restTotals();
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        //
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->cacheLayer->restTotals();
    }

    /**
     * Handle the Model "restored" event.
     */
    public function restored(Model $model): void
    {
        //
    }

    /**
     * Handle the Model "force deleted" event.
     */
    public function forceDeleted(Model $model): void
    {
        $this->cacheLayer->restTotals();

    }
}
