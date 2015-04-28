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

<div class="section-wide">
	<div class="row">
	<div class="boxitems col-8">
		<h2><?php _e('NEWS'); ?></h2>
		 <?php 	
		 //this doesn't play well: it's a global setting, not per language.  need to fix
		 //$updates_cat = ft_of_get_option('homepage_updates_category');
		 $langCode = get_current_language_code();
		 $query = new WP_Query( array( 'cat' => 'Blog-' . strtoupper($langCode),'posts_per_page' =>4 ) );
		 if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
		 	
		 <div class="homepage-blog-list">
			 <h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>
			 <h4> <?php echo get_the_date();?> </h4>
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
