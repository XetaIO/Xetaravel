<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Xetaravel\Settings\Settings;

if (! function_exists('settings')) {
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function settings($key = null, $context = null)
    {
        $settings = app(Settings::class);

        // If nothing is passed in to the function, simply return the settings instance.
        if ($key === null) {
            return $settings;
        }

        // We must reset the context to the default value.
        $settings->setContext([
            'model_type' => null,
            'model_id' => null
        ]);

        // If context is not null, set it.
        if ($context instanceof Model || is_array($context)) {
            $settings->setContext($context);
        }

        return $settings->get(key: $key);
    }
}
