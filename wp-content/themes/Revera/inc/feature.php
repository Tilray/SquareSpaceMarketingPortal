<?php
	function QueryBanners()
	{
		$theBanners = array();
		$wp_query = new WP_Query(array('post_type' => 'tilray_banners', 'posts_per_page' => '100' ));
		
		while ($wp_query->have_posts()) : $wp_query->the_post(); 
			$thisBanner = new stdClass;

			$thisBanner->id = get_the_ID();

			$thumbID = get_post_thumbnail_id();
			$img_attrs = wp_get_attachment_image_src( $thumbID,'banner-image' ); 
			$thisBanner->image = $img_attrs[0];
			
			$thisBanner->content = get_the_content();
			$thisBanner->order = get_post_field('menu_order', get_the_ID());
			$thisBanner->link = trim(get_post_meta(get_the_ID(), 'link_url', true));
			
			$theBanners[] = $thisBanner;
		endwhile;
		
		wp_reset_query();

		//2 lines, but still better than messing with WP's query sorting
		function cmp($a, $b){return strcasecmp($a->productName, $b->productName);}
		usort($theBanners , "cmp");		
		
		return $theBanners;
	}


?>
<div id="slidebox" class="flexslider">

		<ul class="slides">
		    <?php 	
				function RenderBanner($content, $imageurl, $linkURL){
					?>
						<li>
							<a href="<?= $linkURL ?>"><img src="<?= $imageurl ?>"></a>
							<div class="flex-caption">
								<?= $content ?>
							</div>
						</li>
					<?php
				}
				
				$theBanners = QueryBanners();
				foreach($theBanners as $thisBanner)
				{
					RenderBanner($thisBanner->content, $thisBanner->image, $thisBanner->link);
				}
				?>
		</ul>
<div class="doverlay"></div>
</div>
<?php
	if (strpos($_SERVER["HTTP_USER_AGENT"], 'Safari') > 0 && !strpos($_SERVER["HTTP_USER_AGENT"], 'Chrome'))
	{
		?>
		<style>
			.flex-caption{
				bottom: 0px;
				top: 0px;
			}	
		</style>
		<?php
	}
?>

