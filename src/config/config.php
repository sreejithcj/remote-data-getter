<?php

declare(strict_types=1);

namespace RemoteDataGetter\Config;

/**
 * Config enters for the plugin goes in here
 * @since      1.0.0
 * @author     Sreejith C J
 */

final class Config {
    
    const EMPLOYEE_DATA_ENDPOINT = "https://dummy.restapiexample.com/api/v1/employees/";

    public static function nonce_key(): string
    {
        return "ajax-nonce";
    }

    public static function cache_provider(): string
    {
        return "wordpress";
    }

    public static function cache_prefix(): string
    {
        return "rd_2020_rx";
    }

    public static function cache_timeout(): int
    {
        return 1800;
    }

    public static function api_password(): string
    {
        return '$2y$10$18I8UK7St5Edy3bgso5r2uipMy0oMSCK2v.vPBoyhRbEMR4BSsMVS';
    }
}