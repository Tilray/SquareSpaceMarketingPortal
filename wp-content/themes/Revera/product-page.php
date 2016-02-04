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
				<h2 class="mockH1"><?php the_title(); ?></h2>
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
			//want to put accessories at the end, then sub-sort alphabetically
			$aIsAccessory = ($a->producttype == "accessory");
			$bIsAccessory = ($b->producttype == "accessory");
			if ($aIsAccessory == $bIsAccessory)
				return strcasecmp($a->productName, $b->productName);
				
			return $aIsAccessory ? 1 : -1;
		}
		usort($theProducts, "cmp");		
		
		return $theProducts;
	}
	
	$theProducts = QueryProducts($productFilters);	
?>

<div class="container">	
	<div class="row filters">
		<div class="col-12">
			<?php $productFilters->renderFilters();?>
			<div class="product-filters-underline">
				<div class="gray-underline"></div>
			</div>
		</div>
	</div>
	<div class="row noscript-hide">
		<div class="col-12">
		
			<div id="primary" class="js-isotope" data-isotope-options='{ "columnWidth": 200, "itemSelector": ".product-item", "filter": ".active" }'>
			<?php
			
			foreach($theProducts as $product){
                
                $activeClass = $product->initiallyActive ? "active" : "";
				?>
				<div class="col-2 portbox post product-item <?= $activeClass?>" 
					data-id="<?=$product->id?>" 
					data-straincategory="<?=$product->straincategory?>" 
					data-status="<?=$product->status?>" 
					data-producttype="<?=$product->producttype?>" 
					data-thc="<?=$product->thc?>" 
					data-price="<?=$product->price?>">
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
		
		setProductsActive();
		
		jQuery('#primary').isotope({ filter: '.active' });
		window.history.replaceState(
			{}, 
			pageTitle, 
			pageBaseURL + <?= $productFilters->getQueryStringRenderingJS() ?>
		);
	}
	
	function setProductsActive()
	{
		<?= $productFilters->renderProductsFilteringStatuses() ?>
		var selector = 'div#primary div.product-item';
		
		jQuery(selector).removeClass('active');
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
	});
</script>

<?php get_footer(); ?>
</div> <!-- #page -->

