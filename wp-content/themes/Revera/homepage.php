<?php
/**
 * Template name:Homepage
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
	$postContent = $post->post_content;
?>

<?php get_template_part( 'inc/feature' ); ?>
<div class="container">

<?php
	$langCode = get_current_language_code();
	$newsCategoryId = ft_of_get_option('home_news_category' . $langCode);
	$newsCategory = get_category($newsCategoryId);
?>
<div class="section-wide">
	<div class="row">
		<div class="col-12 homepage-main-content">
			<?php echo $postContent; ?>
		</div>
	</div>
	<div class="row">
	<div class="boxitems col-12 homepage-blog-container">
		<a href="/<?=strtolower($langCode)?>/<?=$newsCategory->slug?>">
		<h2 class="blog-section"><?=$newsCategory->name?></h2></a>
		 <?php 	
		
		$catName = 'news';
		if (strtolower(get_current_language_code()) == "fr"){
			$catName = 'nouvelles';
		}
		$args = array(
			'category_name' => $catName,
			'post_status' => 'publish',
			'posts_per_page' => '6'
		);
		 render_news_section( $args, false);
		 ?>
		 
	</div>
	<div class="col-4">
	</div>
	
	</div>
</div>

</div>
<?php get_footer(); ?>
</div> <!-- #page -->

