<?php
	/**
	 * Plugin Name: Responsive Photo Gallery Wp
	 * Plugin URI: https://themepoints.com/photogallery
	 * Description: This plugin is built using pure CSS3, allowing you to create a stunning and responsive photo gallery for your website. Install it today and enjoy this fantastic feature!
	 * Version: 1.7
	 * Author: themepoints
	 * Author URI: https://themepoints.com
	 * License: GPLv2 or later
	 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
	 * Text Domain: tpcgallery
	 * Domain Path: /languages
	 */

	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

	define('TP_CUSTOM_PHOTO_GALLERY_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
	define('tp_custom_photo_gallery_plugin_dir', plugin_dir_path( __FILE__ ) );

	add_filter('widget_text', 'do_shortcode');

	/**
	 * Enqueue plugin styles and scripts
	 */
	function tp_custom_photo_gallery_scripts() {
	    wp_enqueue_style( 'lightGallery-main-css', plugin_dir_url( __FILE__ ) . 'assets/css/lightGallery.css', array(), '1.0.0', 'all' );
	    wp_enqueue_style( 'lightGallery-awesome-css', plugin_dir_url( __FILE__ ) . 'assets/css/font-awesome.css', array(), '1.0.0', 'all' );
	    wp_enqueue_style( 'tps-gallery-main-css', plugin_dir_url( __FILE__ ) . 'assets/css/tps-photo-gallery.css', array(), '1.0.0', 'all' );

	    // Enqueue custom JS for activating the lightGallery plugin
	    wp_add_inline_script('lightGallery-main-js', '
	        jQuery(document).ready(function(){
	            jQuery("#lightGallery").lightGallery();
	        });
	    ');
	    // Enqueue inline CSS for customizing the gallery item styles
	    wp_add_inline_style('gallery-main-css', '
	        .light_gallery_item ul li img {
	            border-radius: 0;
	            height: 100px;
	            width: 100px;
	        }
	    ');

		wp_enqueue_script('jquery');
	    wp_enqueue_script( 'lightGallery-main-js', plugin_dir_url( __FILE__ ) . 'assets/js/lightGallery.js', array('jquery'), '1.0.0', true );
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('tps-wp-color-picker', plugins_url(), array( 'wp-color-picker' ), false, true );
	}
	add_action( 'wp_enqueue_scripts', 'tp_custom_photo_gallery_scripts' );

	/**
	 * Load plugin text domain for translations
	 */
	function tp_custom_plugin_load_textdomain() {
	    load_plugin_textdomain( 'tpcgallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	add_action( 'plugins_loaded', 'tp_custom_plugin_load_textdomain' );

	/**
	 * Load admin styles and scripts for TP Custom Photo Gallery.
	 */
	function tp_custom_photo_gallery_admin_scripts( $hook ) {
	    global $typenow;

	    // Only load scripts and styles for the 'generategallery' post type.
	    if ( $typenow == 'generategallery' ) {
	        wp_enqueue_style( 'gallery-admin-style', plugin_dir_url( __FILE__ ) . 'admin/css/tps-photo-gallery-admin.css', array(), '1.0.0', 'all' );
			wp_enqueue_script('jquery');
	    	wp_enqueue_script( 'gallery-admin-scripts', plugin_dir_url( __FILE__ ) . 'admin/js/tps-photo-gallery-admin-scripts.js', array('jquery'), '1.0.0', true );
	        wp_enqueue_style('wp-color-picker');
	        wp_enqueue_script( 'gallery-color-picker', plugin_dir_url( __FILE__ ) . 'admin/js/color-picker.js', array('wp-color-picker'), false, true );
	    }

	    // For 'tp_photo_gallery' post type, load additional scripts
	    if ( $typenow == 'tp_photo_gallery' ) {
	    	wp_enqueue_script( 'gallery-main-admin-scripts', plugin_dir_url( __FILE__ ) . 'admin/js/tps-gallery-main-admin-scripts.js', array('jquery'), '1.0.0', true );
	    }
	}
	add_action('admin_enqueue_scripts', 'tp_custom_photo_gallery_admin_scripts');

	# Gallery Post Type
	require_once( 'libs/post-types/tps-photo-gallery-posttypes.php' );
	
	# Gallery Post Type
	require_once( 'libs/meta-boxes/tps-photo-gallery-metaboxes.php' );

	# Gallery Post Type
	require_once( 'libs/shortcode/tps-photo-gallery-shortcode.php' );
