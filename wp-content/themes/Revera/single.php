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
				<h1>News</h1>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2><?php the_title() ?></h2>
					<div class="col-sm-4">
						<?php
							$thumb = get_post_thumbnail_id();
							$img_url = wp_get_attachment_url( $thumb,'blog-featured-image' ); //get full URL to image (use "large" or "medium" if the images too big)
							if($image) : ?>
						<img class="img-responsive single-post-featured-image" src="<?php echo $img_url ?>"/>
						<?php endif; ?>		
					</div>
					<div id="primary" class="content-area col-sm-8">
						<main id="main" class="site-main" role="main">
							<div class="entry-content">
								<?php the_content(); ?>
							</div><!-- .entry-content -->
						<?php endwhile; // end of the loop. ?>
						</main><!-- #main -->
					</div><!-- #primary -->
				</article><!-- #post-## -->
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>