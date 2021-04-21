<?php

/**
 * The public-facing functionality of the plugin.
 * @since      1.0.0
 * @author     Ruslan Ismailov
 */
declare( strict_types = 1 );

namespace RemoteDataGetter\User; 

use RemoteDataGetter\Config as Config;

class Remote_Data_Getter_User 
{

	 /**
	 * Create shortcode
	 *
	 * @since    1.0.0
     * 
	 */
	public function __construct()
	{
		add_shortcode( 'remote-data',[$this,'get_data_skeleton' ]);
	}

    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() 
	{
    }

    /**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() 
	{
		wp_enqueue_script( 'wp-util' );
		wp_enqueue_script( 'remote-data-getter', plugin_dir_url( __FILE__ ) . 'js/remote-data-getter-user.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script('remote-data-getter','ajax',['ajaxurl' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce(Config\Config::nonce_key()), 'pluginsUrl' => home_url(), ]
        );
	}
	
	/**
	 * Return the html content to set to a page when remote dat
	 */
	public function get_data_skeleton() 
	{
		return '<section id="remote-data-section"></section>';
	}

	function load_data_template() 
	{
		require plugin_dir_path( __FILE__ ) . '/partials/templates/data-template.php';
	}

	function load_error_template() 
	{
		require plugin_dir_path( __FILE__ ) . '/partials/templates/error-template.php';
	  }
}

