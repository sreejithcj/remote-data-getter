<?php
/**
 * All endpoints which makes call to external APIs are defined here
 * @since      1.0.0
 * @author     Sreejith C J
 */

declare(strict_types=1);

namespace RemoteDataGetter\Inc; 

use RemoteDataGetter\Config as Config;
use WP_REST_Controller;
use WP_REST_Server;
use WP_REST_Response;
use RemoteDataGetter\Inc\Cache as Cache;

class Routes extends WP_REST_Controller
{

  /**
   * Constructor.
   * @since 1.0.0
   */
  public function __construct(){
    $this->namespace = 'wpc/v1';
    $this->rest_base = 'employees';
    $this->cache_provider = Cache\Cache_Factory::provider(Config\Config::cache_provider());
  }

  /**
   * Registers the routes custom endpoints
   *
   * @since 1.0.0
   *
   */
  public function register_routes()
  {
    register_rest_route(
      $this->namespace, '/'.$this->rest_base, 
      [
        'methods' => WP_REST_Server::READABLE,
        'callback' => [$this, 'fetch_data'],
        'permission_callback' => '__return_true',
      ]
    );
  }

  /**
	 * Get all data.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_REST_Response Response object
	 */
    public function fetch_data(): object 
    {
      if(!$this->auth()) {
        return $this->send_response("Authorization failed", "401", "Failed to fetch data due to wrong authorization");
      }
      $arr_response  = $this->get_employee_data();
      return $this->send_response(...$arr_response);
    }

  /**
   * Get data from remote end point
   * @since 1.0.0
   *
   * @return Array
   */
    public function get_employee_data(): array 
    {
      $response_body = $this->get_cache();
        if ( !is_null($response_body) ) {
          return [$response_body, "200", "Success"];
        }

        $api_end_point = Config\Config::EMPLOYEE_DATA_ENDPOINT;
        $response = wp_remote_get($api_end_point, array( 'timeout' => 30));
        $response_code = wp_remote_retrieve_response_code($response);
        $response_message = wp_remote_retrieve_response_message($response);
        $response_body = wp_remote_retrieve_body($response);
      
        if( $response_code===200 ) {
          $this->save_to_cache($response_body);
        }
        return [$response_body, $response_code, $response_message];
    }

    /**
     * Get remote data from cache
     */
    private function get_cache(): ?string 
    {
      return $this->cache_provider->cache(Config\Config::cache_prefix());
    }

    /**
     * Save the remote data fetched to cache with specific timeout
     */
    private function save_to_cache($response_body) 
    {
        $this->cache_provider->save_to_cache( 
          Config\Config::cache_prefix(),$response_body,Config\Config::cache_timeout()
        );
    }
    /**
    * Generate  WP_REST_Response object
    */
    private function send_response($response_body, $response_code="200", $response_message="Success"): object 
    {
      return new WP_REST_Response(
        array( 
          'status' => $response_code,
          'response' => $response_message,
          'body_response' => $response_body
        ));
    }

    private function auth(): bool
    {
      if( !isset($_SERVER['PHP_AUTH_USER']) ) {
        return false;
      }
      if(Config\Config::api_password() != crypt($_SERVER['PHP_AUTH_PW'], Config\Config::api_password())) 
      {
        return false;
      } 
      return true;
    }
}