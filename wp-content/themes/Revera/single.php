<?php
/**
 * The Template for displaying all single posts.
 *
 * @package web2feel
 */

get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title() ?></h1>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-sm-8">
		<main id="main" class="site-main" role="main">

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	</div>
</div>
<?php get_footer(); ?>