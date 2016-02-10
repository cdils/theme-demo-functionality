<?php
/**
 * Theme Demo Functionality.
 *
 * This plugin includes functionality that needs to be present for the Utility Pro
 * theme demo, but not in the theme itself
 *
 * @author            Carrie Dils
 * @license           GPL-2.0+
 * @link              http://www.carriedils.com
 * @copyright         2015 Carrie Dils
 *
 * Plugin Name:       Utility Pro Demo
 * Plugin URI:
 * Description:       Adds functionality for theme demo.
 * Version:           1.0.0
 * Author:            Carrie Dils
 * Author URI:        http://www.carriedils.com
 * Text Domain:       theme-demo-functionality
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Add body class to URL string.
 *
 * Display available theme color options via the URL.
 *
 * @todo remove this from final version - demo only
 */
add_filter( 'body_class', 'string_body_class' );
function string_body_class( $classes ) {

	if ( isset( $_GET['color'] ) ) {
		$classes[] = 'utility-pro-' . sanitize_html_class( $_GET['color'] );
	}

	return $classes;
}

/**
 * Generate sitemap.
 *
 * This sitemap is used in conjunction with grunt-exec and grunt-uncss.
 *
 * @todo remove this from final version - dev only
 */
add_action( 'template_redirect', 'show_sitemap' );
function show_sitemap() {
	if ( isset( $_GET['show_sitemap'] ) ) {

		$the_query = new WP_Query( array( 'post_type' => 'any', 'posts_per_page' => '-1', 'post_status' => 'publish' ) );
		$urls = array();

		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$urls[] = get_permalink();
		}
		die( json_encode($urls) );
	}
}

/**
 * Unique Search Form Label.
 *
 * @package   UniqueSearchFormLabel
 * @author    Gary Jones
 * @link      http://gamajo.com/
 * @copyright 2015 Gary Jones, Gamajo Tech
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Unique Search Form Label.
 * Plugin URI:  http://gamajo.com/
 * Description: Demo plugin to make search field labels different, if theme uses class-search-form.php.
 * Version:     1.0.0
 * Author:      Gary Jones
 * Author URI:  http://gamajo.com/
 * Text Domain: unique-search-form-label
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_action( 'genesis_setup', 'usfl_init', 16 );
/**
 * Override search form.
 *
 * Genesis overrides WP at priority 10.
 * Genesis Accessible plugin overrides with priority 20.
 * Child theme implementations may use priority 25.
 * So we're using 30.
 *
 * @since 1.0.0
 */
function usfl_init() {
	add_filter( 'get_search_form', 'usfl_get_search_form', 30 );
}

/**
 * Configure class-search-form.php to use different strings if
 * we've reached at least the get_footer action hook.
 *
 * @since 1.0.0
 *
 * @return string Markup for search form.
 */
function usfl_get_search_form() {
	$args = array(); // defaults
	if ( did_action( 'get_footer' ) ) {
		$args = array(
			// Not necessary to have everything the same
			'label'        => __( 'Search website', 'unique-search-form-label' ),
			'placeholder'  => __( 'Search website', 'unique-search-form-label' ),
			'button'       => __( 'Search website', 'unique-search-form-label' ),
			'button_label' => __( 'Search website', 'unique-search-form-label' ),
		);
	}
	$search = new Utility_Pro_Search_Form( $args );

	return $search->get_form();
}
