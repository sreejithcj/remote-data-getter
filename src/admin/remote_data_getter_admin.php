<?php

/**
 * The admin-facing functionality of the plugin.
 * @since      1.0.0
 * @author     Sreejith C J
 */
declare( strict_types = 1 );

namespace RemoteDataGetter\Admin; 

use RemoteDataGetter\Admin\Partials as AdminPartials;
use RemoteDataGetter\Inc\Cache as Cache;
use RemoteDataGetter\Config as Config;

class Remote_Data_Getter_Admin 
{
	
	/**
	 * Object of the cache provider
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cache_Factory    $cache_factory
	 */
	protected $cache_factory;


	public function __construct() 
	{
		$this->cache_provider = Cache\Cache_Factory::provider(Config\Config::cache_provider());
	}

    /** 
	 * Add Manage Remote Data menu item to admin menu
	*/
	public function add_manage_remote_data_menu() 
	{
        add_submenu_page('tools.php', 'Manage Remote Data', 'Manage Remote Data', 'manage_options', 'manage-remote-data', array($this, 'html_form_page_content'));
	}
	
    /**
	 * Load markup for Manage Remote Data menu page
	 */
	public function html_form_page_content() 
	{
        $manage_remote_data = new AdminPartials\Manage_Remote_Data();
        echo $manage_remote_data->get_content();
	}
	/** 
	 * Delete all the cached data
	*/
	public function purge_cache(): bool 
	{
		if ( isset( $_POST['remote_data_nonce'] ) 
			&& wp_verify_nonce( sanitize_key($_POST['remote_data_nonce']), 'rdg_purge_data_form' )) 
		{
            $this->cache_provider->purge_cache(Config\Config::cache_prefix());
        }
		$this->redirect_manage_remote_data();
	}
	
	/**
	 * Redirect the admin to current manage remote data option
	 */
	private function redirect_manage_remote_data() 
	{
		global $wp;
		$current_url = home_url(add_query_arg(array(), $wp->request));
		wp_redirect($current_url."/wp-admin/tools.php?page=manage-remote-data");
		exit;
	}
}