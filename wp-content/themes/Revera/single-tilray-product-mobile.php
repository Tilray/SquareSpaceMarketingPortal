
<div class="page-head product-single-mobile">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
					$useHCP = array_key_exists('hcp', $_GET);
					$productsPageLink = getProductsPageLink($useHCP); 
				?>
				<a href="<?=$productsPageLink?>">Return to products</a>
			</div>
			
		</div>
	</div>
</div>

<div class="container product-single-mobile">
	<div class="row">	
		<?php
			if ($thisProduct->producttype != "accessory"){
			?>
				<div class="col-xs-4 main-image" style="background-image:url(<?=$thisProduct->mobileImage?>)">
					<div class="color-stripe <?=$thisProduct->primaryStrainCategory?>">
					</div>
				</div>
				<div class="col-xs-8">
			<?php				
			}
			else
			{
			?>
				<div class="col-xs-12 main-image-accessory">
					<img src="<?=$thisProduct->mobileAccessoryImage?>" alt="<?=get_the_title()?>" />
				</div>
				<div class="col-xs-12">
			<?php
			}
			?>
			<h1 class="mockH2"><?php the_title(); ?></h1>
			<h2><?= $thisProduct->primaryStrainCategoryName ?></h2>
			<p><?=$thcAndCbdText?></p>
			<?php 
				the_content();

				if (strtolower($thisProduct->status) == "available" && $itemPrice > 0)
				{
					?>
						<p class="price-text"><?=$priceText?></p>
					<?php

					if ($itemStoreLink){
						?>
							<a href='<?=$itemStoreLink?>' class='call-to-action-button'><span><?= __('Buy Now')?></span></a>
						<?php
					}
				}
			?>
			<div class="single-product-mobile-attributes">
			<?php
				$useHCP = array_key_exists('hcp', $_GET);
                $productFilters->status->renderProductsPageLink($thisProduct->status, $useHCP);
                $productFilters->strainCategory->renderProductsPageLink($thisProduct->primaryStrainCategory, $useHCP);
                $productFilters->productType->renderProductsPageLink($thisProduct->producttypes, $useHCP);
                $productFilters->thc->renderProductsPageLink($thisProduct->thc, $useHCP);                
			?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
</div><!-- #page -->
