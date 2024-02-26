<?php

namespace App\Services\Cache\Contract;

interface CacheContract
{
    public function getTotals(): array;

    public function restTotals(): void;
}
