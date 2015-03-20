<?php
 
/*
Plugin Name: Tilray Products
Description: Adds custom post type for Tilray Products
Author: Kyall Barrows
Version: 1.0
*/

add_action( 'init', 'create_posttype' );
function create_posttype() {
  register_post_type( 'tilray_product',
    array(
      'labels' => array(
        'name' => __( 'Tilray Products' ),
        'singular_name' => __( 'Tilray Product' ),
		'new_item' => __('New Product'),
		'search_items' => __('Search Products')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'products'),
	  'capability_type' => 'post',
	  'taxonomies' => array('post_tag')
    )
  );
}