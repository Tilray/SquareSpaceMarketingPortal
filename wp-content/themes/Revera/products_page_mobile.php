<?php
global $noHideStickyFooterContent;
$noHideStickyFooterContent = "<div class='mobile-products-flyout'></div>";
?>

<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";
</script>

<?php


function renderMobileFilterPanel($qsParamName, $displayName, $filterNameValues, $filterNameValuesDict = null){
	?>
	<div class="filter-panel mobile <?=$qsParamName?>" data-filter="<?=$qsParamName?>" style="display:none;">
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
				addMobileFilterItems($filterNameValues, $qsParamName, false);

				if (isset($filterNameValuesDict)){
					foreach($filterNameValuesDict as $paramName => $nameValues){
						addMobileFilterItems($nameValues, $paramName, true);
					} 
				}
			?>
			</ul>
		</div>
	</div>
	<?php
}

function addMobileFilterItems($filterNameValues, $qsParamName, $removeBlanks){
	foreach($filterNameValues as $fnvId=>$fnvValue){
		$id = $qsParamName . '-' . $fnvValue;
		if ($fnvValue == "") {
			if ($removeBlanks)
				continue;

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
			<input type="checkbox" class="mobile product-filters-<?=$qsParamName?> <?=$checkboxClass?>" name="<?=$filterName?>" id="<?=$id?>" data-filter-name="<?=$qsParamName?>" data-filter="<?=$fnvId?>">
			<label class="checkbox-label" for="<?=$id?>"><?php _e($label); ?></label>
		</li>
		<?php
	}
}

if ($is_accessories_page){
	renderMobileFilterPanel($filterSet->status->qsParamName, $filterSet->status->displayName, $filterSet->status->getFiterNamesValues());
	renderMobileFilterPanel($filterSet->accessoryType->qsParamName, $filterSet->accessoryType->displayName, $filterSet->accessoryType->getFiterNamesValues());
}
else{
	renderMobileFilterPanel("profile", __("Profiles"), array("" => ""), 
			array(
				$filterSet->profilethc->qsParamName => $filterSet->profilethc->getFiterNamesValues(),
				$filterSet->profilecbd->qsParamName => $filterSet->profilecbd->getFiterNamesValues(),
				$filterSet->profilethccbd->qsParamName => $filterSet->profilethccbd->getFiterNamesValues()	
			)
		);
	renderMobileFilterPanel($filterSet->strainCategory->qsParamName, $filterSet->strainCategory->displayName, $filterSet->strainCategory->getFiterNamesValues());
	renderMobileFilterPanel($filterSet->productType->qsParamName, $filterSet->productType->displayName, $filterSet->productType->getFiterNamesValues());
	renderMobileFilterPanel($filterSet->status->qsParamName, $filterSet->status->displayName, $filterSet->status->getFiterNamesValues());
	renderMobileFilterPanel($filterSet->price->qsParamName, $filterSet->price->displayName, $filterSet->price->getFiterNamesValues());
}

function createSummaryItem($id, $label){
	echo "<span class='summary-item $id' style='display:none'>$label</span>";
}

function createSummaryItemGroup($filter){
	foreach($filter->validFilterValues as $key=>$value){
		if (strlen($key) > 0){
			echo "<span class='summary-item " . $filter->qsParamName . $key . "' style='display:none'>" . __($value) . "</span>";
		}
	}
}
?>

<h1 class="products-page-title"><?php the_title(); ?></h1>

<div class="page-head mobile mobile-products-page retractable retracted summary overlay-shadow">
	<div class="container no-padding">
		<div class="row">
			<div class="col-xs-12">
				<div class="mobile products back-to-top">
					<div class="arrow"></div>
					<a id="back-to-top"><?= __("Back to Top")?></a>
				</div>
			</div>
			<div class="col-xs-12 summary-contents">
				<?php
				if ($is_accessories_page){
					createSummaryItemGroup($filterSet->status);
					createSummaryItemGroup($filterSet->accessoryType);
				}
				else{
					createSummaryItem($filterSet->profilethc->qsParamName, __("THC Profiles"));
					createSummaryItem($filterSet->profilecbd->qsParamName, __("CBD Profiles"));
					createSummaryItem($filterSet->profilethccbd->qsParamName, __("THC/CBD Profiles"));

					createSummaryItemGroup($filterSet->strainCategory);
					createSummaryItemGroup($filterSet->productType);
					createSummaryItemGroup($filterSet->status);
					createSummaryItemGroup($filterSet->price);					
				}
				?>
			</div>
		</div>
	</div>
</div>

<div class="page-head mobile mobile-products-page">
	<div class="container no-padding">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="filters"><?= __("Filters")?></h2>
                <h3 class="products-mobile-alternate-link"><a href="<?=get_permalink($alternate_page_id)?>">View <?=get_the_title($alternate_page_id)?> &raquo;</a></h3>
			</div>
			<div class="filters mobile">	
				<div class="col-xs-12">
				<?php
				if ($is_accessories_page){
					include "inc/accessories_page_mobile_selectors.php";
				}
				else{
					include "inc/product_page_mobile_selectors.php";
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
function renderProductsSection($allProducts, $productType, $sectionTitle){
	global $is_accessories_page;

	$sectionTitleActiveClass = "";
	foreach($allProducts as $product) {
		if ($product->producttype == $productType && $product->initiallyActive) {
			$sectionTitleActiveClass = " active";
		}
	}
	?>
	<div class="section-title product-item section-title-<?=$productType?><?=$sectionTitleActiveClass?>">
		<h3><?=__($sectionTitle)?></h3>
		<hr/>
	</div>
	<?php
	foreach($allProducts as $product) {
		if ($product->producttype == $productType) {
			$activeClass = $product->initiallyActive ? "active" : "";
			$accessories_class = $is_accessories_page ? "accessory" : "";
			$profile = $is_accessories_page ? "accessory" : $product->profile;
			?>
			<div class="portbox post product-item mobile filterable-item <?= $activeClass ?> <?=$accessories_class?>"
				 data-id="<?= $product->id ?>"
				 data-straincategory="<?= $product->straincategory ?>"
				 data-status="<?= $product->status ?>"
				 data-producttype="<?= $product->producttype ?>"
				 data-thc="<?= $product->thc ?>"
				 data-price="<?= $product->price ?>"
			>
				<a href="<?=$product->productUrl?>">
					<div class="product-item-inner init <?= $profile ?>">
						<?php if ($is_accessories_page):?>
							<img src="<?=$product->image?>" alt="<?= __($product->name) ?>">
							<div class="strain-name">
								<?= __($product->name) ?>
							</div>
						<?php else: ?>
							<div class="chem-type <?= $profile ?>">
								<div class="text-align">
									<span class="text-align-inner"><?= __($product->profile) ?></span>
								</div>
							</div>
							<div class="strain-name">
								<?= __($product->name) ?>
							</div>
							<div class="strain-category">
								<?= __($product->straincategory) ?>
							</div>
						<?php endif; ?>
					</div>
				</a>
			</div>
			<?php
		}
	}
}

?>


<div class="items mobile mobile-products-page">
	<div class="row noscript-hide">
		<div class="col-12">
			<div id="primary">
				<?php
				if ($is_accessories_page){
					renderProductsSection($theProducts, "accessory", "Accessories");
				}
				else{
					renderProductsSection($theProducts, "flower", "Whole Flower");
					renderProductsSection($theProducts, "blend", "Ground Cannabis");
					renderProductsSection($theProducts, "drop", "Drops");
					renderProductsSection($theProducts, "capsule", "Capsules");
				}
				?>
			</div>
		</div>
	</div>
</div>

<script>
	var changePanelsPosition = 100;

	function closeAllProductFilterPanels()
	{
		jQuery('.filter-panel.mobile').removeClass('active');
	}


	jQuery(function() {

		jQuery(".page-head.summary").click(function(){
			jQuery("html, body").animate({ scrollTop: 0 }, "fast");
		});

		var $container = jQuery('#primary');
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
	});
</script>
