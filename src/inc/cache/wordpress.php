<?php

/**
 * Implementation of WordPress cache
 * @since      1.0.0
 * @author     Sreejith C J
 */

declare(strict_types=1);

namespace RemoteDataGetter\Inc\Cache;

class WordPress implements ICacheBase
{
    /** 
    * Save to WordPress cache
    */
    public function save_to_cache(string $id, string $data, int $timeout): bool
    {
        return set_transient($id, $data, $timeout);
    }

    //Retrieve from the cache
    public function cache(string $id): ?string
    {
        $data = get_transient($id);
        return $data ? $data : null;
    }

    //Delete cache
    public function purge_cache(string $id): bool
    {
        return delete_transient($id);
    }
}
