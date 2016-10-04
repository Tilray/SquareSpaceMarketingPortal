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

$displayMode = get_post_meta($id, 'display_mode', true);

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
		if ($aSortOrder == $bSortOrder)
			return strcasecmp($a->productName, $b->productName);
        return ($aSortOrder > $bSortOrder) ? 1 : -1;
	}
	usort($theProducts, "cmp");		
	
	return $theProducts;
}

$theProducts = QueryProducts($productFilters);	

?>
<script src="<?=get_template_directory_uri()?>/js/isotope-min.js"></script>
<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";

	function ResetFilters(){
		jQuery('ul input[type=checkbox]').attr('checked', false);		
		jQuery('ul input[type=checkbox][id*="-show-all"]').attr('checked', true);	
		setProductsActive();	
		setMobilePanelButtonColors();
		jQuery('#primary').isotope({ filter: '.active' });
		window.history.replaceState(
			{}, 
			pageTitle, 
			pageBaseURL + <?= $productFilters->getQueryStringRenderingJS() ?>
		);
	}

	function UpdateProducts($clicked)
	{
		//if it's a show-all, reset checkboxes for all others of same category-
		//if it's not a show-all, reset show-all for this category-

   		jQuery("body").animate({ scrollTop: 0 }, 400);

		var thisFilterCategory = jQuery($clicked).attr('name');
		console.log("Clicked filter " + thisFilterCategory);
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
		
		setProductsActive();
		setMobilePanelButtonColors();
		
		jQuery('#primary').isotope({ filter: '.active' });
		window.history.replaceState(
			{}, 
			pageTitle, 
			pageBaseURL + <?= $productFilters->getQueryStringRenderingJS() ?>
		);
	}

	function setMobilePanelButtonColors(){
		var $allPanels = jQuery(".filter-panel.mobile");
		jQuery(".filter-button.mobile").removeClass("has-selections");
		for (var i = 0; i < $allPanels.length; i++)
		{
			var filterName = jQuery($allPanels[i]).attr("data-filter");
			console.log("Updating " + jQuery($allPanels[i]).attr("data-filter"));
			console.log("Checking cb: " + jQuery("input#" + filterName + "-show-all"));
			var showAllCheckboxChecked = jQuery("input#" + filterName + "-show-all").is(":checked");
			console.log("Checked? " + showAllCheckboxChecked);

			if (!showAllCheckboxChecked)
				jQuery(".filter-button.mobile." + filterName).addClass("has-selections");
		}
	}
	
	//filterState: zero or more strings, joined and end-capped with |||
	//itemFilter: one or more strings, joined by |
	function testFilter(filterState, itemFilter){
		//if filter is set to "show all", return true, since everything matches
		if (filterState == '||||||')
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
		else if (filterState.indexOf('|||' + itemFilter + '|||') >= 0)
		{
			return true;
		}

		return false;
	}

	function setProductsActive()
	{
		<?= $productFilters->renderProductsFilteringStatuses() ?>
		var selector = 'div.filterable-item';
		
		jQuery(selector).removeClass('active');
				console.log("Removing all active classes from " + selector);
		jQuery(selector).each(function( index ) {
			if (
				<?= $productFilters->renderProductsFilteringConditions() ?>
				)
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
	

	<?php 
		$productFilters->createPreselectedStatusJSArrays();
	?>
	
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
        <?php
            foreach ($productFilters->filters as $filter)
            {
                echo "setFilterStates('input.product-filters-" . $filter->qsParamName . "[data-filter=\"###\"]', arrpreselected" . $filter->qsParamName . ");\n";
            }
        ?>

		jQuery('ul.product-filters input[type=checkbox]').change(function() {
			UpdateProducts(jQuery(this));
		});

		setMobilePanelButtonColors();
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

