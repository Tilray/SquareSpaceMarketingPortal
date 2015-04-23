<div id="slidebox" class="flexslider">

		<ul class="slides">
		    <?php 	
				function RenderBanner($postID, $textColor, $linkURL){
					$thisPost = get_post($postID);
					$imageurl = get_the_post_thumbnail($thisPost->ID, 'banner-image');
					?>
						<li>
							<a href="<?= $linkURL ?>"><img src="<?= $imageurl ?>"/></a>
							<div class="flex-caption">
								<h2 style="color:<?=$textColor?>"><?= $thisPost->post_title ?></h2>
							</div>
						</li>
					<?php
				}
				
				if (ft_of_get_option('fabthemes_banner1_id'))
				{
					RenderBanner(ft_of_get_option('fabthemes_banner1_id'), ft_of_get_option('fabthemes_banner1_text_color'), ft_of_get_option('fabthemes_url1'));
				}
				
				if (ft_of_get_option('fabthemes_banner2_id'))
				{
					RenderBanner(ft_of_get_option('fabthemes_banner2_id'), ft_of_get_option('fabthemes_banner2_text_color'), ft_of_get_option('fabthemes_url2'));
				}
				
				if (ft_of_get_option('fabthemes_banner3_id'))
				{
					RenderBanner(ft_of_get_option('fabthemes_banner3_id'), ft_of_get_option('fabthemes_banner3_text_color'), ft_of_get_option('fabthemes_url3'));
				}
				?>
		</ul>
<div class="doverlay"></div>
</div>

