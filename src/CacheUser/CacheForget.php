<?php

namespace Jason\CacheUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheForget
{

    /**
     * Handle the user "created" event.
     *
     * @param Model $user
     * @return bool
     */
    public static function CacheForget(Model $user)
    {
        $user   = optional($user);
        $second = $user->getAuthIdentifierName() ?? 'every';

        $key = (config('cache-user.cache_channel') === 'every')
            ? "CacheUserProvider.{$second}.{$user->{$user->getAuthIdentifierName()}}"
            : 'CacheUserProvider.single';

        return Cache::forget($key);
    }

}
