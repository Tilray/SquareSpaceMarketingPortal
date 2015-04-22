<div id="slidebox" class="flexslider">

		<ul class="slides">
		    <?php 	
					$catName = 'banners-' . get_current_language_code();

					$query = new WP_Query( array( 'category_name' => $catName,'posts_per_page' =>'100' ) );
		           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
		 	
			 		<li>
			 			
					<?php
						$thumb = get_post_thumbnail_id();
						$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
						$image = aq_resize( $img_url, 1200, 550, true ); //resize & crop the image
					?>
					
					<?php if($image) : ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>"/></a>
					<?php endif; ?>
	
					<div class="flex-caption">
						<h2><?php the_title(); ?></h2>
					</div>
			<?php endwhile; endif; ?>
					    		
		  </li>
		</ul>
<div class="doverlay"></div>
</div>

