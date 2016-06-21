<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package web2feel
 */

get_header(); 
?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>Search</h1>
				<p><?php printf( __( 'You searched for: %s', 'web2feel' ), '<span>' . get_search_query() . '</span>' ); ?> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div class="search-result col-sm-12">
					<div class="search-image col-2">
						<?php
						$thumbID = get_post_thumbnail_id();
						$img_attrs = wp_get_attachment_image_src( $thumbID,'blog-preview' ); 
						$image = $img_attrs[0];
						if(!$image) {
							$image = get_bloginfo('stylesheet_directory') . '/images/defaultimage_360x202.png';
						}
						?>
						<a href="<?php the_permalink(); ?>"><img class="blog-preview" src="<?= $image ?>" alt="<?php the_title();?>"/></a>
					</div>
					<div class="search-result-body col-6">
						<h3><?php
						 $rawType = get_post_type();
						 switch(strtolower($rawType)){
						 	case "post":
						 		echo __('News Page');
						 		break;
						 	case "tilray_product":
						 		echo __('Product Page');
						 		break;
						 	default:
						 		echo __('Information Page');
						 }
						 ?></h3>
						<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
						<p>
							<?php echo custom_excerpt(25); ?>
							<a class="read-more-link" href="<?php the_permalink(); ?>"><?= __('Read more') ?> &raquo;</a>
						</p>
					</div>
				</div>

			<?php 
			endwhile; 

			$page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
            $otherPage = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $paged = max($page, $otherPage);
			$args = array(
				$searchType => $searchValue,
				'posts_per_page' => '6',
				'paged' => $paged
			);

			?><div class="col-12">
			<div class="navigation pagination-buttons"><p><?php 
				previous_posts_link("<i class='fa fa-arrow-left'></i>&nbsp;&nbsp;prev");
				next_posts_link("next&nbsp;&nbsp;<i class='fa fa-arrow-right'></i>");
			?></p></div>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>