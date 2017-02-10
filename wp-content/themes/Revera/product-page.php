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
		//filter out far future products, and products with no status
		if (strlen($thisProduct->status) > 0 && strtolower($thisProduct->status != "future"))
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
			$profileSortResult = sortByProfile($a->profile, $b->profile);
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
	function arrayIncludes(arr, val){
		for (var i=0; i<arr.length; i++){
			if (arr[i] == val)
				return true;
		}

		return false;
	}

	function ProductFilter(id, isProfile, strTestFunction, currentFilterValues, allProfilesAreBlank){
		this.groupName = "";
		this.checkboxSelector = "ul li.product-filter input[type=checkbox][data-filter-name="+id+"]";
		this.showAllCheckboxSelector = "ul li.product-filter input[type=checkbox][data-filter-name="+id+"][data-filter='']";
		this.allCheckboxes = jQuery(this.checkboxSelector);
		this.id = id;
		this.selected = [];
		this.isProfile = isProfile;

		//set initial checkbox states
		if (isProfile && allProfilesAreBlank){
			jQuery(this.checkboxSelector).prop('checked', true);
			jQuery(this.showAllCheckboxSelector).prop('checked', false);
		}
		else {
			for (var i = 0; i < currentFilterValues.length; i++) {
				console.log(this.checkboxSelector + "[data-filter='" + currentFilterValues[i] + "']");
				var element = jQuery(this.checkboxSelector + "[data-filter='" + currentFilterValues[i] + "']");
				element.prop('checked', true);
			}
		}

		//creates this.test(product){...}
		eval(strTestFunction);

		this.reset = function(){
			if (isProfile){
				jQuery(this.checkboxSelector).prop('checked', true);
				jQuery(this.showAllCheckboxSelector).prop('checked', false);
			}
			else {
				jQuery(this.checkboxSelector).prop('checked', false);
				jQuery(this.showAllCheckboxSelector).prop('checked', true);
			}
		};


		this.allWereJustChecked = function($thisThingJustFlipped){
			//either show-all needs to be checked, or all non-show-all's need to be checked
			var allChecked = true;
			for(var i = 0; i < this.allCheckboxes.length; i++){
				var $cb = jQuery(this.allCheckboxes[i]);
				var isShowAll = ($cb.attr("data-filter") == "");
				var isChecked = (true === $cb.prop("checked"));

				//this thing was different a moment ago, so check its reverse value
				if ($cb.attr("id") === jQuery($thisThingJustFlipped).attr("id"))
					isChecked = !isChecked;

				if (isShowAll && isChecked)
					return true;

				allChecked = allChecked && (isShowAll || isChecked);
			}

			return allChecked;
		};

		this.allAreChecked = function(){
			//either show-all needs to be checked, or all non-show-all's need to be checked
			var allChecked = true;
			for(var i = 0; i < this.allCheckboxes.length; i++){
				var $cb = jQuery(this.allCheckboxes[i]);
				var isShowAll = ($cb.attr("data-filter") == "");
				var isChecked = (true === $cb.prop("checked"));

				if (isShowAll && isChecked) {
					console.log("Show all is checked " + $cb.attr("id") + "  " + $cb.attr("name") + "  " + this.allCheckboxes.length);
					return true;
				}
				allChecked = allChecked && (isShowAll || isChecked);
			}

			return allChecked;
		};

		this.noneAreChecked = function(){
			for(var i = 0; i < this.allCheckboxes.length; i++){
				if (true === jQuery(this.allCheckboxes[i]).prop("checked"))
					return false;
			}

			return true;
		};

		this.noneAreCheckedDontCountShowAll = function(){
			for(var i = 0; i < this.allCheckboxes.length; i++){
				var $cb = jQuery(this.allCheckboxes[i]);
				if (true === $cb.prop("checked") && ($cb.attr("data-filter") != ""))
					return false;
			}

			return true;
		};

		this.getSelectedValues = function(){
			var selected = [];

			for(var i = 0; i < this.allCheckboxes.length; i++) {
				var $thisBox = jQuery(this.allCheckboxes[i]);
				var isShowAll = ($thisBox.attr("data-filter") == "");
				var isChecked = (true === $thisBox.prop("checked"));

				if (isShowAll && isChecked)
					return [];

				if (isChecked) {
					selected.push($thisBox.attr("data-filter"));
				}
			}

			return selected;
		};

		this.cacheSelectedValues = function(){
			this.selected = this.getSelectedValues();
		};

		this.getQueryStringParam = function(skipAllChecked){
			if (this.noneAreCheckedDontCountShowAll())
				return "";

			if (skipAllChecked && this.allAreChecked())
				return "";

			var values = [];
			for(var i = 0; i < this.allCheckboxes.length; i++) {
				var thisValue = jQuery(this.allCheckboxes[i]).attr("data-filter");
				if (jQuery(this.allCheckboxes[i]).prop("checked")) {
					values.push(thisValue);
				}
			}

			return this.id + "=" + values.join(',');
		};
	}

	function ProductFilters(filtersJSON, isMobile){
		var self = this;
		this.isMobile = isMobile;
		this.filterData = filtersJSON.filters;
		this.profileFilters = [];
		this.nonProfileFilters = [];
		this.allFilters = [];
		this.filtersByName = {};

		this.onFilterChange = function($changedElement){
			var thisFilterCategory = jQuery($changedElement).attr('name');
			var thisFilterCategorySelector = 'ul input[type=checkbox][name=' + thisFilterCategory + ']';

			var filterName = jQuery($changedElement).attr('data-filter-name');
			var filter = self.filtersByName[filterName];

			if ($changedElement.attr("id") == "profile-show-all" || filter.isProfile)
				self.manageProfileFilterStates($changedElement);
			else
				self.manageNonProfileFilterState(filter, $changedElement);

			self.updateMobileSummaryPanel();
		};

		this.testProductActive = function(product, selectedProfiles, nonProfileFilters){
			//if none are selected, then we "found" it
			if(selectedProfiles.length > 0 && !arrayIncludes(selectedProfiles, product.profile))
				return false;

			for (var npf in nonProfileFilters){
				if (!nonProfileFilters[npf].test(product))
					return false;
			}

			return true;
		};

		this.testProductsActive = function(products){
			var selectedProfiles = [];
			for (var pf in self.profileFilters){
				selectedProfiles = selectedProfiles.concat(self.profileFilters[pf].getSelectedValues());
			}

			for (var pf in self.nonProfileFilters){
				self.nonProfileFilters[pf].cacheSelectedValues();
			}

			for (var p in products){
				var $item = jQuery("div.product-item.filterable-item[data-id='" + products[p].id + "']");
				if (self.testProductActive(products[p], selectedProfiles, self.nonProfileFilters))
				{
					$item.addClass("active");
				}
				else{
					$item.removeClass("active");
				}
			}
		};

		this.allProfilesChecked = function(){
			var allAreChecked = true;
			for (var pf in self.profileFilters){
				var thisFilter = self.profileFilters[pf];
				allAreChecked = allAreChecked && thisFilter.allAreChecked();
			}

			return allAreChecked;
		};

		this.noProfilesChecked = function(){
			var noneAreChecked = true;
			for (var pf in self.profileFilters){
				var thisFilter = self.profileFilters[pf];
				noneAreChecked = noneAreChecked && thisFilter.noneAreChecked();
			}

			return noneAreChecked;
		};

		this.manageProfileFilterStates = function(changedElement){
			var isShowAll = (jQuery(changedElement).attr("data-filter") == "");
			var $desktopShowAll = jQuery("input#profile-show-all");

			if (isShowAll){
				for (var pf in self.profileFilters) {
					var thisFilter = self.profileFilters[pf];
					//don't worry about checked or unchecked, re-check everything
					jQuery(thisFilter.checkboxSelector).prop('checked', true);
					//but then uncheck the show-all
					jQuery(thisFilter.showAllCheckboxSelector).prop('checked', false);
				}

				if ($desktopShowAll != null)
					$desktopShowAll.prop('checked', false);
			}
			else{
				var allAreChecked = true;
				var noneAreChecked = true;
				for (var pf in self.profileFilters){
					var thisFilter = self.profileFilters[pf];
					allAreChecked = allAreChecked && thisFilter.allWereJustChecked(jQuery(changedElement));
					noneAreChecked = noneAreChecked && thisFilter.noneAreChecked();
				}
				//one more loop through
				for (var pf in self.profileFilters) {
					if (allAreChecked){
						//if all the rest are checked, uncheck everything, and re-check this one
						jQuery(thisFilter.checkboxSelector).prop('checked', false);
						jQuery(changedElement).prop('checked', true);
					}
					else if (noneAreChecked){
						//if none are checked, check everything
						jQuery(thisFilter.checkboxSelector).prop('checked', true);
					}

					//no matter what, uncheck show-all
					var thisFilter = self.profileFilters[pf];
					jQuery(thisFilter.showAllCheckboxSelector).prop('checked', false);
				}

				if ($desktopShowAll != null)
					$desktopShowAll.prop('checked', false);
			}
		};

		this.manageNonProfileFilterState = function(filter, changedElement){
			var isShowAll = (jQuery(changedElement).attr("data-filter") == "");
			var isChecked = (true === jQuery(changedElement).prop("checked"));
			//four possible states:
			//show all just got unchecked
			//show all just got checked
			//something else just got checked
			//something else just got unchecked
			if (isShowAll){
				if (isChecked){
					//uncheck everything else
					jQuery(filter.checkboxSelector).prop('checked', false);
					jQuery(filter.showAllCheckboxSelector).prop('checked', true);
				}
				else{
					//check everything else
					jQuery(filter.checkboxSelector).prop('checked', true);
					jQuery(filter.showAllCheckboxSelector).prop('checked', false);
				}
			}
			else{
				if (isChecked){
					//make sure show-all is unchecked
					jQuery(filter.showAllCheckboxSelector).prop('checked', false);
				}
				else{
					//if nothing's checked, re-check show-all
					if (jQuery(filter.checkboxSelector + ":checked").length == 0)
						jQuery(filter.showAllCheckboxSelector).prop('checked', true);
				}
			}
		};

		this.resetFilters = function(){
			for (var i=0; i<self.allFilters.length; i++)
				self.allFilters[i].reset();
		};

		this.updateMobileSummaryPanel = function(){
			if (!self.isMobile)
				return;

			jQuery(".summary-contents .summary-item").hide();

			var allAreChecked = self.allProfilesChecked();
			var noneAreChecked = self.noProfilesChecked();

			if (!allAreChecked && !noneAreChecked){
				for(var i=0; i<self.profileFilters.length; i++){
					if (!self.profileFilters[i].noneAreChecked()){
						console.log("Showing .summary-contents .summary-item." + self.profileFilters[i].id);
						jQuery(".summary-contents .summary-item." + self.profileFilters[i].id).show();
					}
				}
			}

			for(var i=0; i<self.nonProfileFilters.length; i++){
				var f = self.nonProfileFilters[i];
				var selected = f.getSelectedValues();
				for (var j=0; j<selected.length; j++){
					console.log("Showing .summary-contents .summary-item." + f.id + selected[j]);
					jQuery(".summary-contents .summary-item." + f.id + selected[j]).show();
				}
			}
		};

		//loop through and see if any profile filters have values
		//we'll have to loop through again to create the filters :(
		var noProfilesAreSet = true;
		for (var f in this.filterData) {
			var filter = this.filterData[f];
			var isProfile = filter.isProfile;
			//if it's just one blank one, nothing is set
			var noneAreSet = filter.currentFilterValues.length == 1 && filter.currentFilterValues[0] == "";
			noProfilesAreSet = noProfilesAreSet && (!filter.isProfile || noneAreSet);
		}

		//create ProductFilter instances from json data
		for (var f in this.filterData){
			var filter = this.filterData[f];
			var pf = new ProductFilter(filter.qsParamName, filter.isProfile, filter.jsTestFunction, filter.currentFilterValues, noProfilesAreSet);
			self.filtersByName[filter.qsParamName] = pf;

			self.allFilters.push(pf);
			if (filter.isProfile)
				self.profileFilters.push(pf);
			else
				self.nonProfileFilters.push(pf);
		}
	}

	function Products(productsJSON, isMobile){
		var self = this;
		this.isMobile = isMobile;
		this.productsById = [];
		for(var i=0; i<productsJSON.length; i++){
			this.productsById[productsJSON[i].id] = productsJSON[i];
		}

		this.removePx = function(dimension){
			return dimension.replace("px", "");
		};

		this.columnWidth = 239;
		this.leftPadding = 12;
		this.currentDetailsId = -1;

		this.getNumberOfColumns = function(){
			return Math.floor(+self.removePx(jQuery("#primary").css("width")) / self.columnWidth);
		};

		this.getColumnIndex = function(leftEdge){
			return Math.round(self.removePx(leftEdge)/self.columnWidth);
		};

		this.htmlDecode = function(value) {
			return jQuery("<div/>").html(value).text();
		};

		this.getItemAtEndOfRow = function(currItem, allProducts){
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
		};

		this.allProducts = jQuery("div.product-item");
		if (!isMobile) {
			jQuery("div.product-item.filterable-item").click(function () {
				var $this = jQuery(this);
				var id = $this.attr("data-id");
				var $lastInRow = self.getItemAtEndOfRow($this, self.allProducts);
				var dataId = $lastInRow.attr("data-id");
				jQuery("div.product-details-row").removeClass('active');
				if (id !== self.currentDetailsId) {
					jQuery("div.product-details-row[data-id='" + dataId + "']").addClass('active');
					self.currentDetailsId = id;
				}
				else {
					self.currentDetailsId = -1;
				}

				jQuery('#primary').isotope({filter: '.active'});

				//position the little arrow on top of the gray panel
				var itemCenter = +self.removePx($this.css("left")) + +self.removePx($this.css("width")) / 2;
				var arrowWidth = 40;
				jQuery('div.details-panel-arrow').css('left', itemCenter - arrowWidth / 2);

				//postion the gray panel
				var panelColumnWidth = 3;
				var furthestLeft = self.getNumberOfColumns() - panelColumnWidth;
				var itemColumn = self.getColumnIndex($this.css('left'));
				var idealLeftEdgeColumn = itemColumn - 1;
				var constrainedColumn = Math.max(0, Math.min(idealLeftEdgeColumn, furthestLeft));
				jQuery('div.details-panel').css('left', self.leftPadding + constrainedColumn * self.columnWidth);

				self.populateDetailsPanel(id);
			});
		}

		this.populateDetailsPanel = function(id){
			var data = this.productsById[+id];
			jQuery('div.details-panel .header-column .name').text(data.profile + " " + data.name);
			jQuery('div.details-panel .header-column .subtitle').text(data.straincategory + " " + data.producttype);
			jQuery('div.details-panel .overview-column .overview').html(data.overview);
			jQuery('div.details-panel .product-link a').attr('href', data.productUrl);

			if (data.terpenes.length > 0){
				jQuery('div.details-panel .buy-column .terpenes').show();
				jQuery('div.details-panel .buy-column .terpenes .content').html(data.terpenes);
			}
			else{
				jQuery('div.details-panel .buy-column .terpenes').hides();
			}

			if (data.status == "available") {
				jQuery('div.details-panel .buy-column .price').show();
				jQuery('div.details-panel .buy-column .price .price').text(data.priceText);
				jQuery('div.details-panel .buy-column .price .buy').attr('href', data.storelink);
			}
			else{
				jQuery('div.details-panel .buy-column .price').hide();
			}
		}

	}

	function ProductLogic() {
		var self = this;

		var isMobile = (jQuery('.filter-panel.mobile').length > 0);
		this.productsData = <?= json_encode($theProducts) ?>;
		this.filtersData = <?= $productFilters->getJSON() ?>;

		this.updateProductsAndSections = function(){
			jQuery("div.section-title").removeClass('active');
			this.showSectionTitles("flower");
			this.showSectionTitles("blend");
			this.showSectionTitles("extract");

			jQuery('#primary').isotope({ filter: '.active' });
		};

		this.showSectionTitles = function(sectionName){
			var numActiveItems = jQuery("div.product-item.active[data-producttype='" + sectionName + "']").length;
			if (numActiveItems > 0){
				jQuery("div.section-title-" + sectionName).addClass("active");
			}
		};

		this.updateURI = function(){
			if (typeof window.history.replaceState !== 'function')
				return;

			var params = [];
			for (var i=0; i<this.filters.nonProfileFilters.length; i++){
				var thisParam = this.filters.nonProfileFilters[i].getQueryStringParam(true);
				if (thisParam.length > 0)
					params.push(thisParam);
			}

			var profileParams = [];
			var allProfilesChecked = true;
			for (var i=0; i<this.filters.profileFilters.length; i++){
				var thisParam = this.filters.profileFilters[i].getQueryStringParam(false);
				console.log(thisParam);
				if (thisParam.length > 0)
					profileParams.push(thisParam);
				allProfilesChecked = allProfilesChecked && this.filters.profileFilters[i].allAreChecked();
			}

			console.log("All checked? " + allProfilesChecked + "  length " + profileParams.length);

			if (!allProfilesChecked && profileParams.length > 0)
				params = params.concat(profileParams);

			window.history.replaceState(
				{},
				pageTitle,
				pageBaseURL + "?" + params.join("&")
			);
		};
		this.setMobilePanelButtonColors = function(){
			for (var i=0; i<this.filters.nonProfileFilters.length; i++){
				var thisFilter = this.filters.nonProfileFilters[i];
				var $button = jQuery("div.filter-button." + thisFilter.id);
				if (thisFilter.allAreChecked() || thisFilter.noneAreChecked())
					$button.removeClass("has-selections");
				else
					$button.addClass("has-selections");
			}

			for (var i=0; i<this.filters.profileFilters.length; i++){
				var thisFilter = this.filters.profileFilters[i];
				var $button = jQuery("div.filter-button." + thisFilter.id);
				if (thisFilter.noneAreChecked())
					$button.removeClass("has-selections");
				else
					$button.addClass("has-selections");
			}
		};

		this.onFilterChange = function($changedElement){
			if ($changedElement)
				self.filters.onFilterChange($changedElement);

			self.filters.testProductsActive(self.productsData);
			self.updateProductsAndSections();
			self.updateURI();
			self.setMobilePanelButtonColors();
		};

		this.resetFilters = function(){
			this.filters.resetFilters();
			this.onFilterChange();
		};

		jQuery('.filter-button.mobile.reset').click(function(){
			self.resetFilters();
		});

		jQuery('ul.product-filters input[type=checkbox]').change(function() {
			self.onFilterChange(jQuery(this));
		});

		this.filters = new ProductFilters(this.filtersData, isMobile);
		this.products = new Products(this.productsData, isMobile);
		this.setMobilePanelButtonColors();
	};

	//disable positioning animations
	Isotope.prototype._positionItem = function( item, x, y ) {
		item.goTo( x, y );
	};

	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";


	jQuery( document ).ready(function() {
		var productLogic = new ProductLogic();
		jQuery('div.hthumb.init').removeClass('init');
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

