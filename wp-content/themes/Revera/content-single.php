<?php
/**
 * @package web2feel
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 780, 400, true ); //resize & crop the image
		?>
					
		<?php if($image) : ?>
		<img class="img-responsive" src="<?php echo $image ?>"/>
		<?php endif; ?>		

	<div class="entry-content">
				
		<?php the_content(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
