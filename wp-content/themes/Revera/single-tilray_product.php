<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package web2feel
 */

header("Vary: User-Agent, Accept");

$extra_header_content = "<!--\n" . 
"<PageMap><DataObject type='document'><Attribute name='title'>The Biomechanics of a Badminton Smash</Attribute></DataObject></PageMap>\n" . 
"-->";

$structured_data_itemscope = 'itemscope itemtype="http://schema.org/Product"';

get_header(); 
$is_accessories_page = ('accessory' === get_field('product_type', get_the_ID()));
$filterSet = NULL;
if ($is_accessories_page){
	$filterSet = $filterSet = new AccessoriesFilters();
}
else{
	$filterSet = new ProductFilters();
}

$thisProduct = new Product($post, $filterSet);

$itemStoreLink = "";
$itemStoreLink = trim(get_post_meta(get_the_ID(), 'store_link', true));
$itemPrice = 0;
$itemPriceObj = get_field_object( 'price', get_the_ID() );
if ($itemPriceObj){
	$value = get_field('price', get_the_ID());
	$itemPrice = floatval($value);
	$label = $itemPriceObj['choices'][ $value ];	
	if ($itemPrice > 0){
		$productType = trim(get_post_meta(get_the_ID(), 'product_type', true));
		$priceText = format_price_for_current_locale($itemPrice, true) . " " . __($thisProduct->unitLabel);
	}
}

$profile = $thisProduct->profile;
$thc = trim($thisProduct->actualthc);
$cbd = trim($thisProduct->cbd);
$sep = '.';
$percentage = '%';
if (get_current_language_code() == "fr"){
	$sep = ',';
	$percentage = ' %';
}

$arrThcAndCbd = array();
$thcAndCbdText = '';

if (strtolower($thisProduct->status) == "available" && (strlen($thc) > 0 || strlen($cbd) > 0)){
	if (strlen($thc) > 0)
		$arrThcAndCbd[] = __('THC: ') . number_format($thc, 1, $sep, $sep) . $percentage;
	if (strlen($cbd) > 0)
		$arrThcAndCbd[] =  __('CBD: ') . number_format($cbd, 1, $sep, $sep) . $percentage;
}

$thcAndCbdText = implode('; ', $arrThcAndCbd);

if ($deviceType === 'phone')
{
	require_once 'single-tilray-product-mobile.php';
}
else
{
	require_once 'single-tilray-product-desktop.php';
}
?>
