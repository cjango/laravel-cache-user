# Laravel 用户认证缓存

### 安装
> composer require jasonc/laravel-cache-user

### 使用

修改配置文件

```php
'providers' => [
     'users' => [
         'driver' => 'cache',
         'model'  => App\Models\User::class
    ],
 ]
```

### 声明

修改自 yangjisen/laravel-cache-provider