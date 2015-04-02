<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left Nav
*/
get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3> <?php the_title(); ?> </h3>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
		<div id="secondary" class="col-sm-3">
			<?php
				$parID = wp_get_post_parent_id(get_the_ID());
				if ($parID)
				{
					$childPages = get_child_pages($parID);
					foreach ($childPages as $child)
					{
						$linkClass = "none";
						if ($child->ID == get_the_ID())
						{
							$linkClass = "left-nav-selected-child";
						}
						?>
						<p><a href="<?php echo get_permalink( $child->ID );?>"><h3 class="<?=$linkClass?>"><?php echo $child->post_title; ?></h3></a></p>
						<?php
					}
				}
				else
				{
					echo "NO";
				}
			?>
		</div>
		<div id="primary" class="content-area col-sm-9">
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
<?php get_footer(); ?>
