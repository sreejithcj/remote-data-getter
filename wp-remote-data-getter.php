<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: Remote Data Getter
 * Description: This plugin retrieves data from external API and displays it to public and admin. Caches the retrieved data for 12 hours and admin user can purge the cache data.
 * Version:     1.0.0
 * Author:      Ruslan Ismailov
 * License:     MIT
 * Text Domain: remote-data-getter
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action('plugins_loaded', 'autoload');

register_activation_hook( __FILE__, 'activate_remote_data_getter' );
register_deactivation_hook( __FILE__, 'deactivate_remote_data_getter' );

/**
 * The code that runs during plugin activation.
 */
function activate_remote_data_getter() 
{
	require_once plugin_dir_path( __FILE__ ). '/src/inc/activator.php';
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_remote_data_getter() 
{
	require_once plugin_dir_path( __FILE__ ). '/src/inc/deactivator.php';
	Deactivator::deactivate();
 }

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_remote_data_getter() 
{
	require plugin_dir_path( __FILE__ ) . '/src/inc/remote-data-getter.php';
	$plugin = new Remote_Data_Getter();
	$plugin->run();
}

function autoload() 
{
    $autoLoader = __DIR__ . '/vendor/autoload.php';
    if (file_exists($autoLoader)) {
		require $autoLoader;
		run_remote_data_getter();
	}
}