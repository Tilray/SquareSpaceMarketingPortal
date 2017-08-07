<?php
$title = $is_accessories_page ? __("ACCESSORIES") : __("PRODUCTS");
$prev_page_link = $is_accessories_page ? getAccessoriesPageLink() : getProductsPageLink();
?>
<div class="single-product-mobile">
	<div class="page-head">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="back-to-results">
						<span class="arrow">&lt;</span><a href="<?=$prev_page_link?>"><?=__("Back to results")?></a>
					</div>
					<h2 class="mockH1 products"><?=$title?></h2>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area col-lg-12">
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
								<?= __($thisProduct->profile) ?>
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
					<?php if ($thisProduct->status == 'available' && strlen(trim($thc)) > 0){?>
						<h3 class="thc-level"><span class="thc-label"><?= __("THC")?>:&nbsp;</span><?=$thc?>%</h3>
					<?php } ?>
					<?php if ($thisProduct->status == 'available' && strlen(trim($cbd)) > 0){?>
						<h3 class="thc-level"><span class="thc-label"><?= __("CBD")?>:&nbsp;</span><?=$cbd?>%</h3>
					<?php } 
				endif;
				?>
				<h1 itemprop="name" class="mockH2"><?php the_title(); ?></h1>
				<p><?=$thcAndCbdText?></p>
				<span itemprop="description">
					<?php the_content(); ?>
				</span>

				<p itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="price-text text-text-text">
					<?php
					if ($thisProduct->status == 'available'){
						if($itemPrice > 0 && !$is_accessories_page)
						{
							echo $priceText;
						}

						if ($itemStoreLink){
							?>
							<a href='<?=$itemStoreLink?>' class='call-to-action-button track-product-buy-button'><span><?= __('Buy Now')?></span></a>
							<?php
						}
					}
					else{
						echo "<h4>";

						if ($thisProduct->status == '30-days')
							echo __("Available within 30 days.");
						else if ($thisProduct->status == '90-days')
							echo __("Available within 90 days.");

						echo "</h4>";
					}
					?>
				</p>
			</div><!-- #primary -->

		</div>
	</div>
	</div>
</div><!-- #page -->
<?php get_footer(); ?>
