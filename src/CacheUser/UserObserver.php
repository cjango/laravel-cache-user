<?php

namespace Jason\CacheUser;

use Illuminate\Database\Eloquent\Model;

class UserObserver
{

    /**
     * Notes: 处理用户模型 created 事件
     * @Author: <C.Jason>
     * @Date: 2020/3/10 13:20
     * @param $user
     */
    public function created($user): void
    {
        CacheForget::CacheForget($user);
    }

    /**
     * Notes: 处理用户模型 updated 事件
     * @Author: <C.Jason>
     * @Date: 2020/3/10 13:20
     * @param $user
     */
    public function updated($user): void
    {
        CacheForget::CacheForget($user);
    }

    /**
     * Notes: 处理用户模型 deleted 事件
     * @Author: <C.Jason>
     * @Date: 2020/3/10 13:21
     * @param $user
     */
    public function deleted($user): void
    {
        CacheForget::CacheForget($user);
    }

}
