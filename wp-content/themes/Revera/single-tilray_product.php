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

get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1><?=__('PRODUCTS')?></h1>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

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
			<h2><?php the_title(); ?></h2>
			<?php 
				the_content();
				
				$itemPrice = 0;
				$itemPriceObj = get_field_object( 'price', get_the_ID() );
				if ($itemPriceObj){
					$value = get_field('price', get_the_ID());
					$itemPrice = intval($value);
					$label = $itemPriceObj['choices'][ $value ];	
					if ($itemPrice > 0){
						?>
							<?=format_price_for_current_locale($itemPrice) . " " . __('per gram')?>
							
						<?php
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
				$currLangCode = strtolower(get_current_language_code());
				$itemStatus = trim(get_post_meta(get_the_ID(), 'status', true));
				$itemStatusName = $allStatuses[$itemStatus][$currLangCode];
				$itemStrainType = trim(get_post_meta(get_the_ID(), 'strain_type', true));
				$itemStrainName = $allStrainTypes[$itemStrainType][$currLangCode];
				$itemCategory = trim(get_post_meta(get_the_ID(), 'product_category', true));
				$itemCategoryName = $allProducts[$itemCategory][$currLangCode];
				
				if ($itemStatus){
					?><a href="<?= get_products_page_link($itemStatus, "", "") ?>"><?=__($itemStatusName)?></a><?php
				}
				
				if ($itemStrainType){
					?><a href="<?= get_products_page_link("", $itemStrainType, "") ?>"><?=__($itemStrainName)?></a><?php
				}				
				
				if ($itemCategory){
					?><a href="<?= get_products_page_link("", "", $itemCategory) ?>"><?=__($itemCategoryName)?></a><?php
				}				
			?>
			</div>
		</div>
		<div class="col-sm-2">
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
<?php get_footer(); ?>
</div><!-- #page -->
