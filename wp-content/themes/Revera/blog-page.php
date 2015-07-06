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
		<div id="secondary" class="col-sm-8">
			<?php 
			$catName = 'blog-' . get_current_language_code();
			$args = array(
				'category_name' => $catName,
				'posts_per_page' => '10'
			);
			render_news_section($args, true, true);
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
</div> <!-- #page -->
