<div class="single-product-mobile">
	<div class="page-head">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="back-to-results">
						<span class="arrow">&lt;</span><a href="<?=getProductsPageLink()?>"><?=_("Back to results")?></a>
					</div>
					<h2 class="mockH1 products"><?=__('PRODUCTS')?></h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area col-lg-12">
				<div class="product-chip-wrapper profile-border <?=$thisProduct->profile?>">
					<div class="product-chip-upper profile-background chem-type <?=$thisProduct->profile?>">
						<div class="text-centerer">
							<?=$thisProduct->profile?>
						</div>
					</div>
					<div class="product-chip-spacer">
					</div>
					<div class="product-chip-lower">
						<div class="text-centerer">
							<div class="strain-name">
								<?= $thisProduct->name ?>
							</div>
						</div>
					</div>
					<div class="product-chip-lower">
						<div class="text-centerer">
							<div class="strain-category">
								<?= $thisProduct->straincategory ?>
							</div>
						</div>
					</div>
					<div class="product-chip-spacer">
					</div>
				</div>
				<?php if (strlen(trim($thc)) > 0){?>
					<h3 class="thc-level"><span class="thc-label"><?= _("THC")?>:&nbsp;</span><?=$thc?>%</h3>
				<?php } ?>
				<?php if (strlen(trim($cbd)) > 0){?>
					<h3 class="thc-level"><span class="thc-label"><?= _("CBD")?>:&nbsp;</span><?=$cbd?>%</h3>
				<?php } ?>
				<h1 class="mockH2"><?php the_title(); ?></h1>
				<p><?=$thcAndCbdText?></p>
				<?php

				the_content();

				$terpene_images = $thisProduct->getTerpeneImages();
				?>
				<div class="terpene-images">
					<?php
					if(strlen(trim($terpene_images))){
						?>
						<h3><?=_("Terpenes:")?></h3>
						<?=$terpene_images?>
						<?php
					}
					?>
				</div>

				<p class="price-text">
					<?php
					if($itemPrice > 0)
					{
						echo $priceText;
					}

					if ($itemStoreLink){
						?>
						<a href='<?=$itemStoreLink?>' class='call-to-action-button'><span><?= __('Buy Now')?></span></a>
						<?php
					}
					?>
				</p>


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
			</div><!-- #primary -->

		</div>
	</div>
	</div>
</div><!-- #page -->
<?php get_footer(); ?>
