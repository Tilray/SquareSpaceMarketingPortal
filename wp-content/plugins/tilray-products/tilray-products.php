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
      'rewrite' => array('slug' => 'products/tilray-products'),
	  'capability_type' => 'post',
	  'taxonomies' => array('post_tag'),
	  'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
	  'hierarchical' => true
    )
  );
}

add_image_size( 'product-thumb', 180, 220, false );
add_image_size( 'product-single', 555, 2000, false );

$allStatuses = array(	"" => array ("en" => "", "fr" => ""), 
						"available" => array ("en" => "Available", "fr" => "Available"), 
						"in-production" => array ("en" => "In Production", "fr" => "In Production"));
						
$allStrainTypes = array(	"" => array ("en" => "", "fr" => ""), 
							"indica" => array ("en" => "Indica", "fr" => "Indica"), 
							"sativa" => array ("en" => "Sativa", "fr" => "Sativa"), 
							"hybrid" => array ("en" => "Hybrid", "fr" => "Hybrid"), 
							"high-cbd" => array ("en" => "High CBD", "fr" => "High CBD"));

$allPrices = array(	"", "8-9", "10-11", "12-13", "14-15");
							
function get_products_page_link($status, $strainType){
	$langCode = get_current_language_code();
	$pageName = "products";
	if ($langCode == "fr"){
		$pageName = "produits";
	}
	return home_url() . "/" . $langCode . "/" . $pageName . "/?status=" . $status . "&strain-types=" . $strainType;
}



function additional_active_item_classes($classes = array(), $menu_item = false){
global $wp_query;

$postType = get_post_type( get_the_ID() );

if (is_single() && ($menu_item->title == 'Products' || $menu_item->title == 'Produits') && $postType == 'tilray_product' ){
    $classes[] = 'current_page_ancestor';
}

return $classes;
}
add_filter( 'nav_menu_css_class', 'additional_active_item_classes', 10, 2 );
