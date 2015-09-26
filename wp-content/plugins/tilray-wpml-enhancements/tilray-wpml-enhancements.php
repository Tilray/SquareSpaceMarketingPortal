<?php
 
/*
Plugin Name: Tilray WPML Enhancements
Description: Adds additional functionality like menus to WPML
Author: Kyall Barrows
Version: 1.0
*/
function get_current_language(){
	if (!function_exists(icl_get_languages))
		return NULL;
		
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["active"] == "1"){
			return $lang;
		}
	}
}


function get_current_language_name(){
	$currLang = get_current_language();
	if ($currLang !== NULL){
		return $currLang["native_name"];
	}
	
	return "-";
}

function get_current_language_code(){
	$currLang = get_current_language();
	if ($currLang !== NULL){
		return $currLang["language_code"];
	}
	
	return "-";
}

function get_current_locale(){
	$currLang = get_current_language();
	if ($currLang !== NULL){
		return $currLang["default_locale"];
	}
	
	return "-";
}

function format_price_for_current_locale($price){
	if (get_current_language_code() == "en")
		return "$" . $price . ".00";
		
	return $price . ",00 $";
}

function render_language_chooser($ul_class){
	if (!function_exists(icl_get_languages))
		return;
		
	?><ul class="<?=$ul_class; ?>"><?php
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		?><li><a href="<?=$lang["url"]?>"><?=$lang["native_name"]?></a></li><?php
	}
	?></ul><?php
}

function get_other_language(){
	if (!function_exists(icl_get_languages))
		return NULL;

	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["active"] == "0"){
			return $lang;
		}
	}
}

function get_wpml_home_url(){
	if (strtolower(get_current_language_code()) == "en")
	{	
		return site_url();
	}
	
	return get_home_url();
}

// A copy of rel_canonical but to allow an override on a custom tag
function rel_canonical_with_custom_tag_override()
{
	if (!function_exists(icl_get_languages))
		return;
		
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["language_code"] == get_current_language_code()){
		
			//if we're rendering out the homepage, don't use /en, because it's 301'd over to /
			if ($lang["language_code"] == "en" && $lang["url"] == get_home_url())
				echo "<link rel='canonical' href='" . site_url() . "' />\n";
			else
				echo "<link rel='canonical' href='" . esc_url( $lang["url"] ) . "' />\n";
		}
	}
}

// remove the default WordPress canonical URL function
if( function_exists( 'rel_canonical' ) )
{
    remove_action( 'wp_head', 'rel_canonical' );
}
// replace the default WordPress canonical URL function with your own
add_action( 'wp_head', 'rel_canonical_with_custom_tag_override' );