<?php

namespace Jason\CacheUser;

use Illuminate\Database\Eloquent\Model;

class UserObserver
{

    /**
     * Handle the user "created" event.
     *
     * @param Model $user
     * @return void
     */
    public function created($user)
    {
        CacheForget::CacheForget($user);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param Model $user
     * @return void
     */
    public function updated($user)
    {
        CacheForget::CacheForget($user);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param Model $user
     * @return void
     */
    public function deleted($user)
    {
        CacheForget::CacheForget($user);
    }

}
