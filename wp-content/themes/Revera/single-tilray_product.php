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
			$img_attrs = wp_get_attachment_image_src( $thumbid,'product-thumb' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = $img_attrs[0];
			?>
			<img class="single-product-image" src="<?=$image?>"/>
		</div>
		<div class="col-sm-4">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
			<div class="single-product-attributes">
				<a href="*">Available</a> <a href="*">Sativa</a>
			</div>
		</div>
		<div class="col-sm-2">
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
</div><!-- #page -->
<?php get_footer(); ?>
