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
 
get_header(); ?>
<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1><?php the_title(); ?></h1>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";
</script>

<?php
	function splitAndGetQueryStringParamIfValid($paramName, $allOfType)
	{
		$arrParams = Array();
		if (isset($_GET[$paramName]))
		{
			$validParam = strtolower($_GET[$paramName]);
			$arrParams = explode(',', $validParam);
			foreach ($arrParams as $item)
			{
				if (!array_key_exists($item, $allOfType) && !in_array($item, $allOfType)){
					//invalidate strainTypes since it has something it shouldn't in it.
					return Array();
				}
			}
		}
	
		return $arrParams;
	}
	

	//get incoming status and straintype querystring params
	$qpStatus = 'status';
	$qpStrain = 'strain-categories';
	$qpProductType = 'product-types';
	$qpPrice = 'prices';
	$arrStatuses = splitAndGetQueryStringParamIfValid($qpStatus, $allStatuses);
	$arrStrainCategories = splitAndGetQueryStringParamIfValid($qpStrain, $allStrainCategories);
	$arrProductTypes = splitAndGetQueryStringParamIfValid($qpProductType, $allProducts);
	$arrPrices = splitAndGetQueryStringParamIfValid($qpPrice, $allPrices);


	//this is essentially the same code as in JS.  However, using the JS isotope constructor 
	//does weird stuff when filtering, so we need to use the data- attribute isotope constrcutor
	//hence this partially duplicated code
	$arrCombinedFilters = array();
	
	//we could have no status (status == show all) or 2 (available and in production, which is the same as show all)
	//either case should not add a status to the combinedFilters
	$theOneActualStatus = '';
	if (count($arrStatuses) == 1 && $arrStatuses[0] != ''){
		$theOneActualStatus = '.category-' . $arrStatuses[0];
	}
	
	//if we have strain type show all, or now strain type, set filter to the status
	if (count($arrStrainCategories) == 0 || (count($arrStrainCategories) == 1 && $arrStrainCategories[0] == "")){
		$arrCombinedFilters[] = $theOneActualStatus;
	}
	//otherwise prefix status to each strain type
	else{
		foreach($arrStrainCategories as $thisStrainType){
			if ($thisStrainType != "")
				$arrCombinedFilters[] = $theOneActualStatus . '.category-' . $thisStrainType;
		}
	}	
	
	$combinedFilters = implode(" ", $arrCombinedFilters);
	if ($combinedFilters == "")
		$combinedFilters = "*";
	
	function RenderProductFilter($className, $name, $id, $filter, $label){
	?>
		<li class="product-filter">
			<span class="noscript-hide">
				<input type="checkbox" class="<?= $className?>" name="<?=$name?>" id="<?=$id?>" data-filter="<?=$filter?>">
				<label class="checkbox-label" for="<?=$id?>"><?php _e($label); ?></label>
			</span>
			<noscript>
				<a href="<?= sprintf('%s?%s=%s', the_permalink(), $name, $filter)?>"><?php _e($label); ?></a>
			</noscript>
		</li>
	<?php
	
	}
	
	function getPriceRange($price){
		global $allPrices;
		$priceVal = intval($price);
		foreach ($allPrices as $priceRange => $display)
		{
			if ($priceRange == "")
				continue;
				
			$ends = explode("-", $priceRange);
			$low = intval($ends[0]);
			$high = intval($ends[1]);
			if ($priceVal >= $low && $priceVal <= $high){
				return $priceRange;
			}
		}
		
		return "";
	}
	
	function QueryProducts()
	{
		$theProducts = array();
		
		$wp_query = new WP_Query(array('post_type' => 'tilray_product', 'posts_per_page' => '100' ));
		while ($wp_query->have_posts()) : $wp_query->the_post(); 
			$thisProduct = new stdClass;

			$thisProduct->id = get_the_ID();
			$thisProduct->itemStatus = trim(get_post_meta(get_the_ID(), 'status', true));
			$thisProduct->itemStrainCategory = trim(get_post_meta(get_the_ID(), 'strain_category', true));
			$thisProduct->itemProductType = trim(get_post_meta(get_the_ID(), 'product_type', true));

			$thumbID = get_post_thumbnail_id();
			$img_attrs = wp_get_attachment_image_src( $thumbID,'product-thumb' ); 
			$thisProduct->image = $img_attrs[0];
			
			$productUrl = trim(get_post_meta(get_the_ID(), 'shop_url', true));
			if ($productUrl == null || strlen($productUrl) == 0){
				$productUrl = get_the_permalink();
			}
			
			$thisProduct->productUrl = $productUrl;
			$thisProduct->productName = get_the_title();
			
			$productPrice = trim(get_post_meta(get_the_ID(), 'price', true));
			$thisProduct->price = $productPrice;
			$thisProduct->priceRange = getPriceRange($productPrice);

			$theProducts[] = $thisProduct;
		endwhile;
		
		wp_reset_query();

		//2 lines, but still better than messing with WP's query sorting
		function cmp($a, $b){return strcasecmp($a->productName, $b->productName);}
		usort($theProducts, "cmp");		
		
		return $theProducts;
	}
	
	$theProducts = QueryProducts();	
?>

<div class="container">	
	<div class="row filters">
		<div class="col-12">
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Status') ?></h3>
				<ul class="product-filters product-filters-status">
					<?php
					RenderProductFilter("product-filters-status", "status", "status-show-all", "", "Show All");
					RenderProductFilter("product-filters-status", "status", "status-available", "available", "Available");
					RenderProductFilter("product-filters-status", "status", "status-in-production", "in-production", "In Production");
					?>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Category') ?></h3>
				<ul class="product-filters product-filters-strain-category">
					<?php
					RenderProductFilter("product-filters-strain-category", "strain-categories", "strain-category-show-all", "", "Show All");
					RenderProductFilter("product-filters-strain-category", "strain-categories", "strain-category-indica", "indica", "Indica");
					RenderProductFilter("product-filters-strain-category", "strain-categories", "strain-category-sativa", "sativa", "Sativa");
					RenderProductFilter("product-filters-strain-category", "strain-categories", "strain-category-hybrid", "hybrid", "Hybrid");
					RenderProductFilter("product-filters-strain-category", "strain-categories", "strain-category-high-cbd", "high-cbd", "+CBD");
					?>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Product') ?></h3>
				<ul class="product-filters product-filters-product-type">
					<?php
					RenderProductFilter("product-filters-product-type", "product-types", "product-type-show-all", "", "Show All");
					RenderProductFilter("product-filters-product-type", "product-types", "product-type-flower", "flower", "Flower");
					RenderProductFilter("product-filters-product-type", "product-types", "product-type-blend", "blend", "Blend");
					?>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Price') ?></h3>
				<ul class="product-filters product-filters-price">
					<?php
					RenderProductFilter("product-filters-price", "prices", "price-show-all", "", "Show All");
					RenderProductFilter("product-filters-price", "prices", "price-4-6", "4-6", "$4-6");
					RenderProductFilter("product-filters-price", "prices", "price-7-9", "7-9", "$7-9");
					RenderProductFilter("product-filters-price", "prices", "price-10-12", "10-12", "$10-12");
					RenderProductFilter("product-filters-price", "prices", "price-13-1000", "13-1000", "$13+");
					?>
				</ul>
			</div>
			<div class="product-filters-underline">
				<div class="gray-underline"></div>
			</div>
		</div>
	</div>
	<div class="row noscript-hide">
		<div class="col-12">
		
			<div id="primary" class="js-isotope" data-isotope-options='{ "columnWidth": 200, "itemSelector": ".product-item", "filter": ".active" }'>
			<?php
			$firstStatus = "";
			$firstStrainCategory = "";
			$firstProductType = "";
			$firstPrice = "";
			if (count($arrStatuses) > 0) $firstStatus = $arrStatuses[0];
			if (count($arrStrainCategories) > 0) $firstStrainCategory = $arrStrainCategories[0];
			if (count($arrProductTypes) > 0) $firstProductType = $arrProductTypes[0];
			if (count($arrPrices) > 0) $firstPrice = $arrPrices[0];
			
			foreach($theProducts as $product){
				$activeClass = "";
				if (
					($firstStatus == "" || in_array($product->itemStatus, $arrStatuses)) &&
					($firstStrainCategory == "" || in_array($product->itemStrainCategory, $arrStrainCategories)) &&
					($firstProductType == "" || in_array($product->itemProductType, $arrProductTypes)) &&
					($firstPrice == "" || in_array($product->priceRange, $arrPrices)))
				{
					$activeClass = "active";
				}
			?>
				<div class="col-2 portbox post product-item <?= $activeClass?>" 
					data-id="<?=$product->id?>" 
					data-straincategory="<?=$product->itemStrainCategory?>" 
					data-status="<?=$product->itemStatus?>" 
					data-producttype="<?=$product->itemProductType?>" 
					data-pricerange="<?=$product->priceRange?>">
					<div class="hthumb">
						<?php if($product->image) { 
							?>
							<a href="<?= $product->productUrl ?>"><img src="<?php echo $product->image ?>" alt="<?=$product->productName?>"/></a>
						<?php } ?>
					</div>
				 </div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
<noscript>
	<style>
		.noscript-hide {
			display: none;
		}
	</style>
	<div class="row">
		<div class="col-12">
			<ul>
			<?php
			foreach($theProducts as $product){
				if ((count($arrStatuses) > 0 && $arrStatuses[0] != "" && !in_array($product->itemStatus, $arrStatuses)) ||
					(count($arrStrainCategories) > 0 && $arrStrainCategories[0] != "" && !in_array($product->itemStrainCategory, $arrStrainCategories)) || 
					(count($arrProductTypes) > 0 && $arrProductTypes[0] != "" && !in_array($product->itemProductType, $arrProductTypes)) || 
					(count($arrPrices) > 0 && $arrPrices[0] != "" && !in_array(getPriceRange($product->price), $arrPrices)))
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

<script>
	function UpdateProducts($clicked)
	{
		//if it's a show-all, reset checkboxes for all others of same category-
		//if it's not a show-all, reset show-all for this category-
		var thisFilterCategory = jQuery($clicked).attr('name');
		var thisFilterCategorySelector = 'ul input[type=checkbox][name=' + thisFilterCategory + ']';
		if (jQuery($clicked).attr('data-filter') == '')
		{
			var showAllChecked = jQuery($clicked).prop('checked');
			jQuery(thisFilterCategorySelector).each(function(index){
				jQuery(this).prop('checked', jQuery(this).attr('data-filter') == '' ? showAllChecked : !showAllChecked)
			});
		}
		else
		{
			//uncheck "Show All"
			jQuery(thisFilterCategorySelector + '[data-filter=""]').prop('checked', false);
			
			//if nothing's checked, re-check "show all"
			if (jQuery(thisFilterCategorySelector + ':checked').length == 0)
				jQuery(thisFilterCategorySelector + '[data-filter=""]').prop('checked', true);
		}
		
		var statusFilters = GetFiltersArray('ul.product-filters-status input[type=checkbox]:checked');
		var strainCategoryFilters = GetFiltersArray('ul.product-filters-strain-category input[type=checkbox]:checked');
		var productTypeFilters = GetFiltersArray('ul.product-filters-product-type input[type=checkbox]:checked');
		var priceFilters = GetFiltersArray('ul.product-filters-price input[type=checkbox]:checked');
		setProductsActive(statusFilters, strainCategoryFilters, productTypeFilters, priceFilters);
		
		jQuery('#primary').isotope({ filter: '.active' });
		window.history.replaceState(
			{}, 
			pageTitle, 
			pageBaseURL + 
				"?status=" + statusFilters.join(',') + 
				"&strain-categories=" + strainCategoryFilters.join(',') + 
				"&product-types=" + productTypeFilters.join(',') + 
				"&prices=" + priceFilters.join(','));
	}
	
	function setProductsActive(statusFilters, strainCategoryFilters, productTypeFilters, priceFilters)
	{
		if (statusFilters.length == 0)
			statusFilters = [''];
		if (strainCategoryFilters.length == 0)
			strainCategoryFilters = [''];
		if (productTypeFilters.length == 0)
			productTypeFilters = [''];
		if (priceFilters.length == 0)
			priceFilters = [''];
	
		var combinedStatus = "|||" + statusFilters.join("|||") + "|||";
		var combinedStrainCategory = "|||" + strainCategoryFilters.join("|||") + "|||";
		var combinedProductType = "|||" + productTypeFilters.join("|||") + "|||";
		var combinedPrice = "|||" + priceFilters.join("|||") + "|||";
		var selector = 'div#primary div.product-item';
		
		jQuery(selector).removeClass('active');
		jQuery(selector).each(function( index ) {
			var status = jQuery( this ).attr("data-status");
			var strainType = jQuery( this ).attr("data-straincategory");
			var category = jQuery( this ).attr("data-producttype");
			var priceRange = jQuery( this ).attr("data-pricerange");
			if ((statusFilters[0] == '' || combinedStatus.indexOf("|||" + status + "|||") > -1) &&
				(strainCategoryFilters[0] == '' || combinedStrainCategory.indexOf("|||" + strainType + "|||") > -1) && 
				(productTypeFilters[0] == '' || combinedProductType.indexOf("|||" + category + "|||") > -1) && 
				(priceFilters[0] == '' || combinedPrice.indexOf("|||" + priceRange + "|||") > -1))
			{
				jQuery(this).addClass('active');
			}
		});	
	}
	
	function GetFiltersArray(query)
	{
		var filters = [];
		jQuery(query).each(function(){
			filters.push(jQuery(this).attr('data-filter'));
		});
		
		return filters;
	}
	

	var arrPreselectedStatus = ['<?= implode("', '", $arrStatuses) ?>'];
	var arrPreselectedStrainCategory = ['<?= implode("', '", $arrStrainCategories) ?>'];
	var arrPreselectedProductType = ['<?= implode("', '", $arrProductTypes) ?>'];
	var arrPreselectedPrices = ['<?= implode("', '", $arrPrices) ?>'];
	
	function setFilterStates(filterSelector, statuses)
	{
		if (statuses.length == 0){
			jQuery(filterSelector.replace("###", "")).prop('checked', true);
		}
		else 
		{
			statuses.forEach(function(item)
			{
				jQuery(filterSelector.replace("###", item)).prop('checked', true);
			});
		}
	}
	
	jQuery( document ).ready(function() {
		setFilterStates('input.product-filters-status[data-filter="###"]', arrPreselectedStatus);
		setFilterStates('input.product-filters-strain-category[data-filter="###"]', arrPreselectedStrainCategory);
		setFilterStates('input.product-filters-product-type[data-filter="###"]', arrPreselectedProductType);
		setFilterStates('input.product-filters-price[data-filter="###"]', arrPreselectedPrices);

		jQuery('ul.product-filters input[type=checkbox]').change(function() {
			UpdateProducts(jQuery(this));
		});
	});
</script>

<?php get_footer(); ?>
</div> <!-- #page -->

