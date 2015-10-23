<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package web2feel
   Template name:Blog

 */

get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1> <?php the_title(); ?> </h1>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
		<div id="secondary" class="col-sm-12">
			<?php 
			$catName = 'blog-' . get_current_language_code();
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = array(
				'category_name' => $catName,
				'posts_per_page' => '6',
				'paged' => $paged
			);
			render_news_section($args, $paged, true);
			wp_reset_query();			
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
</div> <!-- #page -->
