<?php
 
/*
Plugin Name: Tilray Products
Description: Adds custom post type for Tilray Products
Author: Kyall Barrows
Version: 1.0
*/


<?php

function create_table(){
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . "_productalerts";

    $sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		product_id bigint(20) NOT NULL,
		email varchar(128) NOT NULL,
		datetime TIMESTAMP NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function tilrayproducts_activate() {
    error_log("Tilray Products Plugin: activating");
    create_table();
}

register_activation_hook( __FILE__, 'tilrayproducts_activate' );


function get_alert_addresses($product_id){
    return $wpdb->get_results("SELECT `email` FROM {$wpdb->prefix}_productalerts WHERE product_id = $product_id");
}

function add_email($product_id, $email){
    global $wpdb;
    $sql = $wpdb->prepare("INSERT INTO `{$wpdb->prefix}_productalerts` (`product_id`, `email`, `timestamp`) values (%s, %s, now())",
        $product_id, $email);
    $wpdb->query($sql);
}

function register_for_prodcut_alerts_func( $terms_page, $product_id ){
    ?>
    <form action='<?=$terms_page?>'><input type='text' name='email'><input type='hidden' name='product_id' value='<?=$product_id?>'/><input type='submit' value='Submit'/></form>
    <?php
}

function accept_product_alerts_terms_func( $atts ){
    $email = $_GET['email'];
    $product_id = $_GET['product_id'];
    $thank_you_page = $atts['thank_you_page'];
    $output = "";
    $output .= "<form action='$thank_you_page' method='POST'>";
    $output .= "<input type='hidden' name='email' value='$email'>";
    $output .= "<input type='hidden' name='product_id' value='$product_id'/>";
    $output .= "<input type='submit' value='Accept'/>";
    $output .= "</form>";
    return $output;
}
add_shortcode( 'accept_product_alerts_terms', 'accept_product_alerts_terms_func' );


?>
