<?php
/**
 * The template for displaying all pages.
 *
  Template name:Products
  
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package web2feel
 */
header("Vary: User-Agent, Accept"); 

get_header(); 



$productFilters->loadFiltersFromQueryString($_GET);	



function QueryProducts($productFilters)
{
	$theProducts = array();
	
	$wp_query = new WP_Query(array('post_type' => 'tilray_product', 'posts_per_page' => '100' ));
	while ($wp_query->have_posts()) : $wp_query->the_post(); 
		$thisProduct = new Product($wp_query->post, $productFilters);
		$theProducts[] = $thisProduct;

	endwhile;
	
	wp_reset_query();

	function cmp($a, $b){
        global $productFilters;
        $aType = $a->producttype;
        $bType = $b->producttype;

        $aSortOrder = $productFilters->sortOrder[$aType];
        $bSortOrder = $productFilters->sortOrder[$bType];

		if ($aSortOrder === $bSortOrder){
			$profileSortResult = sortByProfile($a->combinedProfile, $b->combinedProfile);
			if ($profileSortResult === 0)
				return strcasecmp($a->productName, $b->productName);

			return $profileSortResult;
		}

        return ($aSortOrder > $bSortOrder) ? 1 : -1;
	}
	usort($theProducts, "cmp");		
	
	return $theProducts;
}

function sortByProfile($profileA, $profileB){
	$profileValueA = getProfileValue($profileA);
	$profileValueB = getProfileValue($profileB);

	if ($profileValueA === $profileValueB)
		return 0;

	return ($profileValueA > $profileValueB) ? 1 : -1;
}

function getProfileValue($profile){
	//assign a numeric value to a given profile.
	//T's count for 10, C's for 20, TC's for 30
	//100's count for 1, 200's for 2, 300's for 3

	$profileValue = 0;
	$profile = strtolower($profile);
	if (0 === strpos($profile, "tc")){
		$profileValue += 30;
	}
	else if (0 === strpos($profile, "c")){
		$profileValue += 20;
	}
	else if (0 === strpos($profile, "t")){
		$profileValue += 10;
	}

	if (FALSE !== strpos($profile, "300")){
		$profileValue += 3;
	}
	if (FALSE !== strpos($profile, "200")){
		$profileValue += 2;
	}
	else {
		$profileValue += 1;
	}

	return $profileValue;
}

$theProducts = QueryProducts($productFilters);	

?>
<script src="<?=get_template_directory_uri()?>/js/isotope-min.js"></script>
<script>
	var productDetailsById;

	function removePx(dimension){
		return dimension.replace("px", "");
	}

	var columnWidth = 239;
	var currentDetailsId = -1;

	function getNumberOfColumns(){
		return Math.floor(+removePx(jQuery("#primary").css("width")) / columnWidth);
	}

	function getColumnIndex(leftEdge){
		return Math.round(removePx(leftEdge)/columnWidth);
	}

	function htmlDecode(value) {
		return jQuery("<div/>").html(value).text();
	}

	//disable positioning animations
	Isotope.prototype._positionItem = function( item, x, y ) {
		item.goTo( x, y );
	};

	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";

	function ResetFilters(){
		var isMobile = (jQuery('.filter-panel.mobile').length > 0);
		jQuery('ul input[type=checkbox]').attr('checked', false);
		jQuery('ul input[type=checkbox][id*="-show-all"]').attr('checked', true);

		if (isMobile) {
			jQuery('ul li.profile-filter input[type=checkbox]').attr('checked', true);
			jQuery('ul li.profile-filter').addClass('active')
		}

		setProductsActive();
		setMobilePanelButtonColors();
		jQuery('#primary').isotope({ filter: '.active' });
		updateURI();
	}

	function UpdateProducts($clicked)
	{
		//if it's a show-all, reset checkboxes for all others of same category-
		//if it's not a show-all, reset show-all for this category-

   		jQuery("body").animate({ scrollTop: 0 }, 400);

		var thisFilterCategory = jQuery($clicked).attr('name');
		var thisFilterCategorySelector = 'ul input[type=checkbox][name=' + thisFilterCategory + ']';

		var isMobile = (jQuery('.filter-panel.mobile').length > 0);
		var isProfileFilter = thisFilterCategory.indexOf("profile") === 0;
		console.log("Is profile? " + isProfileFilter);
		var allProfilesCurrentlyChecked = false;
		var allProfilesWereCheckedUntilJustNow = false;
		if (isProfileFilter){
			//for profile filters, if everything's checked, and we click one, we need to turn them all off, except for
			//the one that got clicked.  Since it just got clicked, it won't be checked anymore, so we need to check all
			//the others and confirm that this is now unchecked
			allProfilesWereCheckedUntilJustNow = !jQuery($clicked).prop('checked') &&
				jQuery("ul input[type=checkbox].profile-filter-has-value").length - 1 === jQuery("ul input[type=checkbox].profile-filter-has-value:checked").length;

			allProfilesCurrentlyChecked = ("ul input[type=checkbox].profile-filter-has-value").length === jQuery("ul input[type=checkbox].profile-filter-has-value:checked").length;
		}

		if (jQuery($clicked).attr('data-filter') == '')
		{
			if (isProfileFilter){
				//for profile filters, just turn everything on that's not a show-all
				jQuery(thisFilterCategorySelector).each(function(index){
					jQuery(this).prop('checked', (jQuery(this).attr('data-filter') == '' ? false : true));
				});
			}
			else {
				//profile show-all (on desktop only) works differently than all the others, in that it turns all filters _on_ rather than off
				var showAllChecked = jQuery($clicked).prop('checked');
				jQuery(thisFilterCategorySelector).each(function (index) {
					jQuery(this).prop('checked', (jQuery(this).attr('data-filter') == '' ? showAllChecked : !showAllChecked));
				});
			}
		}
		else
		{
			if (allProfilesWereCheckedUntilJustNow){
				jQuery(thisFilterCategorySelector).each(function(index){
					jQuery(this).prop('checked', false);
				});

				jQuery($clicked).prop('checked', true);
			}
			else {
				//uncheck "Show All"
				jQuery(thisFilterCategorySelector + '[data-filter=""]').prop('checked', false);

				//if nothing's checked, re-check "show all" on desktop, everything else on mobile
				if (jQuery(thisFilterCategorySelector + ':checked').length == 0) {
					if (isProfileFilter) {
						jQuery(thisFilterCategorySelector).each(function (index) {
							if (!isProfileFilter || jQuery(this).attr('data-filter') !== '')
								jQuery(this).prop('checked', true);
						});
					}
					else {
						jQuery(thisFilterCategorySelector + '[data-filter=""]').prop('checked', true);
					}
				}
			}
		}

		setProductsActive();
		setMobilePanelButtonColors();
		
		jQuery('#primary').isotope({ filter: '.active' });

		updateURI();
	}

	function updateURI(){
		if (typeof window.history.replaceState !== 'function')
			return;

		window.history.replaceState(
			{},
			pageTitle,
			pageBaseURL + <?= $productFilters->getQueryStringRenderingJS() ?>
		);
	}

	function setMobilePanelButtonColors(){
		jQuery(".filter-panel.mobile").each(function(index){
			var filterName = jQuery(this).attr("data-filter");
			var allAreChecked = true;
			var noneAreChecked = true;
			jQuery("input.mobile.product-filters-" + filterName).each(function(){
				allAreChecked = allAreChecked && jQuery(this).is(":checked");
				noneAreChecked = noneAreChecked && !jQuery(this).is(":checked");
			});

			console.log(filterName + " -> " + allAreChecked);
			var $filterButton = jQuery(".filter-button.mobile." + filterName);
			$filterButton.removeClass("has-selections");
			if (($filterButton.hasClass("profile") && !noneAreChecked) ||
				(!$filterButton.hasClass("profile") && !allAreChecked)) {
				jQuery(".filter-button.mobile." + filterName).addClass("has-selections");
			}
		});

		jQuery(".summary-item").hide();

		jQuery(".product-filters.mobile input[type=checkbox]:checked").each(function(index){
			var selection = jQuery(this).attr("data-filter");
			if (selection.length > 0)
				jQuery(".summary-item." + selection).show();
		});

	}
	
	//filterState: zero or more strings, joined and end-capped with |||
	//itemFilter: one or more strings, joined by |
	function testFilter(filterState, itemFilter, matchEmpty){
		if (matchEmpty === undefined)
			matchEmpty = true;

		//if filter is set to "show all", return true, since everything matches
		if (matchEmpty && (filterState == '||||||' || itemFilter == ""))
			return true;

		if (itemFilter.indexOf('|') >= 0)
		{
			var itemParts = itemFilter.split('|');
			for (var thisPart in itemParts)
			{
				if (filterState.indexOf('|||' + itemParts[thisPart] + '|||') >= 0)
					return true;
			}
		}
		else if (itemFilter.length > 0 && filterState.indexOf('|||' + itemFilter + '|||') >= 0)
		{
			return true;
		}

		return false;
	}


	function setProductsActive()
	{
		<?= $productFilters->renderProductsFilteringStatuses() ?>
		var selector = 'div.filterable-item';

		jQuery("div.product-details-row").removeClass('active');
		jQuery("div.section-title").removeClass('active');
		jQuery(selector).removeClass('active');
		jQuery(selector).each(function( index ) {
			if (
				<?= $productFilters->renderProductsFilteringConditions() ?>
				)
			{
				jQuery(this).addClass('active');
			}
		});

		showSectionTitles("flower");
		showSectionTitles("blend");
		showSectionTitles("extract");
	}

	function showSectionTitles(sectionName){
		var numActiveItems = jQuery("div.product-item.active[data-producttype='" + sectionName + "']").length;
		if (numActiveItems > 0){
			jQuery("div.section-title-" + sectionName).addClass("active");
		}
	}
	
	function GetFiltersArray(query)
	{
		var filters = [];
		jQuery(query).each(function(){
			var thisVal = jQuery(this).attr('data-filter');
			if (thisVal.length > 0)
				filters.push(thisVal);
		});
		
		return filters;
	}
	

	<?php 
		$productFilters->createPreselectedStatusJSArrays();
	?>
	

	function getItemAtEndOfRow(currItem, allProducts){
		var theTop = jQuery(currItem).css('top');
		var $lastInRow = jQuery(currItem);
		for(var i=0; i<allProducts.length; i++){
			var $curr = jQuery(allProducts[i]);
			if ($curr.css("top") == theTop && $curr.hasClass("active"))
			{
				$lastInRow = $curr;
			}
		}

		return $lastInRow;
	}

	function populateDetailsPanel(id){
		var data = productDetailsById["id" + id];
		jQuery('div.details-panel .header-column .name').text(data.profile + " " + data.name);
		jQuery('div.details-panel .header-column .subtitle').text(data.straincategory + " " + data.type);
		jQuery('div.details-panel .overview-column .overview').html(data.overview);
		jQuery('div.details-panel .buy-column .terpene-images').html(data.terpenes);
		jQuery('div.details-panel .product-link a').attr('href', data.pagelink);

		if (data.terpenes.trim().length === 0){
			jQuery('div.details-panel .buy-column h4.terpenes').hide();
			jQuery('div.details-panel .buy-column .terpene-images').hide();
		}
		else {
			jQuery('div.details-panel .buy-column h4.terpenes').show();
			jQuery('div.details-panel .buy-column .terpene-images').show();
			jQuery('div.details-panel .buy-column .terpene-images').html(data.terpenes);
		}

		if (data.status == "available") {
			jQuery('div.details-panel .buy-column .price').show();
			jQuery('div.details-panel .buy-column .price .price').text(data.price);
			jQuery('div.details-panel .buy-column .price .buy').attr('href', data.storelink);
		}
		else{
			jQuery('div.details-panel .buy-column .price').hide();
		}
	}

	jQuery( document ).ready(function() {
        <?php
			$jsonProducts = array();
			foreach($theProducts as $product){
				$terpeneImages = $product->getTerpeneImages();

				$jsonProducts["id" . $product->id] = array("id" => $product->id,
										"profile" => $product->profile,
										"name" => $product->name,
										"overview" => $product->overview,
										"terpenes" => $terpeneImages,
										"type" => $product->producttype,
										"straincategory" => $product->straincategory,
										"price" => format_price_for_current_locale($product->actualprice),
										"pagelink" => get_permalink($product->id),
										"status" => $product->status,
										"storelink" => $product->storelink,
										"permalink" => $product->productUrl);
			}

			echo "productDetailsById = " . json_encode($jsonProducts) . ";";

			//check if thc, cbd, thc-cbd are all on Show All
			$turnAllProfilesOn = !isMobile;
			foreach ($productFilters->profileFilters as $filter)
			{
				$turnAllProfilesOn = $turnAllProfilesOn && $filter->filterHasNoPreselectedValues();
			}

			foreach ($productFilters->profileFilters as $filter)
			{
				echo "setFilterStates('input.product-filters-" . $filter->qsParamName . "', arrpreselected" . $filter->qsParamName . ", " . ($turnAllProfilesOn ? "true" : "false") . ");\n";
			}

            foreach ($productFilters->nonProfileFilters as $filter)
            {
				$turnSetOn = ($isMobile && $filter->filterHasNoPreselectedValues()) ? "true" : "false";
                echo "setFilterStates('input.product-filters-" . $filter->qsParamName . "', arrpreselected" . $filter->qsParamName . ");\n";	//", " . $turnSetOn .
            }
        ?>

		jQuery('ul.product-filters input[type=checkbox]').change(function() {
			console.log("changed");
			UpdateProducts(jQuery(this));
		});

		setMobilePanelButtonColors();
		jQuery('div.hthumb.init').removeClass('init');

		var allProducts = jQuery("div.product-item");
		jQuery("div.product-item.filterable-item").click(function(){
			var $this = jQuery(this);
			var id = $this.attr("data-id");
			var $lastInRow = getItemAtEndOfRow($this, allProducts);
			var dataId = $lastInRow.attr("data-id");
			jQuery("div.product-details-row").removeClass('active');
			if (id !== currentDetailsId) {
				jQuery("div.product-details-row[data-id='" + dataId + "']").addClass('active');
				currentDetailsId = id;
			}
			else {
				currentDetailsId = -1;
			}

			jQuery('#primary').isotope({ filter: '.active' });

			//position the little arrow on top of the gray panel
			var itemCenter = +removePx($this.css("left")) + +removePx($this.css("width")) / 2;
			var arrowWidth = 40;
			jQuery('div.details-panel-arrow').css('left', itemCenter - arrowWidth/2);
//			console.log(jQuery(this).css("top"));

			//postion the gray panel
			var panelColumnWidth = 3;
			var furthestLeft = getNumberOfColumns() - panelColumnWidth;
			var itemColumn = getColumnIndex($this.css('left'));
			var idealLeftEdgeColumn = itemColumn - 1;
			var constrainedColumn = Math.max(0, Math.min(idealLeftEdgeColumn, furthestLeft));
			var leftPadding = 12;
			console.log("constrainedColumn: " + idealLeftEdgeColumn + "  " + furthestLeft + "  " + constrainedColumn);
			jQuery('div.details-panel').css('left', leftPadding + constrainedColumn * columnWidth);

			populateDetailsPanel(id);
		});

	});	
</script>


<noscript>
	<style>
		.noscript-hide {
			display: none;
		}
	</style>
	<div class="row">
		<div class="col-lg-12 col-xs-12">
			<ul>
			<?php
			foreach($theProducts as $product){
				if ($product->initiallyActive == FALSE)
				{
					continue;
				}
			?>			
				<li>
					<div class="hthumb">
						<?php if($product->image) { 
							?>
							<a href="<?= $product->productUrl ?>"><img class="img-responsive" src="<?php echo $product->image ?>" alt="<?=$product->productName?>"/></a>
						<?php } ?>
					</div>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
</noscript>


<?
if ($deviceType === 'phone')
{
	require_once 'inc/products_page_mobile.php';
}
else
{
	require_once 'inc/products_page_desktop.php';
}
?>

</div> <!-- #page -->
<?php get_footer(); ?>

