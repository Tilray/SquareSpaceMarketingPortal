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
					
					$newTab = "";
					var_dump($productUrl = get_post_meta(get_the_ID(), 'open_in_new_tab', true));
					if (get_post_meta(get_the_ID(), 'open_in_new_tab', true) == 'true')
						$newTab = "target='_blank'";
					?>
					<span class="<?=$linkClass?>"><a <?=$newTab?> href="<?php echo get_permalink( $child->ID );?>"><span class="left-nav-bullet"></span><h2><?php echo $child->post_title; ?></h2></a></span>
					<?php
				}
			?>
		</div>
		<div id="primary" class="content-area col-sm-8">
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
