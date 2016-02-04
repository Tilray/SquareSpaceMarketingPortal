<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left Nav with Children
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
		<div id="secondary" class="col-sm-3 left-nav-menu">
			<?php
				render_left_nav(get_the_ID(), get_the_ID());
			?>
		</div>
		<div id="primary" class="content-area col-sm-9">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div>
<?php get_footer(); ?>
</div> <!-- #page -->
