<?php

declare(strict_types=1);

namespace Xetaravel\Settings;

use BDS\Models\Setting;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Settings
{
    protected null|array $context = [
        'model_type' => null,
        'model_id' => null
    ];

    /** @var null|int */
    protected null|int $siteId = null;

    public function __construct(
        protected Cache $cache,
    ) {
    }

    /**
     * Get the value for the given key, siteId and context fromm the cache or from the database if no cache key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key): mixed
    {
        $cacheKey = $this->getCacheKey(key: $key);

        $value = $this->cache->rememberForever($cacheKey, function () use ($key) {
            $query = Setting::query()
                ->where('key', $key)
                ->where('model_type', $this->context['model_type'])
                ->where('model_id', $this->context['model_id']);

            return serialize($query->value('value'));
        });

        return $value ? unserialize($value) : null;
    }

    /**
     * Remove the specified key.
     *
     * @param string $key The key to flush.
     *
     * @return bool
     */
    public function remove(string $key): bool
    {
        $cacheKey = $this->getCacheKey(key: $key);

        return $this->cache->forget($cacheKey);
    }

    /**
     * Set the context to the setting.
     *
     *
     *
     * @param Model|array|null $context
     * Pattern :
     *  [
     *      'type' => 'BDS\Models\User',
     *      'id' => 1
     *  ]
     *
     * @return $this
     */
    public function setContext(Model|array|null $context = null): self
    {
        if ($context instanceof Model) {
            $this->context['model_type'] = get_class($context);
            $this->context['model_id'] = $context->getKey();

            return $this;
        }
        $this->context = [
            'model_type' => $context['type'] ?? null,
            'model_id' => $context['id'] ?? null
        ];

        return $this;
    }

    /**
     * Reset the context.
     *
     * @return $this
     */
    public function withoutContext(): self
    {
        $this->context = [
            'model_type' => null,
            'model_id' => null
        ];

        return $this;
    }

    /**
     * Generate the key used by the cache driver to store the value.
     *
     * @param string $key
     *
     * @return string
     */
    protected function getCacheKey(string $key): string
    {
        $cacheKey = $this->normalizeKey($key);

        // Add context to the cache key.
        $context = serialize($this->context);
        $cacheKey .= "::c::{$context}";

        return $cacheKey;
    }

    protected function normalizeKey(string $key): string
    {
        // We want to preserve period characters in the key, however everything else is fair game
        // to convert to a slug.
        return Str::of($key)
            ->replace('.', '-dot-')
            ->slug()
            ->replace('-dot-', '.')
            ->__toString();
    }

}
