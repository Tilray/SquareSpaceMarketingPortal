<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left Nav with Siblings No Parent
*/
get_header();

$show_left_nav = get_field("show_left_nav_on_mobile");
$show_nav_class = $show_left_nav ? "show-nav" : "";
?>

<div class="page-head <?=$show_nav_class?>">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1> <?php the_title(); ?> </h1>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container <?=$show_nav_class?>">	
	<div class="row">
		<div class="col-sm-3 left-nav-menu">
			<?php
				$parID = wp_get_post_parent_id(get_the_ID());
				render_left_nav($parID, get_the_ID(), false);
			?>
		</div>
		<?php if ($show_left_nav){ ?>
			<div class="col-sm-3 left-nav-menu overlay-menu overlay-shadow">
				<?php
					$parID = wp_get_post_parent_id(get_the_ID());
					render_left_nav($parID, get_the_ID(), false);
				?>
			</div>
		<?php } ?>
		<div id="primary" class="content-area col-sm-8">
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
