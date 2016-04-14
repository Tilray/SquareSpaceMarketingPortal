<?php
	function QueryBanners()
	{
		$theBanners = array();
		$wp_query = new WP_Query(array('post_type' => 'tilray_banners', 'posts_per_page' => '100' ));
        global $isMobile;
		$imageSize = $isMobile ? 'mobile-banner' : 'full';
        
		while ($wp_query->have_posts()) : $wp_query->the_post(); 
			$thisBanner = new stdClass;

			$thisBanner->id = get_the_ID();

			$thumbID = get_post_thumbnail_id();
			$img_attrs = wp_get_attachment_image_src( $thumbID, $imageSize); 
			$thisBanner->image = $img_attrs[0];
			$thisBanner->width = $img_attrs[1];
			$thisBanner->height = $img_attrs[2];
			
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


$defaultHomepageBG = get_field('default_homepage_banner', 'option');
?>
<div id="slidebox" class="flexslider" style="background-image:url(<?=$defaultHomepageBG?>)">

		<ul class="slides" style="display:none;">
		    <?php 	
				function RenderBanner($content, $imageurl, $width, $height, $linkURL){					
					?>
						<li>
							<a href="<?= $linkURL ?>"><img width="<?=$width?>" height="<?=$height?>" data-src="<?= $imageurl ?>"></a>
							<div class="flex-caption">
								<?= $content ?>
							</div>
						</li>
					<?php
				}
				
				$theBanners = QueryBanners();
				foreach($theBanners as $thisBanner)				
				{
					RenderBanner($thisBanner->content, $thisBanner->image, $thisBanner->width, $thisBanner->height, $thisBanner->link);
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
<script>
	function setAllBannerSrcs(){
    	jQuery('div.flexslider ul.slides li img').each(function(){jQuery(this).attr('src', jQuery(this).attr('data-src')); console.log("setting src :" + jQuery(this).attr('data-src'));});	

    	jQuery('div.flexslider ul.slides').css('display', 'block');
		jQuery('#slidebox').flexslider({
			animation: "fade",
			directionNav:true,
			controlNav:false
		});    		
	}

	jQuery(window).load(function() {
		var allBannerUrls = new Array();
    	jQuery('div.flexslider ul.slides li img').each(function(){
    		allBannerUrls.push(jQuery(this).attr('data-src'));
    	});

		var len = allBannerUrls.length;
		var loadCounter = 0;
		for(var i = 0; i < len; i++) {
		    jQuery(document.createElement('img')).attr('src', allBannerUrls[i]).one("load", function() {
		        loadCounter++;
		        if(loadCounter === len) {
		            setAllBannerSrcs();   
		        }
		    }).each(function() {
		        if(this.complete) jQuery(this).trigger("load");
		    });
		}    	
	});
</script>

