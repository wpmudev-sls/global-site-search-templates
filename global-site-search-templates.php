<?php
/*
Plugin Name: Global Site Search - Custom Templates
Plugin URI: https://premium.wpmudev.org/
Description: Override search templates without modifying GST plugin files or child theme.
Author: Panos Lyrakis @ WPMUDEV
Version: 1.0.0
Author URI: http://premium.wpmudev.org
WDP ID: 102
Network: true
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPMUDEV_GSS_CT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'WPMUDEV_GSS_CT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! class_exists( 'WPMUDEV_GSS_Custom_Templates' ) ) {

	class WPMUDEV_GSS_Custom_Templates {

		private static $_instance = null;

		public static function get_instance() {

			if( is_null( self::$_instance ) ){
				self::$_instance = new WPMUDEV_GSS_Custom_Templates();
			}
			return self::$_instance;

		}

		private function __construct() {

			add_filter( 'global_site_search_locate_template', array( $this, 'override_template' ), 10, 3 );

		}

		public function override_template( $template, $template_name, $template_path ){

			$overriding_template = implode( DIRECTORY_SEPARATOR, array( dirname( __FILE__ ), 'templates', $template_name ) );

			if( ! file_exists( $overriding_template ) ){
				$overriding_template = $template;
			}

			return $overriding_template;

		}

	}

	add_action( 'plugins_loaded', function(){
		$GLOBALS['WPMUDEV_GSS_Custom_Templates'] = WPMUDEV_GSS_Custom_Templates::get_instance();
	}, 10 );

}