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
				function RenderBanner($postID, $textColor, $linkURL){
					$thisPost = get_post($postID);
					$imageurl = get_the_post_thumbnail($postID, 'banner-image');					
					?>
						<li>
							<a href="<?= $linkURL ?>"><?= $imageurl ?></a>
							<div class="flex-caption">
								<h2><a href="<?= $linkURL ?>" style="color:<?=$textColor?>"></a></h2>
							</div>
						</li>
					<?php
				}
				
				$langCode = strtolower(get_current_language_code());
				
				$banner1ID = ft_of_get_option('fabthemes_banner1_id_' . $langCode);
				if ($banner1ID)
				{
					$url = ft_of_get_option('fabthemes_url1_' . $langCode);
					if ($url == "")
					{
						$url = get_permalink($banner1ID);
					}
					RenderBanner($banner1ID, ft_of_get_option('fabthemes_banner1_text_color'), $url);
				}
				
				$banner2ID = ft_of_get_option('fabthemes_banner2_id_' . $langCode);
				if ($banner2ID)
				{
					$url = ft_of_get_option('fabthemes_url2_' . $langCode);
					if ($url == "")
					{
						$url = get_permalink($banner2ID);
					}
					RenderBanner($banner2ID, ft_of_get_option('fabthemes_banner2_text_color'), $url);
				}
				
				$banner3ID = ft_of_get_option('fabthemes_banner3_id_' . $langCode);
				if ($banner3ID)
				{
					$url = ft_of_get_option('fabthemes_url3_' . $langCode);
					if ($url == "")
					{
						$url = get_permalink($banner3ID);
					}
					RenderBanner($banner3ID, ft_of_get_option('fabthemes_banner3_text_color'), $url);
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

