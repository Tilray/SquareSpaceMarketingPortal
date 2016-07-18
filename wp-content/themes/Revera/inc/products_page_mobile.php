<?php
global $noHideStickyFooterContent;
$noHideStickyFooterContent = "<div class='mobile-products-flyout'></div>";
?>

<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";
</script>

<?php
//this block will get positioned in stickyfootercontent via js
global $productFilters;



//render filter panels
foreach($productFilters->filters as $filter)
{
	?>
	<div class="filter-panel mobile <?=$filter->qsParamName?>" data-filter="<?=$filter->qsParamName?>" style="display:none;">
		<div class="filter-panel-header">
			<div class="col-xs-2"></div>
			<div class="col-xs-8 filter-panel-title">
				<?=_('Select ' . $filter->displayName)?>
			</div>
			<div class="col-xs-2"><i class="fa fa-close close-button" aria-hidden="true"></i></div>
		</div>
		<div class="filter-panel-options">
			<?php
				$filter->renderMobileFilters();
			?>
		</div>
	</div> 
	<?php
}

global $productFilters;
?>


<div class="page-head mobile-products-page">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="mockH1"><?php the_title(); ?></h2>
			</div>
			<div class="filters mobile">	
				<div class="col-12">
					<div class="mobile-filters-row">
						<div class="filter-button-wrapper">
							<div class="filter-button mobile <?=$productFilters->status->qsParamName?>">
								<div class="mobile-filter-button <?=$productFilters->status->qsParamName?>" data-filter-name="<?=$productFilters->status->qsParamName?>"><?= _e($productFilters->status->displayName) ?><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></div>
							</div>
						</div>	
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button mobile <?=$productFilters->strainCategory->qsParamName?>">
								<div class="mobile-filter-button <?=$productFilters->strainCategory->qsParamName?>" data-filter-name="<?=$productFilters->strainCategory->qsParamName?>"><?= _e($productFilters->strainCategory->displayName) ?><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button mobile <?=$productFilters->productType->qsParamName?>">
								<div class="mobile-filter-button <?=$productFilters->productType->qsParamName?>" data-filter-name="<?=$productFilters->productType->qsParamName?>"><?= _e($productFilters->productType->displayName) ?><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
					<div class="mobile-filters-row">
						<div class="filter-button-wrapper">
							<div class="filter-button mobile <?=$productFilters->thc->qsParamName?>">
								<div class="mobile-filter-button <?=$productFilters->thc->qsParamName?>" data-filter-name="<?=$productFilters->thc->qsParamName?>"><?= _e($productFilters->thc->displayName) ?><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button mobile <?=$productFilters->price->qsParamName?>">
								<div class="mobile-filter-button <?=$productFilters->price->qsParamName?>" data-filter-name="<?=$productFilters->price->qsParamName?>"><?= _e($productFilters->price->displayName) ?><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></div>
							</div>
						</div>	
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button mobile reset">
								<div class="mobile-filter-button" data-filter-name="reset">Reset</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="items mobile-products-page">
	<div class="noscript-hide">
		<?php
		
		foreach($theProducts as $product){
            
            $activeClass = $product->initiallyActive ? "active" : "";
			?>
			<div class="post mobile-product-item filterable-item <?= $activeClass?>" 
				data-id="<?=$product->id?>" 
				data-straincategory="<?=$product->straincategory?>" 
				data-status="<?=$product->status?>" 
				data-producttype="<?=$product->producttype?>" 
				data-thc="<?=$product->thc?>" 
				data-price="<?=$product->price?>">
				<div class="hthumb">
					<?php 
					$imageUrl = $product->image;
					$hcpParam = "";
					if ($displayMode == 'hcp'){
						$imageUrl = $product->hcpImage;
						$hcpParam = "?hcp=1";
					}
					?>
					<a href="<?=$product->productUrl?><?=$hcpParam?>">
						<div class="mobile-products-page-image-container">
							<div class="mobile-products-color-stripe <?= str_replace("|", "_", $product->straincategory)?>"></div>
							<div class="mobile-product-image" style="background-image:url(<?=$imageUrl?>);" alt="<?=$product->productName?>"></div>
						</div>
					</a>
				</div>
				<div class="mobile-product-description">
					<div class="description-inner">
						<a href="<?=$product->productUrl?><?=$hcpParam?>"><h3><?=$product->productName ?></h3></a>
						<a href="<?=$product->productUrl?><?=$hcpParam?>"><h4><?=$product->primaryStrainCategoryName ?></h4></a>
					</div>
				</div>
			 </div>
		<?php } ?>
	</div>
</div>
