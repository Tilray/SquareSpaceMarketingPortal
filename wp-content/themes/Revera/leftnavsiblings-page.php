<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left Nav with Siblings
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
				$parID = wp_get_post_parent_id(get_the_ID());
				$childPages = get_child_pages($parID);
				foreach ($childPages as $child)
				{
					$linkClass = "none";
					if ($child->ID == get_the_ID())
					{
						$linkClass = "left-nav-selected-child";
					}
					?>
					<p><a href="<?php echo get_permalink( $child->ID );?>"><h2 class="<?=$linkClass?>"><?php echo $child->post_title; ?></h2></a></p>
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
</div> <!-- #page -->
<?php get_footer(); ?>
