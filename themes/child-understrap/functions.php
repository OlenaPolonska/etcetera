<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

add_action( 'wp_enqueue_scripts', function() {
	$parent_style = 'understrap-style';
	
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( "$parent_style-child",
					 get_stylesheet_directory_uri() . '/style.css',
					 array( $parent_style ), wp_get_theme()->get('Version') );

	wp_enqueue_script( "$parent_style-child",
					 get_stylesheet_directory_uri() . '/script.js',
					 array( 'jquery', 'bx-slider-link-js' ) );
} );

add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

function etcetera_get_stars( $number ) {
	if ( $number < 1 || $number > 5 ) return false;
	
	$filled_star = '<i class="fa fa-star" aria-hidden="true"></i>';
	$empty_star = '<i class="fa fa-star-o" aria-hidden="true"></i>';
	
	$stars = array_merge(
		array_fill( 0, $number, $filled_star ), 
		array_fill( 0, 5-$number, $empty_star )
	);
	
	return implode( '', $stars );
}

add_action( 'widgets_init', function() {	
	register_sidebar(
		array(
			'id'            => 'home-sidebar',
			'name'          => esc_html__( 'Home Page Sidebar', 'etc' ),
			'description'   => esc_html__( 'Home Page Sidebar.', 'etc' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
} );