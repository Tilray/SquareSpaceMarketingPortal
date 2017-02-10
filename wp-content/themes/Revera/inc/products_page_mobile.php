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
				$id = $qsParamName . '-' . $fnvValue;
				if ($fnvValue == "") {
					$id = $qsParamName . '-show-all';
				}

				$label = $fnvValue;
				if ($label == "")
					$label = "Show All";

				$profile_filter_class = "";
				$filterName = $qsParamName;
				$checkboxClass = "";

				if (strpos($qsParamName, "profile") === 0) {
					$profile_filter_class = "product-filter-profile";
					$filterName = "profile";

					if ($fnvValue !== "")
						$checkboxClass = "profile-filter-has-value";
				}

				?>
				<li class="product-filter mobile <?=$profile_filter_class?>">
					<span class="noscript-hide">
						<input type="checkbox" class="mobile product-filters-<?=$qsParamName?> <?=$checkboxClass?>" name="<?=$filterName?>" id="<?=$id?>" data-filter-name="<?=$qsParamName?>" data-filter="<?=$fnvId?>">
						<label class="checkbox-label" for="<?=$id?>"><?php _e($label); ?></label>
					</span>
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


function createSummaryItem($id, $label){
	echo "<span class='summary-item $id' style='display:none'>$label</span>";
}

function createSummaryItemGroup($filter){
	foreach($filter->validFilterValues as $key=>$value){
		if (strlen($key) > 0){
			echo "<span class='summary-item " . $filter->qsParamName . $key . "' style='display:none'>" . $value . "</span>";
		}
	}
}
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
				<?php
					createSummaryItem($productFilters->profilethc->qsParamName, _("THC Profiles"));
					createSummaryItem($productFilters->profilecbd->qsParamName, _("CBD Profiles"));
					createSummaryItem($productFilters->profilethccbd->qsParamName, _("THC/CBD Profiles"));

					createSummaryItemGroup($productFilters->strainCategory);
					createSummaryItemGroup($productFilters->productType);
					createSummaryItemGroup($productFilters->status);
				?>
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
				<a href="<?=$product->productUrl?>">
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
				</a>
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
				renderProductsSection($theProducts, "extract", "Extracts");
				?>
			</div>
		</div>
	</div>
</div>

<script>
	var changePanelsPosition = 100;


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

		//configure filter summary panel scrolling behavior
		if (jQuery('.filter-panel.mobile').length > 0){
			jQuery('.filter-panel.mobile').css('display', 'block');

			jQuery('.filter-panel.mobile').appendTo(jQuery('.mobile-products-flyout'));

			jQuery('.filter-panel-header').click(closeAllProductFilterPanels);

			if (jQuery('.filter-button-inner').length){
				jQuery('.filter-button-inner').click(function(){
					var filterName = jQuery(this).attr('data-filter-name');
					if (jQuery('.filter-panel.mobile.' + filterName).hasClass('active')){
						jQuery('.filter-panel.mobile').removeClass('active');
					}
					else{
						jQuery('.filter-panel.mobile').removeClass('active');
						jQuery('.filter-panel.mobile.' + filterName).addClass('active');
					}
				});
			}
		}

		function closeAllProductFilterPanels()
		{
			jQuery('.filter-panel.mobile').removeClass('active');
		}

	});
</script>
