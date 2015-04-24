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