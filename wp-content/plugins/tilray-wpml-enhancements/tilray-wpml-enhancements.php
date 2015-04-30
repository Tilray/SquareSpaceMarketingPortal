<?php
 
/*
Plugin Name: Tilray WPML Enhancements
Description: Adds additional functionality like menus to WPML
Author: Kyall Barrows
Version: 1.0
*/

function get_current_language_name(){
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["active"] == "1"){
			return $lang["native_name"];
		}
	}
	
	return "-";
}

function get_current_language_code(){
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["active"] == "1"){
			return $lang["language_code"];
		}
	}
	
	return "-";
}


function render_language_chooser($ul_class){
	?><ul class="<?=$ul_class; ?>"><?php
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		?><li><a href="<?=$lang["url"]?>"><?=$lang["native_name"]?></a></li><?php
	}
	?></ul><?php
}

function get_other_language(){
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["active"] == "0"){
			return $lang;
		}
	}
}

// A copy of rel_canonical but to allow an override on a custom tag
function rel_canonical_with_custom_tag_override()
{
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		echo "<link rel='canonical' href='" . esc_url( $lang["url"] ) . "' hreflang='". strtolower($lang["tag"])."'/>\n";
	}
}

// remove the default WordPress canonical URL function
if( function_exists( 'rel_canonical' ) )
{
    remove_action( 'wp_head', 'rel_canonical' );
}
// replace the default WordPress canonical URL function with your own
add_action( 'wp_head', 'rel_canonical_with_custom_tag_override' );