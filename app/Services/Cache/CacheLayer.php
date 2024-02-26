<?php

namespace App\Services\Cache;

use App\Services\Cache\Contract\CacheContract;
use Illuminate\Support\Facades\DB;

class CacheLayer implements CacheContract
{
    public static array $keys = [
        'totals' => 'stats'
    ];

    public function getTotals(): array
    {
        return cache()->rememberForever(self::$keys['totals'], function () {
            return (array) DB::selectOne("select
                (select count(*) from users) as all_users,
                (select count(*) from posts) as all_posts,
                (select count(*) from users where not exists(select * from posts where posts.user_id = users.id )) as all_users_with_zoro_posts
            ");
        });
    }

    public function restTotals(): void
    {
        cache()->forget(self::$keys['totals']);
    }
}
