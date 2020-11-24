<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 用户模型
    |--------------------------------------------------------------------------
    | 要监听这个模型的事件，来更新模型数据的信息
    */
    'model'         => App\Models\User::class,
    
    /*
    |--------------------------------------------------------------------------
    | 缓存的保存时间
    |--------------------------------------------------------------------------
    | 默认值(秒):   3600
    | 注意: Laravel5.8以前缓存单位由为分钟, 此处需要自行修改时间
    */
    'cache_ttl'     => env('CACHE_USER_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | 缓存的保存方式
    |--------------------------------------------------------------------------
    | single:   所有的保存为一个缓存键值
    | every:    按照单个用户进行缓存
     */
    'cache_channel' => env('CACHE_USER_CHANNEL', 'every'),

    /*
    |--------------------------------------------------------------------------
    | 渴望加载的关联模型
    |--------------------------------------------------------------------------
    | String: a,b,c
    | 使用关联加载时注意: 关联的数据仅在第一次查询时加载, 关联数据更新后需要自行删除缓存数据
     */
    'model_with'    => env('CACHE_USER_MODEL_WITH'),
];
