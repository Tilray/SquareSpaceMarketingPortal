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
								<h2><a href="<?= $linkURL ?>" style="color:<?=$textColor?>"><?= $thisPost->post_title ?></a></h2>
							</div>
						</li>
					<?php
				}
				
				$langCode = strtolower(get_current_language_code());
				
				if (ft_of_get_option('fabthemes_banner1_id_' . $langCode))
				{
					RenderBanner(ft_of_get_option('fabthemes_banner1_id_' . $langCode), ft_of_get_option('fabthemes_banner1_text_color'), ft_of_get_option('fabthemes_url1_' . $langCode));
				}
				
				if (ft_of_get_option('fabthemes_banner2_id_' . $langCode))
				{
					RenderBanner(ft_of_get_option('fabthemes_banner2_id_' . $langCode), ft_of_get_option('fabthemes_banner2_text_color'), ft_of_get_option('fabthemes_url2_' . $langCode));
				}
				
				if (ft_of_get_option('fabthemes_banner3_id_' . $langCode))
				{
					RenderBanner(ft_of_get_option('fabthemes_banner3_id_' . $langCode), ft_of_get_option('fabthemes_banner3_text_color'), ft_of_get_option('fabthemes_url3_' . $langCode));
				}
				?>
		</ul>
<div class="doverlay"></div>
</div>

