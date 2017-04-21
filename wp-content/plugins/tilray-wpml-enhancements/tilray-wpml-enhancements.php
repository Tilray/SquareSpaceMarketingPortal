<?php
 
/*
Plugin Name: Tilray WPML Enhancements
Description: Adds additional functionality like menus to WPML
Author: Kyall Barrows
Version: 1.0
*/
function get_current_language(){
	if (!function_exists('icl_get_languages'))
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

function format_price_for_current_locale($price, $include_structured_data_tags = false){
	if (get_current_language_code() == "en")
	{
		if ($include_structured_data_tags)
			return "<span itemprop='priceCurrency' content='CAD'>$</span><span itemprop='price'>" . number_format($price, 2) . "</span>";
		else
			return "$" . number_format($price, 2);
	}
		
	if ($include_structured_data_tags)
		return "<span itemprop='price'>" . number_format($price, 2, ',', '') . "</span>&nbsp;<span itemprop='priceCurrency' content='CAD'>$</span>";
	else
		return number_format($price, 2, ',', '') . " $";
}

function render_language_chooser($ul_class){
	if (!function_exists('icl_get_languages'))
		return;
		
	?><ul class="<?=$ul_class; ?>"><?php
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		?><li><a href="<?=$lang["url"]?>"><?=$lang["native_name"]?></a></li><?php
	}
	?></ul><?php
}

function get_other_language(){
	if (!function_exists('icl_get_languages'))
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

