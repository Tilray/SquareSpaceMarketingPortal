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

<?php 
/** 
* so the wpml language plugin kills the 404 page and causes it to render out in the Page template. This is a hackaround, hopefully finding better way soon.
**/
if (is_404()){	
	require get_template_directory() . '/inc/404body.php';
}
else
{
?>
<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12 page-page">
				<h1> <?php the_title(); ?> </h1>
				<p> </p>
			</div>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-sm-8">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	</div>
</div>
</div><!-- #page -->
<?php } //end giant if block for 404 hack-around ?>
<?php get_footer(); ?>
