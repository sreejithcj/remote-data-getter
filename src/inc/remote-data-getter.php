<?php

/**
 * Loads all dependencies, admin and public hooks
 * @since      1.0.0
 * @author     Sreejith C J
 */

use RemoteDataGetter\Inc as Common;
use RemoteDataGetter\User as User;
use RemoteDataGetter\Admin as Admin;

class Remote_Data_Getter 
{
	/**
	 * The loader that's responsible for maintaining and registering all hooks of the plugin
	 */
	protected $loader;

	public function __construct() 
	{
		$this->load_dependencies();
		$this->define_user_hooks();
		$this-> define_admin_hooks();
		$this->define_endpoint_hooks();
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() 
	{
		$this->loader = new Common\Loader();
	}

	/**
	 * All the hooks related to the admin area functionality of the plugin.
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() 
	{
		$plugin_admin = new Admin\Remote_Data_Getter_Admin();
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_manage_remote_data_menu' );
		$this->loader->add_action( 'admin_post_purge_cache', $plugin_admin, 'purge_cache' );
	}
	
	/**
	 * All the hooks related to the public area functionality of the plugin.
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_user_hooks() 
	{
		$plugin_public = new User\Remote_Data_Getter_User();
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'load_data_template' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'load_error_template' );
	}

	/**
	 * Hook related to the Routes
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_endpoint_hooks() 
	{
		$controller = new Common\Routes();
		$this->loader->add_action('rest_api_init', $controller, 'register_routes');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 * @since    1.0.0
	 */
	public function run() 
	{
		$this->loader->run();
	}
}