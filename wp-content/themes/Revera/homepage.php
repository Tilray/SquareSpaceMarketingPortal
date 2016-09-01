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

header("Vary: User-Agent, Accept"); 

get_header(); ?>

<?php
	$postContent = $post->post_content;
?>

<?php get_template_part( 'inc/feature' ); ?>
<div class="container ">

<?php
	$langCode = get_current_language_code();
	$catName = 'news';
	if (strtolower($langCode) == "fr"){
		$catName = 'nouvelles';
	}
	$newsCategory = get_category_by_slug($catName);
?>
<div class="section-wide">
	<div class="row">
		<div class="col-lg-12 homepage-main-content">
			<?php echo $postContent; ?>
		</div>
	</div>
	<div class="row">
	<div class="boxitems col-lg-12 homepage-blog-container">
		<a href="/<?=strtolower($langCode)?>/<?=$catName?>">
		<h2 class="blog-section"><?=$newsCategory->name?></h2></a>
		 <?php 	
		
        $postsPerPage = $isMobile ? '3' : '6';
		$args = array(
			'category_name' => $catName,
			'post_status' => 'publish',
			'posts_per_page' => $postsPerPage
		);
           
        $pageLinkNumber = $isMobile ? 1 : 2;
		 render_news_section( $args, false, $pageLinkNumber );
		 ?>
		 
	</div>
	<div class="col-4">
	</div>
	
	</div>
</div>

</div>
<?php get_footer(); ?>
</div> <!-- #page -->

