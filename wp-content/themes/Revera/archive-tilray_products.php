<?php

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
		<ul>
			<li class="product-filter-button" data-filter="*">Show All</li>
			<li class="product-filter-button" data-filter=".category-indica">Indicas</li>
			<li class="product-filter-button" data-filter=".category-sativa">Sativas</li>
			<li class="product-filter-button" data-filter=".category-kush">Kushes</li>
		</ul>
	</div>
	<div class="row">
	
		<div id="primary" class="js-isotope" data-isotope-options='{ "columnWidth": 200, "itemSelector": ".product-item" }'>
		<?php
		$port_count = ft_of_get_option('fabthemes_port_number');
		$port_cat =ft_of_get_option('fabthemes_portfolio');
		
		if ( get_query_var('paged') )
		    $paged = get_query_var('paged');
		elseif ( get_query_var('page') )
		    $paged = get_query_var('page');
		else
		    $paged = 1;
		$wp_query = new WP_Query(array('post_type' => 'tilray_product', 'posts_per_page' => $port_count, 'paged' => $paged ));
		?>
		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); 
				$all_the_tags = wp_get_post_tags( get_the_ID() );
				$combined_tags = "";
				foreach($all_the_tags as $this_tag){
					$combined_tags = $combined_tags . " category-" . strtolower($this_tag->slug);
				}
		?>
		 <div class="col-sm-3 col-6 portbox post product-item <?= $combined_tags?>">
					
		 <?php
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 750, 500, true ); //resize & crop the image
		 ?>
					
		 <?php if($image) : ?>
			<div class="hthumb">
			 	<a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $image ?>"/></a>
		 	</div>
		 <?php endif; ?>

		 <h3><a href="<?php the_permalink(); ?>"><p class="title"><?php the_title(); ?></p></a></h3>
		 
		 </div>
			

				<?php endwhile; ?>
</div>



	</div>
</div>

<script>
	function filterProducts(filter)
	{
		jQuery('#primary').isotope({ filter: filter });
	}
	
	jQuery( document ).ready(function() {
		jQuery('.product-filter-button').click(function() {
			filterProducts(jQuery( this ).attr('data-filter'));
		});
	});
</script>

<?php get_footer(); ?>
