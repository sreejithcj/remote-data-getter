<?php

/**
 * Factory class that returns the object of a cache provider
 * @since      1.0.0
 * @author     Sreejith C J
 */

declare(strict_types=1);

namespace RemoteDataGetter\Inc\Cache;

class Cache_Factory
{
    public static function provider(string $provider): object
    {
        $withNamespace = 'RemoteDataGetter\Inc\Cache\\' . $provider;
        return new $withNamespace();
    }
}
