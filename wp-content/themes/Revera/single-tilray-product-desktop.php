<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="mockH1"><?=__('PRODUCTS')?></h2>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-12">
		<div class="col-sm-6">
			<?php
			$thumbid = get_post_thumbnail_id();
			$img_attrs = wp_get_attachment_image_src( $thumbid,'product-single' );
			$image = $img_attrs[0];
			?>
			<img class="single-product-image" src="<?=$image?>" alt="<?php the_title(); ?>"/>
		</div>
		<div class="col-sm-4">
			<h1 class="mockH2"><?php the_title(); ?></h1>
			<p><?=$thcAndCbdText?></p>
			<?php 

				the_content();
			?>
			<p class="price-text">
			<?php
				if($itemPrice > 0)
				{
					echo $priceText;
				}

				if ($itemStoreLink){
				?>
					<a href='<?=$itemStoreLink?>' class='inline-btn buy-btn'><?= __('Buy Now')?></a>
				<?php
				}
			?>
			</p>
			
			<div class="single-product-attributes">
			<?php
				$useHCP = array_key_exists('hcp', $_GET);
                $productFilters->status->renderProductsPageLink($thisProduct->status, $useHCP);
                $productFilters->strainCategory->renderProductsPageLink($thisProduct->primaryStrainCategory, $useHCP);
                $productFilters->productType->renderProductsPageLink($thisProduct->producttypes, $useHCP);
                $productFilters->thc->renderProductsPageLink($thisProduct->thc, $useHCP);                
			?>
			</div>
			<div class="buttons-container">
				<?php
				$disableSocial = trim(ft_of_get_option('fabthemes_disable_social_sharing'));
				if ($disableSocial != "0"){
				?>
					<div class="social-buttons">
						<?php render_social_buttons(get_permalink(), wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0], get_the_title()); ?>
					</div>
				<?php } ?>
			</div>
			
			<?php 
				$disableDisqus = trim(ft_of_get_option('fabthemes_disable_disqus'));
				if (comments_open() && $disableDisqus != "0") : 
			?>
			<div id="disqus_thread"></div>
			<script>
				/**
				 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
				 */
				var disqus_config = function () {
					this.page.url = "<?= get_permalink()?>";  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = "<?=str_replace(" ", "_", get_the_title())?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
				};
				(function() {  // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					
					s.src = '//tilray.disqus.com/embed.js';
					
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
				})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			<?php endif; // comments_open ?>						
			
		</div>
		<div class="col-sm-2">
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
<?php get_footer(); ?>
</div><!-- #page -->
