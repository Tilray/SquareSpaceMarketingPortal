<?php
 
/*
Plugin Name: Tilray Products
Description: Adds custom post type for Tilray Products
Author: Kyall Barrows
Version: 1.0
*/


function create_table(){
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . "productalerts";

    $sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		product_id bigint(20) NOT NULL,
		email varchar(128) NOT NULL,
		datetime TIMESTAMP NOT NULL,
        processed BOOL NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

function tilrayproducts_activate() {
    create_table();
}

register_activation_hook( __FILE__, 'tilrayproducts_activate' );


function get_alert_addresses($product_id){
    global $wpdb;
    return $wpdb->get_results("SELECT `email` FROM {$wpdb->prefix}productalerts WHERE product_id = $product_id AND processed = '0'");
}

function add_email($product_id, $email){
    global $wpdb;
    $sql = $wpdb->prepare("INSERT INTO `{$wpdb->prefix}productalerts` (`product_id`, `email`, `datetime`, `processed`) values (%d, %s, now(), FALSE)",
        $product_id, $email);
    $wpdb->query($sql);
    return $sql;
}

function register_for_prodcut_alerts_func( $terms_page, $product_id ){
    ?>
    <form action='<?=$terms_page?>'><input type='text' name='email'><input type='hidden' name='product_id' value='<?=$product_id?>'/><input type='submit' value='Submit'/></form>
    <?php
}

function accept_product_alerts_terms_func( $atts ){
    if (!isset($_GET['product_id']))
        return "<p>Internal error. Please go back to previous page and try again.</p>";

    $product_id = $_GET['product_id'];
    $thank_you_page = $atts['thank_you_page'];
    $nonce = wp_create_nonce( 'email-alerts' );
    $output = "";
    $output .= "<div class='gray-form'>";
    $output .= "<form class='normal' action='$thank_you_page' method='POST'>";
    $output .= "<label for='email'>" . __("Email") . "</label>";
    $output .= "<input type='text' name='email'>";
    $output .= "<input type='hidden' name='nonce' value='$nonce'>";
    $output .= "<input type='hidden' name='product_id' value='$product_id'/>";
    $output .= "<input type='submit' value='" . __("Accept") . "'/>";
    $output .= "</form>";
    $output .= "</div>";
    return $output;
}
add_shortcode( 'accept_product_alerts_terms', 'accept_product_alerts_terms_func' );

function handle_email_alert_signup_func( $atts ){
    $nonce = $_REQUEST['nonce'];
    if (!wp_verify_nonce($nonce, 'email-alerts')){
        return "Internal error: unable to add email address. " . $nonce;
    }

    $email = $_REQUEST['email'];
    $product = $_REQUEST['product_id'];

    add_email($product, $email);

    return "Added email";
}
add_shortcode( 'handle_email_alert_signup', 'handle_email_alert_signup_func' );


// The Event Location Metabox

function wpt_product_alerts() {
    global $post;

    echo "<h4><i>Check box and update post to mark as sent</i></h4>";
    $emails = get_alert_addresses($post->ID);
//    echo "<textarea rows='10' style='width:100%'>";
    foreach($emails as $email){
        echo "<p><input type='checkbox' name='processed_email[]' value='". $email->email ."'>" . $email->email . "</input></p>\n";
    }
//    echo "</textarea>";

    wp_nonce_field( basename( __FILE__ ), 'product-alerts-nonce' );
}

function add_tilray_products_email_alerts_metabox() {
    add_meta_box('wpt_product_alerts', 'Product Alerts', 'wpt_product_alerts', 'tilray_product', 'side', 'default');
}

add_action( 'add_meta_boxes', 'add_tilray_products_email_alerts_metabox' );


function tilray_products_save_email_alerts_metabox( $post_id ){
    global $wpdb;

    if ( !isset( $_POST['product-alerts-nonce'] ) || !wp_verify_nonce( $_POST['product-alerts-nonce'], basename( __FILE__ ) ) ){
        return;
    }

    if (isset($_POST['processed_email'])){
        foreach($_POST['processed_email'] as $email){
            $sql = $wpdb->prepare("UPDATE `{$wpdb->prefix}productalerts` SEt `processed` = '1' WHERE `product_id` = '%s' AND `email` = '%s'",
                $post_id, $email);
            $wpdb->query($sql);
        }
    }
//    $sql = $wpdb->prepare("UPDATE `wp_productalerts` SET `processed` = 1 WHERE `wp_productalerts`.`product_id` = %d", $post_id);
//    $wpdb->query($sql);
}
add_action( 'save_post', 'tilray_products_save_email_alerts_metabox');

?>
