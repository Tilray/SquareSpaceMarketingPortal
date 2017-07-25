<?php
$title = $is_accessories_page ? "ACCESSORIES" : "PRODUCTS";
$prev_page_link = $is_accessories_page ? getAccessoriesPageLink() : getProductsPageLink();
?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="mockH1 products"><?=__($title)?></h2>
			</div>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-lg-12">
		<div class="back-to-results">
			<span class="arrow">&lt;</span><a href="<?=$prev_page_link?>"><?=__("Back to results")?></a>
		</div>
		<div class="row">
			<div class="col-sm-5 col-xs-12">
				<?php
				if ($is_accessories_page): 
				?>
				<img src="<?=$thisProduct->largeImage?>" alt="<?=$thisProduct->productName?>"/>
				<?php
				else: 
				?>
				<div class="product-chip-wrapper profile-border <?=$thisProduct->profile?>">
					<div class="product-chip-upper profile-background chem-type <?=$thisProduct->profile?>">
						<div class="text-centerer">
							<?=__($thisProduct->profile)?>
						</div>
					</div>
					<div class="product-chip-spacer">
					</div>
					<div class="product-chip-lower">
						<div class="strain-name">
							<?= __($thisProduct->name) ?>
						</div>
						<div class="strain-category">
							<?= __($thisProduct->straincategory) ?>
						</div>
					</div>
					<div class="product-chip-spacer">
					</div>
				</div>

				<?php
					if (strlen($thisProduct->terpenes) > 0) {
						?>
						<div class="terpenes">
						<h3><?= __("Terpenes:")?></h3>
						<?= __($thisProduct->terpenes) ?>
						</div>
						<?php
					}
				endif;
				?>
				<p itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="price-text">
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

						echo "</h4>";
/*						$notification_url = "/" . get_current_language_code() . "/";
						if (strtolower(get_current_language_code()) == "fr")
							$notification_url .= "le-notification-terms";
						else
							$notification_url .= "product-alerts-terms-of-service";
						$notification_url .= "/?product_id=" . $post->ID;
						echo "</h4><p><a href='$notification_url'>" . __("Notify me when this strain is available") . " &raquo;</a></p>";*/
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
							echo "<h3>" . __("Cannabinoid Content:") . "</h3>";
							echo __($thisProduct->cannabinoids);
							echo "</div>";
						}
					?>
				</div>
			</div>
		</div>
	</div><!-- #primary -->
	
	</div>
</div>
</div><!-- #page -->
<?php get_footer(); ?>
