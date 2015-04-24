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
      'rewrite' => array('slug' => 'tilray-products'),
	  'capability_type' => 'post',
	  'taxonomies' => array('post_tag'),
	  'supports' => array('title', 'editor', 'thumbnail', 'excerpt')
    )
  );
}

add_image_size( 'product-thumb', 270, 240, false );
add_image_size( 'product-single', 555, 2000, false );

$allStatuses = array("", "available", "in-production");
$allStrainTypes = array("", "indica", "sativa", "hybrid", "high-cbd");

function get_products_page_link($status, $strainType){
	$langCode = get_current_language_code();
	$pageName = "products";
	if ($langCode == "fr"){
		$pageName = "produits";
	}
	return "/" . $langCode . "/" . $pageName . "/?status=" . $status . "&straintype=" . $strainType;
}
