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
			$args = array(
				'category_name' => 'blog,blogue',
				'posts_per_page' => '10'
			);
			$the_query = new WP_Query( $args ); ?>

			<?php if ( $the_query->have_posts() ) : ?>

				<!-- pagination here -->

				<!-- the loop -->
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<h2><?php the_title(); ?></h2>
				<?php endwhile; ?>
				<!-- end of the loop -->

				<!-- pagination here -->
				<div class="navigation"><p><?php posts_nav_link(); ?></p></div>

				<?php wp_reset_postdata(); ?>

			<?php else : ?>
				<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
</div> <!-- #page -->
<?php get_footer(); ?>
