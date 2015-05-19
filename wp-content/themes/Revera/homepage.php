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
		<h2><?=get_the_title($pageId)?></h2></a>
		 <?php 	
		 
		 $query = new WP_Query( array( 'cat' => 'Blog-' . strtoupper($langCode),'posts_per_page' => 6 ) );
		 if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
		 	
			$thumb = get_post_thumbnail_id();
			$img_attrs = wp_get_attachment_image_src( $thumb,'blog-homepage' ); 
			$image = $img_attrs[0];
			?>
			
			 <div class="homepage-blog-list">
				<a href="<?php the_permalink(); ?>"><img src="<?= $image ?>" alt="<?php the_title(); ?>"/></a>
				<h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>
			 </div>
		
		 <?php endwhile; endif; ?>
		 
	</div>
	<div class="col-4">
	</div>
	
	</div>
</div>

</div>
</div> <!-- #page -->

<?php get_footer(); ?>
