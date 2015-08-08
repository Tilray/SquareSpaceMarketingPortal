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

<?php if( is_page_template('homepage.php') ){ get_template_part( 'inc/feature' ); } ?>


<div class="container">

<div class="section-wide">
	<div class="row">
		<div class="col-12 homepage-main-content">
			<?php echo $postContent; ?>
		</div>
	</div>
</div>

<?php
	$langCode = get_current_language_code();
	$pageId = ft_of_get_option('fabthemes_blog_page_id_' . $langCode);
	$page = get_page( $pageId );
?>
<div class="section-wide">
	<div class="row">
	<div class="boxitems col-12 homepage-blog-container">
		<a href="<?=get_permalink($pageId)?>">
		<h2 class="blog-section"><?=get_the_title($pageId)?></h2></a>
		 <?php 	
		 
		$catName = 'blog-' . get_current_language_code();
		$args = array(
			'category_name' => $catName,
			'posts_per_page' => '6'
		);
		 render_news_section( $args, true, false);
		 ?>
		 
	</div>
	<div class="col-4">
	</div>
	
	</div>
</div>

</div>
<?php get_footer(); ?>
</div> <!-- #page -->

