<?php
// Adding extended features
if ( ! function_exists ( 'universal_theme_setup' ) ) :

  function universal_theme_setup() {
    // Adding title tag
    add_theme_support( 'title-tag' );

    // Adding Website Logo
    add_theme_support( 'custom-logo', [
      'width'       => 163,
      'flex-height' => true,
      'header-text' => 'Universal Logo',
      'unlink-homepage-logo' => false, // WP 5.5
    ] );
  }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

// Connecting styles and scripts
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );