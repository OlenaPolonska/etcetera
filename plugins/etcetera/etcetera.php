<?php
/*
Plugin Name: Etcetera test plugin
Description: The test plugin for Etcetera
Text Domain: etc
Version: 1.0
Author: Olena Polonska
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once( 'etcetera_api.php' );
require_once( 'etcetera_widget.php' );

add_action( 'admin_notices', function() {
  if( !is_plugin_active('advanced-custom-fields/acf.php') 
	 && !is_plugin_active('advanced-custom-fields-pro/acf.php') )
    echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Warning: The Etcetera test plugin needs Advanced Custom Fields to function', 'ml' ) . '</p></div>';
} );

add_action( 'wp_enqueue_scripts', 	function() {
	wp_enqueue_style( 'etcetera-css', plugin_dir_url( __FILE__ ) . 'public.css' );

	wp_enqueue_script( 'etcetera-js', plugin_dir_url( __FILE__ ) . 'public.js', array( 'jquery' ) );

	wp_localize_script( 'etcetera-js', 'etcHelper',
					   array( 
						   'ajaxUrl' => admin_url( 'admin-ajax.php' ),
						   'security' => wp_create_nonce( 'etc_nonce' ),
					   ) );
} );

add_action( 'init', function() {
	register_post_type( 'apartament',
		array(
			'labels'      => array(
				'name'          => __('Apartaments', 'etc'),
				'singular_name' => __('Apartament', 'etc'),
				'menu_name' => __('Apartaments', 'etc'),
				'name_admin_bar'        => __('Apartaments', 'etc'),
				'archives'              => __('Apartaments Archive', 'etc'),
				'attributes'            => __('Apartaments Attributes', 'etc'),
				'all_items'             => __('All Apartaments', 'etc'),
				'add_new_item'          => __('Add Apartaments', 'etc'),
				'add_new'               => __('New Apartament', 'etc'),
				'new_item'              => __('New Apartaments', 'etc'),
				'edit_item'             => __('Edit Apartaments', 'etc'),
				'update_item'           => __('Update Apartament', 'etc'),
				'view_item'             => __('View Apartament', 'etc'),
				'view_items'            => __('Apartaments', 'etc'),
				'search_items'          => __('Find Apartaments', 'etc'),
			),
			'public'      => true,
			'has_archive' => true,
			'show_in_rest' => true,
			'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields' )
		) );
	flush_rewrite_rules( false );

	register_post_type( 'real_estate_object',
		array(
			'labels'      => array(
				'name'          => __('Real Estate Oblects', 'etc'),
				'singular_name' => __('Real Estate Oblect', 'etc'),
				'menu_name' => __('Real Estate Oblects', 'etc'),
				'name_admin_bar'        => __('Real Estate Oblects', 'etc'),
				'archives'              => __('Real Estate Oblects Archive', 'etc'),
				'attributes'            => __('Real Estate Oblects Attributes', 'etc'),
				'all_items'             => __('All Real Estate Oblects', 'etc'),
				'add_new_item'          => __('Add Real Estate Oblect', 'etc'),
				'add_new'               => __('New Real Estate Oblect', 'etc'),
				'new_item'              => __('New Real Estate Oblect', 'etc'),
				'edit_item'             => __('Edit Real Estate Oblects', 'etc'),
				'update_item'           => __('Update Real Estate Oblect', 'etc'),
				'view_item'             => __('View Real Estate Oblect', 'etc'),
				'view_items'            => __('Real Estate Oblects', 'etc'),
				'search_items'          => __('Find Real Estate Oblects', 'etc'),
			),
			'public'      => true,
			'has_archive' => true,
			'show_in_rest' => true,
			'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields' )
		) );
	
	register_taxonomy( 'area', 'real_estate_object', array(
		'labels' => array(
			'name'          => __('Areas', 'etc'),
			'singular_name' => __('Area', 'etc'),
			'edit_item'     => __('Edit Area', 'etc'),
			'update_item'   => __('Update Area', 'etc'),
			'add_new_item'  => __('Add New Area', 'etc'),
			'new_item_name' => __('New Area Name', 'etc'),
			'menu_name'     => __('Area', 'etc'),
		),
		'hierarchical' => true,
		'rewrite'      => array( 'slug' => 'area' ),
		'show_in_rest' => true,
	) );
} );

// the following shortcodes are used just to test the REST API queries 
add_shortcode( 'add_estate', function( $args ) {
	$etcetera = new Etcetera_API( 'real_estate_object' );
	
	$body = $etcetera->add( array(
		'title' => 'new estate',
		'content' => 'new description',
		'fields' => array(
			'name' => ' estate name',
			'location' => 'estate location',
			'floors' => '3',
			'type' => 'brick',
			'environmental' => '2',
			'apartments' => array(507, 508),
		),
	) );
	$post_data = json_decode( $body, true );

	if ( isset( $post_data['id'] ) ) {
		echo sprintf( __( 'Object with ID %s is created successfully', 'etc' ), esc_html( $post_data['id'] ) );
	} else {
		echo __("Object wasn't created. Details: ", 'etc' ) . esc_html( $body );
	}	
    return;
} );

add_shortcode( 'update_estate', function( $args ) {
	$etcetera = new Etcetera_API( 'real_estate_object' );
	
	$body = $etcetera->update( array(
		'title' => 'update estate1231231',
		'content' => 'update description12311',
		'id' => $args['id'],
	) );

	$post_data = json_decode( $body, true );

	if ( isset( $post_data['id'] ) ) {
		echo sprintf( __( 'Object with ID %s is updated successfully', 'etc' ), esc_html( $post_data['id'] ) );
	} else {
		echo __("Object wasn't updated. Details: ", 'etc' ) . esc_html( $body );
	}

return;
} );

add_shortcode( 'delete_estate', function( $args ) {
	$etcetera = new Etcetera_API( 'real_estate_object' );
	
	$body = $etcetera->delete( array(
		'id' => $args['id'],
	) );

	$post_data = json_decode( $body, true );
// 	echo '<pre>'.print_r($post_data, true).'</pre>';

	if ( $post_data['code'] == 'rest_already_trashed' ) {
		echo sprintf( __( 'Object with ID %s is deleted successfully', 'etc' ), esc_html( $post_data['id'] ) );
	} else {
		echo __("Object wasn't deleted. Details: ", 'etc' ) . esc_html( $body );
	}

return;
} );

add_shortcode( 'get_estate', function( $args ) {
	$etcetera = new Etcetera_API( 'real_estate_object' );
	
	$body = $etcetera->get( array(
		'per_page' => 2,
	) );

	$post_data = json_decode( $body, true );
	echo '<pre>'.print_r($post_data, true).'</pre>';

	return;
} );

