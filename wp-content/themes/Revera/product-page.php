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
	$qpStrain = 'strain-types';
	$qpStatus = 'status';
	$qpPrice = 'prices';
	$arrStatuses = splitAndGetQueryStringParamIfValid($qpStatus, $allStatuses);
	$arrStrainTypes = splitAndGetQueryStringParamIfValid($qpStrain, $allStrainTypes);
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
	if (count($arrStrainTypes) == 0 || (count($arrStrainTypes) == 1 && $arrStrainTypes[0] == "")){
		$arrCombinedFilters[] = $theOneActualStatus;
	}
	//otherwise prefix status to each strain type
	else{
		foreach($arrStrainTypes as $thisStrainType){
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
		foreach ($allPrices as $thisRange)
		{
			$thisRange = ltrim($thisRange, "$");
			if ($thisRange == "")
				continue;
				
			$ends = explode("-", $thisRange);
			$low = intval($ends[0]);
			$high = intval($ends[1]);
			if ($priceVal >= $low && $priceVal <= $high){
				return $thisRange;
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
			$thisProduct->itemStrainType = trim(get_post_meta(get_the_ID(), 'strain_type', true));

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
				<h3 class="gray-underline"><?= __('Strain Type') ?></h3>
				<ul class="product-filters product-filters-strain-type">
					<?php
					RenderProductFilter("product-filters-strain-type", "strain-types", "strain-type-show-all", "", "Show All");
					RenderProductFilter("product-filters-strain-type", "strain-types", "strain-type-indica", "indica", "Indica");
					RenderProductFilter("product-filters-strain-type", "strain-types", "strain-type-sativa", "sativa", "Sativa");
					RenderProductFilter("product-filters-strain-type", "strain-types", "strain-type-hybrid", "hybrid", "Hybrid");
					RenderProductFilter("product-filters-strain-type", "strain-types", "strain-type-high-cbd", "high-cbd", "High CBD");
					?>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Price') ?></h3>
				<ul class="product-filters product-filters-price">
					<?php
					RenderProductFilter("product-filters-price", "price", "price-show-all", "", "Show All");
					RenderProductFilter("product-filters-price", "price", "price-8-9", "8-9", "$8-9");
					RenderProductFilter("product-filters-price", "price", "price-10-11", "10-11", "$10-11");
					RenderProductFilter("product-filters-price", "price", "price-12-13", "12-13", "$12-13");
					RenderProductFilter("product-filters-price", "price", "price-14-15", "14-15", "$14-15");
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
			$firstStrainType = "";
			$firstPrice = "";
			if (count($arrStatuses) > 0) $firstStatus = $arrStatuses[0];
			if (count($arrStrainTypes) > 0) $firstStrainType = $arrStrainTypes[0];
			if (count($arrPrices) > 0) $firstPrice = $arrPrices[0];
			
			foreach($theProducts as $product){
				$activeClass = "";
				if (
					($firstStatus == "" || in_array($product->itemStatus, $arrStatuses)) &&
					($firstStrainType == "" || in_array($product->itemStrainType, $arrStrainTypes)) &&
					($firstPrice == "" || in_array($product->priceRange, $arrPrices)))
				{
					$activeClass = "active";
				}
				$combined_tags = "category-" . $product->itemStatus . " category-" . $product->itemStrainType;
			?>
				<div class="col-2 portbox post product-item <?= $activeClass?>" 
					data-id="<?=$product->id?>" 
					data-straintype="<?=$product->itemStrainType?>" 
					data-status="<?=$product->itemStatus?>" 
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
					(count($arrStrainTypes) > 0 && $arrStrainTypes[0] != "" && !in_array($product->itemStrainType, $arrStrainTypes)) || 
					(count($arrPrices) > 0 && $arrPrices[0] != "" && !in_array($product->itemStrainType, $arrStrainTypes)))
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
		var strainTypeFilters = GetFiltersArray('ul.product-filters-strain-type input[type=checkbox]:checked');
		var priceFilters = GetFiltersArray('ul.product-filters-price input[type=checkbox]:checked');
		setProductsActive(statusFilters, strainTypeFilters, priceFilters);
		
		jQuery('#primary').isotope({ filter: '.active' });
		window.history.replaceState({}, pageTitle, pageBaseURL + "?status=" + statusFilters.join(',') + "&strain-types=" + strainTypeFilters.join(',') + "&prices=" + priceFilters.join(','));
	}
	
	function setProductsActive(statusFilters, strainTypeFilters, priceFilters)
	{
		if (statusFilters.length == 0)
			statusFilters = [''];
		if (strainTypeFilters.length == 0)
			strainTypeFilters = [''];
		if (priceFilters.length == 0)
			priceFilters = [''];
	
		var combinedStatus = "|||" + statusFilters.join("|||") + "|||";
		var combinedStrainType = "|||" + strainTypeFilters.join("|||") + "|||";
		var combinedPrice = "|||" + priceFilters.join("|||") + "|||";
		var selector = 'div#primary div.product-item';
		
		jQuery(selector).removeClass('active');
		jQuery(selector).each(function( index ) {
			var status = jQuery( this ).attr("data-status");
			var strainType = jQuery( this ).attr("data-straintype");
			var priceRange = jQuery( this ).attr("data-pricerange");
			if ((statusFilters[0] == '' || combinedStatus.indexOf("|||" + status + "|||") > -1) &&
				(strainTypeFilters[0] == '' || combinedStrainType.indexOf("|||" + strainType + "|||") > -1) && 
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
	
	function CombineFilters(statusFilters, strainTypeFilters){
		var combinedFilters = '';
		var statusFilter = '';
		var statusParam = '';
		
		//if one of the status filters that's not "show all" is checked, use that.
		if (statusFilters.length == 1 && statusFilters[0] != ""){
			statusFilter = '.category-' + statusFilters[0];
			combinedFilters = statusFilter;
		}

		var arrFilters = [];
		var strainTypeParam = "";
		if (strainTypeFilters.length > 0 && strainTypeFilters[0] != ""){
			strainTypeFilters.forEach(function(item){
				arrFilters.push(statusFilter + '.category-' + item);
			});
		}

		//if we have any strain filters, wipe out the status filter because it's tacked onto every strain filter
		if (arrFilters.length > 0)
			combinedFilters = arrFilters.join(', ');
			
		if (combinedFilters.trim() == '')
			combinedFilters = '*';
			
		return combinedFilters
	}

	var arrPreselectedStatus = ['<?= implode("', '", $arrStatuses) ?>'];
	var arrPreselectedStrainType = ['<?= implode("', '", $arrStrainTypes) ?>'];
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
		setFilterStates('input.product-filters-strain-type[data-filter="###"]', arrPreselectedStrainType);
		setFilterStates('input.product-filters-price[data-filter="###"]', arrPreselectedPrices);

		jQuery('ul.product-filters input[type=checkbox]').change(function() {
			UpdateProducts(jQuery(this));
		});
		
		var combinedFilters = CombineFilters(arrPreselectedStatus, arrPreselectedStrainType);
	});
</script>

<?php get_footer(); ?>
</div> <!-- #page -->

