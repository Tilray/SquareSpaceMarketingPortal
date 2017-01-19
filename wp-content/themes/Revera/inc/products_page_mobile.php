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


function renderMobileFilterPanel($qsParamName, $displayName, $filterNameValues, $panelName = ""){
	?>
	<div class="filter-panel mobile <?=$qsParamName?> <?=$panelName?>" data-filter="<?=$qsParamName?>" style="display:none;">
		<div class="filter-panel-header">
			<div class="col-xs-2"></div>
			<div class="col-xs-8 filter-panel-title">
				<?php _e('Select ' . $displayName); ?>
			</div>
			<div class="col-xs-2"><i class="icon-cancel close-button" aria-hidden="true"></i></div>
		</div>
		<div class="filter-panel-options">
			<ul class="product-filters mobile product-filters-<?=$qsParamName?>">
			<?php
			foreach($filterNameValues as $fnvId=>$fnvValue){
				if ($fnvId == "") {
					continue;
				}
				$id = $qsParamName . '-' . $fnvValue;
				if ($fnvValue == "") {
					$id = $qsParamName . '-show-all';
				}

				?>
				<li class="product-filter mobile">
					<span class="noscript-hide">
						<input type="checkbox" class="mobile product-filters-<?=$qsParamName?>" name="<?=$qsParamName?>" id="<?=$id?>" data-filter="<?=$fnvId?>">
						<label class="checkbox-label" for="<?=$id?>"><?php _e($fnvId); ?></label>
					</span>
					<noscript>
						<a href="<?= sprintf('%s?%s=%s', the_permalink(), $qsParamName, $fnvValue)?>"><?php _e($fnvId); ?></a>
					</noscript>
				</li>
				<?php
			}
			?>
			</ul>
		</div>
	</div>
	<?php
}

renderMobileFilterPanel($productFilters->profilethc->qsParamName, $productFilters->profilethc->displayName, $productFilters->profilethc->getFiterNamesValues());
renderMobileFilterPanel($productFilters->profilecbd->qsParamName, $productFilters->profilecbd->displayName, $productFilters->profilecbd->getFiterNamesValues());
renderMobileFilterPanel($productFilters->profilethccbd->qsParamName, $productFilters->profilethccbd->displayName, $productFilters->profilethccbd->getFiterNamesValues());
renderMobileFilterPanel($productFilters->strainCategory->qsParamName, $productFilters->strainCategory->displayName, $productFilters->strainCategory->getFiterNamesValues());
renderMobileFilterPanel($productFilters->productType->qsParamName, $productFilters->productType->displayName, $productFilters->productType->getFiterNamesValues());
renderMobileFilterPanel($productFilters->status->qsParamName, $productFilters->status->displayName, $productFilters->status->getFiterNamesValues());

?>

<h1 class="products-page-title"><?php the_title(); ?></h1>

<div class="page-head mobile-products-page retractable retracted summary">
	<div class="container no-padding">
		<div class="row">
			<div class="col-xs-12">
				<div class="mobile products back-to-top">
					<div class="arrow"></div>
					<a id="back-to-top"><?= _("Back to Top")?></a>
				</div>
			</div>
			<div class="col-xs-12 summary-contents">
				<span class="summary-item thc" style="display:none">THC Profiles</span>
				<span class="summary-item cbd" style="display:none">CBD Profiles</span>
				<span class="summary-item thc-cbd" style="display:none">THC/CBD Profiles</span>
				<span class="summary-item flower" style="display:none">Flower</span>
				<span class="summary-item blend" style="display:none">Blend</span>
				<span class="summary-item extract" style="display:none">Extract</span>
				<span class="summary-item indica" style="display:none">Indica</span>
				<span class="summary-item sativa" style="display:none">Sativa</span>
				<span class="summary-item hybrid" style="display:none">Hybrid</span>
			</div>
		</div>
	</div>
</div>

<div class="page-head mobile-products-page">
	<div class="container no-padding">
		<div class="row">
			<div class="col-xs-8">
				<h2 class="filters"><?= _("Filters")?></h2>
			</div>
			<div class="col-xs-4 reset-section">
				<div class="filter-button mobile reset">
					<div class="filter-button-inner" data-filter-name="reset"><?php _e('Reset Filters'); ?></div>
				</div>
			</div>
			<div class="filters mobile">	
				<div class="col-xs-12">
					<div class="mobile-filters-row">
						<div class="filter-button-wrapper">
							<div class="filter-button mobile profile profilethc">
								<div class="filter-button-inner profilethc" data-filter-name="profilethc">
									<div class="filter-label"><span>THC</span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button mobile profile profilecbd">
								<div class="filter-button-inner profilecbd" data-filter-name="profilecbd">
									<div class="filter-label"><span>CBD</span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button mobile profile profilethccbd">
								<div class="filter-button-inner profilethccbd" data-filter-name="profilethccbd">
									<div class="filter-label"><span>THC/CBD</span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile-filters-row">
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$productFilters->strainCategory->qsParamName?>">
								<div class="filter-button-inner <?=$productFilters->strainCategory->qsParamName?>" data-filter-name="<?=$productFilters->strainCategory->qsParamName?>">
									<div class="filter-label"><span><?= _e($productFilters->strainCategory->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$productFilters->productType->qsParamName?>">
								<div class="filter-button-inner <?=$productFilters->productType->qsParamName?>" data-filter-name="<?=$productFilters->productType->qsParamName?>">
									<div class="filter-label"><span><?= _e($productFilters->productType->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$productFilters->status->qsParamName?>">
								<div class="filter-button-inner <?=$productFilters->status->qsParamName?>" data-filter-name="<?=$productFilters->status->qsParamName?>">
									<div class="filter-label"><span><?= _e($productFilters->status->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
function renderProductsSection($allProducts, $productType, $sectionTitle){
	$sectionTitleActiveClass = "";
	foreach($allProducts as $product) {
		if ($product->producttype == $productType && $product->initiallyActive) {
			$sectionTitleActiveClass = " active";
		}
	}
	?>
	<div class="section-title product-item section-title-<?=$productType?><?=$sectionTitleActiveClass?>">
		<h3><?=$sectionTitle?></h3>
		<hr/>
	</div>
	<?php
	foreach($allProducts as $product) {
		if ($product->producttype == $productType) {
			$activeClass = $product->initiallyActive ? "active" : "";
			?>
			<div class="portbox post product-item mobile filterable-item <?= $activeClass ?>"
				 data-id="<?= $product->id ?>"
				 data-straincategory="<?= $product->straincategory ?>"
				 data-status="<?= $product->status ?>"
				 data-producttype="<?= $product->producttype ?>"
				 data-thc="<?= $product->thc ?>"
				 data-price="<?= $product->price ?>"
				 data-profilethc="<?= $product->profilethc ?>"
				 data-profilecbd="<?= $product->profilecbd ?>"
				 data-profilethccbd="<?= $product->profilethccbd ?>"
			>
				<div class="product-item-inner init <?= $product->profile ?>">
					<div class="chem-type <?= $product->profile ?>">
						<?= $product->profile ?>
					</div>
					<div class="strain-name">
						<?= $product->name ?>
					</div>
					<div class="strain-category">
						<?= $product->straincategory ?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 product-details-row product-item portbox"
				 data-id="<?=$product->id?>" data-straincategory="" data-status=""
				 data-producttype="" data-thc="" data-price="">
				<div class="details-panel-arrow"></div>
				<div class="details-panel">
					<div class="header-column">
						<h3 class="name"></h3>
						<h4 class="subtitle"></h4>
					</div>
					<div class="overview-column">
						<div class="overview"></div>
						<div class="product-link"><?=_("More information about this strain is available")?> <a href=""><?=_("here")?></a></div>
					</div>
					<div class="buy-column">
						<h4 class="terpenes">Terpenes:</h4>
						<div class="terpene-images"></div>
						<div class="price">
							<span class="price"></span>
							<a class="buy">Buy Now</a>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

?>


<div class="items mobile-products-page">
	<div class="row noscript-hide">
		<div class="col-12">
			<div id="primary">
				<?php
				renderProductsSection($theProducts, "flower", "Whole Flower");
				renderProductsSection($theProducts, "blend", "Flower Blends");
				renderProductsSection($theProducts, "extract", "Oil Drops");
				?>
			</div>
		</div>
	</div>
</div>

<script>
	var changePanelsPosition = 100;

	function setFilterStates(filterSelector, statuses, turnWholeGroupOn = false)
	{
		if (turnWholeGroupOn){
			//turn everything on
			jQuery(filterSelector).prop('checked', true);
			//but turn "show all" off
			jQuery(filterSelector + '[data-filter=""]').prop('checked', false);
		}
		else
		{
			statuses.forEach(function(item)
			{
				jQuery(filterSelector + '[data-filter="' + item + '"]').prop('checked', true);
			});
		}

	}


	jQuery(function() {

		jQuery(".page-head.summary").click(function(){
			jQuery("html, body").animate({ scrollTop: 0 }, "fast");
		});

		var $container = jQuery('#primary')
		$container.isotope({
			resizable: false,
			masonry: { columnWidth: $container.width() / 2 },
			itemSelector: ".product-item",
			filter: ".active"
		});
		console.log("Done setting up isotope");

		var $filterPanel = jQuery(".page-head.mobile-products-page");
		var $filterSummaryPanel = jQuery(".page-head.mobile-products-page.summary");


		jQuery(document).scroll(function(){
			if (jQuery("body").scrollTop() > changePanelsPosition){
				$filterPanel.addClass("retracted");
				$filterSummaryPanel.removeClass("retracted");
			}
			else{
				$filterPanel.removeClass("retracted");
				$filterSummaryPanel.addClass("retracted");
			}
		});
	});
</script>
