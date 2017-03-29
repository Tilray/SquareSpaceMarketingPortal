<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="mockH1 products"><?=__('PRODUCTS')?></h2>
			</div>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-lg-12">
		<div class="back-to-results">
			<span class="arrow">&lt;</span><a href="<?=getProductsPageLink()?>"><?=_("Back to results")?></a>
		</div>
		<div class="row">
			<div class="col-sm-5 col-xs-12">
				<div class="product-chip-wrapper profile-border <?=$thisProduct->profile?>">
					<div class="product-chip-upper profile-background chem-type <?=$thisProduct->profile?>">
						<div class="text-centerer">
							<?=$thisProduct->profile?>
						</div>
					</div>
					<div class="product-chip-spacer">
					</div>
					<div class="product-chip-lower">
						<div class="strain-name">
							<?= $thisProduct->name ?>
						</div>
						<div class="strain-category">
							<?= $thisProduct->straincategory ?>
						</div>
					</div>
					<div class="product-chip-spacer">
					</div>
				</div>

				<?php
				if (strlen($thisProduct->terpenes) > 0) {
					?>
					<div class="terpenes">
					<h3><?= _("Terpenes:")?></h3>
					<?= $thisProduct->terpenes ?>
					</div>
					<?php
				}
				?>
				<p class="price-text">
					<?php
					if ($thisProduct->status == 'available'){
						if($itemPrice > 0)
						{
							echo $priceText;
						}

						if ($itemStoreLink){
							?>
							<br><a href='<?=$itemStoreLink?>' class='inline-btn buy-btn track-product-buy-button'><?= __('Buy Now')?></a>
							<?php
						}
					}
					else 
					{
						echo "<h4>";

						if ($thisProduct->status == '30-days')
							echo __("Available within 30 days.");
						else if ($thisProduct->status == '90-days')
							echo __("Available within 90 days.");

						$notification_url = "/" . get_current_language_code() . "/";
						if (strtolower(get_current_language_code()) == "fr")
							$notification_url .= "le-notification-terms";
						else
							$notification_url .= "product-alerts-terms-of-service";
						$notification_url .= "/?product_id=" . $post->ID;
						echo "</h4><p><a href='$notification_url'>" . __("Notify me when this strain is available") . " &raquo;</a></p>";
					}
					?>
				</p>
			</div>
			<div class="col-sm-7 col-xs-12">
				<h1 class="mockH2"><?php the_title(); ?></h1>
				<div class="single-product-desktop-content">
					<p><?=$thcAndCbdText?></p>
					<?php
						the_content();
						if (strlen($thisProduct->cannabinoids) > 0) {
							echo "<div class='cannabinoids'>";
							echo "<h3>" . _("Cannabinoid Content:") . "</h3>";
							echo $thisProduct->cannabinoids;
							echo "</div>";
						}
					?>
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
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
</div><!-- #page -->
<?php get_footer(); ?>
