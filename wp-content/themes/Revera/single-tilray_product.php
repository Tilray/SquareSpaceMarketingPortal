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
				<h1>PRODUCTS</h1>
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
			<img class="single-product-image" src="<?=$image?>"/>
		</div>
		<div class="col-sm-4">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
			<div class="single-product-attributes">
			<?php
				$statusCats = get_all_categories_for_post_from_set($post->ID, $allStatuses);
				$strainCats = get_all_categories_for_post_from_set($post->ID, $allStrainTypes);
				
				if ($statusCats){
					foreach($statusCats as $status)
					{
						?><a href="<?= get_products_page_link($status, "") ?>"><?=$status?></a><?php
					}
				}
				
				if ($strainCats){
					foreach($strainCats as $strain)
					{
						?><a href="<?= get_products_page_link("", $strain) ?>"><?=$strain?></a><?php
					}
				}				
			?>
			</div>
		</div>
		<div class="col-sm-2">
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
</div><!-- #page -->
<?php get_footer(); ?>
