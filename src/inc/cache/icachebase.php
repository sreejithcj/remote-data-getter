<?php
/**
 * Interface for the cache provider classes
 * @since      1.0.0
 * @author     Ruslan Ismailov
 */
declare(strict_types=1);

namespace RemoteDataGetter\Inc\Cache;

interface ICacheBase
{
    public function cache(string $id);
    public function save_to_cache(string $id, string $data, int $timeout);
    public function purge_cache(string $id);
}