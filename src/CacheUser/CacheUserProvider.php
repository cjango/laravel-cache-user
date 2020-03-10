<?php

namespace Jason\CacheUser;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheUserProvider extends EloquentUserProvider
{

    protected $_ttl = 3600;

    /**
     * Create a new database user provider.
     *
     * @param Hasher $hasher
     * @param string $model
     * @return void
     */
    public function __construct(Hasher $hasher, $model, $ttl = 3600)
    {
        $this->_ttl = $ttl;
        parent::__construct($hasher, $model);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return Model|null
     */
    public function retrieveById($identifier)
    {
        return (config('cache-user.cache_channel') === 'every')
            ? $this->newModelQuery($identifier)
            : $this->newModelQuery($identifier)
                   ->firstWhere($this->createModel()->getAuthIdentifierName(), $identifier);
    }

    /**
     * Get a new query builder for the model instance.
     *
     * @param string|null $identifier
     * @return Model|Builder|null
     */
    protected function newModelQuery($identifier = null)
    {

        if (is_null($identifier)) {
            return parent::newModelQuery();
        }

        $model  = $this->createModel();
        $second = $model->getAuthIdentifierName() ?? 'every';

        $key = (config('cache-user.cache_channel') === 'every')
            ? "CacheUserProvider.{$second}.{$identifier}"
            : 'CacheUserProvider.single';

        return Cache::remember($key, $this->_ttl,
            function () use ($model, $identifier) {

                $with = collect(explode(',', config('cache-user.model_with')))
                    ->filter()->toArray();

                $query = $model->when($with, function ($query) use ($with) {
                    return $query->with($with);
                });

                return (config('cache-user.cache_channel') === 'every' && $identifier)
                    ? $query->where($model->getAuthIdentifierName(), $identifier)->first()
                    : $query->all();
            });

    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return Model|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $retrievedModel = (config('cache-user.cache_channel') === 'every')
            ? $this->newModelQuery($identifier)
            : $this->newModelQuery($identifier)
                   ->firstWhere($this->createModel()->getAuthIdentifierName(), $identifier);

        if (!$retrievedModel) {
            return null;
        }

        $rememberToken = $retrievedModel->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token)
            ? $retrievedModel : null;
    }

}