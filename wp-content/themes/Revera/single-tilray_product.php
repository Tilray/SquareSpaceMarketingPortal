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

get_header(); 
$thisProduct = new Product($post, $productFilters);

$itemPrice = 0;
$itemPriceObj = get_field_object( 'price', get_the_ID() );
if ($itemPriceObj){
	$value = get_field('price', get_the_ID());
	$itemPrice = intval($value);
	$label = $itemPriceObj['choices'][ $value ];	
	if ($itemPrice > 0){
		$productType = trim(get_post_meta(get_the_ID(), 'product_type', true));
		$priceText = format_price_for_current_locale($itemPrice);
		if (strtolower($productType) != "accessory"){
			$priceText .= " " . __('per gram');
		}
		
		$itemStoreLink = trim(get_post_meta(get_the_ID(), 'store_link', true));
	}
}


<<<<<<< HEAD
<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-12">
		<div class="col-sm-6">
			<?php
			$thumbid = get_post_thumbnail_id();
			$img_attrs = wp_get_attachment_image_src( $thumbid,'product-single' );
			$image = $img_attrs[0];
			?>
			<img class="single-product-image" src="<?=$image?>" alt="<?php the_title(); ?>"/>
		</div>
		<div class="col-sm-4">
			<h1 class="mockH2"><?php the_title(); ?></h1>
			<?php 
				$thc = trim($thisProduct->actualthc);
				$cbd = trim($thisProduct->cbd);
				$sep = '.';
				$percentage = '%';
				if (get_current_language_code() == "fr"){
					$sep = ',';
					$percentage = ' %';
				}
				if (strtolower($thisProduct->status) == "available" && (strlen($thc) > 0 || strlen($cbd) > 0)){
					echo '<p>';
					if (strlen($thc) > 0)
						echo _('THC: ') . number_format($thc, 1, $sep, $sep) . $percentage;

					if (strlen($thc) > 0 && strlen($cbd) > 0)
						echo '; ';

					if (strlen($cbd) > 0)
						echo _('CBD: ') . number_format($cbd, 1, $sep, $sep) . $percentage;
					echo '</p>';
				}
				the_content();
				
				$itemPrice = 0;
				$itemPriceObj = get_field_object( 'price', get_the_ID() );
				if ($itemPriceObj){
					$value = get_field('price', get_the_ID());
					$itemPrice = intval($value);
					$label = $itemPriceObj['choices'][ $value ];	
					if (strtolower($thisProduct->status) == "available" && $itemPrice > 0){
						$productType = trim(get_post_meta(get_the_ID(), 'product_type', true));
						$priceText = format_price_for_current_locale($itemPrice);
						if (strtolower($productType) != "accessory"){
							$priceText .= " " . __('per gram');
						}
						
						echo $priceText;
						
						$itemStoreLink = trim(get_post_meta(get_the_ID(), 'store_link', true));
						if ($itemStoreLink){
						?>
							<a href='<?=$itemStoreLink?>' class='inline-btn buy-btn'><?= __('Buy Now')?></a>
						<?php
						}
					}
				}
				
			?>
			
			<div class="single-product-attributes">
			<?php
				$useHCP = array_key_exists('hcp', $_GET);
                $productFilters->status->renderProductsPageLink($thisProduct->status, $useHCP);
                $productFilters->strainCategory->renderProductsPageLink($thisProduct->straincategory, $useHCP);
                $productFilters->productType->renderProductsPageLink($thisProduct->producttypes, $useHCP);
                $productFilters->thc->renderProductsPageLink($thisProduct->thc, $useHCP);                
			?>
			</div>
			<div class="buttons-container">
				<?php
				$disableSocial = trim(ft_of_get_option('fabthemes_disable_social_sharing'));
				if ($disableSocial != "0"){
				?>
					<div class="social-buttons">
						<?php render_social_buttons(get_permalink(), wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0], get_the_title()); ?>
					</div>
				<?php } ?>
			</div>
			
			<?php 
				$disableDisqus = trim(ft_of_get_option('fabthemes_disable_disqus'));
				if (comments_open() && $disableDisqus != "0") : 
			?>
			<div id="disqus_thread"></div>
			<script>
				/**
				 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
				 */
				var disqus_config = function () {
					this.page.url = "<?= get_permalink()?>";  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = "<?=str_replace(" ", "_", get_the_title())?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
				};
				(function() {  // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					
					s.src = '//tilray.disqus.com/embed.js';
					
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
				})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			<?php endif; // comments_open ?>						
			
		</div>
		<div class="col-sm-2">
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
<?php get_footer(); ?>
</div><!-- #page -->
=======
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
		$arrThcAndCbd[] = _('THC: ') . number_format($thc, 1, $sep, $sep) . $percentage;
	if (strlen($cbd) > 0)
		$arrThcAndCbd[] =  _('CBD: ') . number_format($cbd, 1, $sep, $sep) . $percentage;
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
>>>>>>> MobileProductsPage
