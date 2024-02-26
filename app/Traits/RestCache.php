<?php

namespace App\Traits;

use App\Observers\RestCacheObserver;

trait RestCache
{
    public static function bootRestCache(): void
    {
        static::observe(RestCacheObserver::class);
    }
}
