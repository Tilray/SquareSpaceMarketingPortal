<?php
 
/*
Plugin Name: Tilray Banners
Description: Adds custom post type for Tilray Banners
Author: Kyall Barrows
Version: 1.0
*/


add_action( 'init', 'create_tilray_banners' );
function create_tilray_banners() {
  register_post_type( 'tilray_banners',
    array(
      'labels' => array(
        'name' => __( 'Banners' ),
        'singular_name' => __( 'Banner' ),
		'new_item' => __('New Banner'),
		'search_items' => __('Search Banners')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'products/tilray-banners'),
	  'capability_type' => 'post',
	  'taxonomies' => array('post_tag'),
	  'supports' => array('title', 'editor', 'thumbnail'),
	  'hierarchical' => false
    )
  );
}

