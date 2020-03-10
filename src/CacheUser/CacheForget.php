<?php

namespace Jason\CacheUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheForget
{

    /**
     * Notes: 删除用户缓存
     * @Author: <C.Jason>
     * @Date: 2020/3/10 13:20
     * @param Model $user
     * @return bool
     */
    public static function CacheForget(Model $user): bool
    {
        $user   = optional($user);
        $second = $user->getAuthIdentifierName() ?? 'every';

        $key = (config('cache-user.cache_channel') === 'every')
            ? "CacheUserProvider.{$second}.{$user->{$user->getAuthIdentifierName()}}"
            : 'CacheUserProvider.single';

        return Cache::forget($key);
    }

}
