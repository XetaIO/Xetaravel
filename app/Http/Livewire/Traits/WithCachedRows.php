<?php

namespace Xetaravel\Http\Livewire\Traits;

use InvalidArgumentException;

trait WithCachedRows
{
    /**
     * Whatever we use the cache or not.
     *
     * @var bool
     */
    protected $useCache = false;

    /**
     * Modify the option to use the cache.
     *
     * @return void
     */
    public function useCachedRows(): void
    {
        $this->useCache = true;
    }

    /**
     * Function to store and get back queries result from the cache.
     *
     * @param mixed $callback The callback function. (The query stored)
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function cache($callback)
    {
        $cacheKey = $this->id;

        // If we use the cache and the cache has the id, return it.
        if ($this->useCache && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        // Get the callback result.
        $result = $callback();

        // Store the result in the cache.
        cache()->put($cacheKey, $result);

        return $result;
    }
}
