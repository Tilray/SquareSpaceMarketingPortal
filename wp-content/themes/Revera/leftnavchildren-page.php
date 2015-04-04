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
				$childPages = get_child_pages(get_the_ID());
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