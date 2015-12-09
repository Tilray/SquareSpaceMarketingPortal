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
						
$allStrainCategories = array(	"" => array ("en" => "", "fr" => ""), 
							"indica" => array ("en" => "Indica", "fr" => "Indica"), 
							"sativa" => array ("en" => "Sativa", "fr" => "Sativa"), 
							"hybrid" => array ("en" => "Hybrid", "fr" => "Hybrid"), 
							"high-cbd" => array ("en" => "+CBD", "fr" => "+CBD"));

$allProducts = array(	"" => array ("en" => "", "fr" => ""), 
						"flower" => array ("en" => "Flower", "fr" => "Flower"), 
						"blend" => array ("en" => "Blend", "fr" => "Blend"), 
						"extract" => array ("en" => "Extract", "fr" => "Extract"),
						"accessory" => array ("en" => "Accessory", "fr" => "Accessory")
					);

$allTHCs = array(	"" => "", 
					"0-14" => "< 15%", 
					"15-20" => "15% - 20%", 
					"21-25" => "21% - 25%", 
					"26-100" => "> 25%");
					
$allPrices = array(	"" => "", 
					"4-6" => "$4-6", 
					"7-9" => "$7-9", 
					"10-12" => "$10-12", 
					"13-1000" => "$13+");

					
function get_products_page_link($status, $strainType, $productType, $thcRange){
	$langCode = get_current_language_code();
	$pageName = "products";
	if ($langCode == "fr"){
		$pageName = "produits";
	}
	
	$url = home_url("/") . $pageName . "/?";
	
	if ($status != "")
		$url .= ("status=" . $status);
		
	else if ($strainType != "")
		$url .= ("strain-categories=" . $strainType);
		
	else if ($productType != "")
		$url .= ("product-types=" . $productType);
		
	else if ($thcRange != "")
		$url .= ("thc=" . $thcRange);
	
	return $url;
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
