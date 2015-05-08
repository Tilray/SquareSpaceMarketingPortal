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
	//get incoming status and straintype params
	$qpStrain = 'straintype';
	$qpStatus = 'status';
	$statuses = "";
	$strainTypes = "";
	
	if (isset($_GET[$qpStrain]))
	{
		$strainTypes = strtolower($_GET[$qpStrain]);
		$arrStrainTypes = explode(',', $strainTypes);
		foreach ($arrStrainTypes as $strain)
		{
			if (!array_key_exists($strain, $allStrainTypes)){
				//invalidate strainTypes since it has something it shouldn't in it.
				$strainTypes = "";
			}
		}
	}
	
	if (isset($_GET[$qpStatus]))
	{
		$statuses = strtolower($_GET[$qpStatus]);
		$arrStatuses = explode(',', $statuses);
		foreach ($arrStatuses as $status)
		{
			if (!array_key_exists($status, $allStatuses)){
				//invalidate statuses since it has something it shouldn't in it.
				$statuses = "";
			}
		}
	}
	
	//write noscript block with links to all straintypes, current status
	//write noscript block wiht links to all statuses, current strain type
	//somehow hide all products and filters if noscript is rendered
	//render filtered products in noscript block
?>

<div class="container">	
	<div class="row filters">
		<div class="col-12">
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Status') ?></h3>
				<ul class="product-filters product-filters-status">
					<li><input type="checkbox" class="product-filters-status" name="status" id="status-show-all" data-filter=""><label for="status-show-all"><?php _e('Show All'); ?></label></li>
					<li><input type="checkbox" class="product-filters-status" name="status" id="status-available" data-filter="available" ><label for="status-available"><?php _e('Available');?></label></li>
					<li><input type="checkbox" class="product-filters-status" name="status" id="status-in-production" data-filter="in-production" ><label for="status-in-production"><?php _e('In Production');?></label></li>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline"><?= __('Strain Type') ?></h3>
				<ul class="product-filters product-filters-strain-type">
					<li><input type="checkbox" class="product-filters-strain-type" name="strain-types" id="strain-type-show-all" data-filter=""><label for="strain-type-show-all"><?php _e('Show All'); ?></label></li>
					<li><input type="checkbox" class="product-filters-strain-type" name="strain-types" id="strain-type-indica" data-filter="indica" ><label for="strain-type-indica"><?= __('Indica'); ?></label></li>
					<li><input type="checkbox" class="product-filters-strain-type" name="strain-types" id="strain-type-sativa" data-filter="sativa" ><label for="strain-type-sativa"><?php _e('Sativa'); ?></label></li>
					<li><input type="checkbox" class="product-filters-strain-type" name="strain-types" id="strain-type-hybrid" data-filter="hybrid" ><label for="strain-type-hybrid"><?php _e('Hybrid'); ?></label></li>
					<li><input type="checkbox" class="product-filters-strain-type" name="strain-types" id="strain-type-high-cbd" data-filter="high-cbd" ><label for="strain-type-high-cbd"><?php _e('High CBD'); ?></label></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
		
			<div id="primary" class="js-isotope">
			<?php
			$port_cat =ft_of_get_option('fabthemes_portfolio');
			
			if ( get_query_var('paged') )
				$paged = get_query_var('paged');
			elseif ( get_query_var('page') )
				$paged = get_query_var('page');
			else
				$paged = 1;
			$wp_query = new WP_Query(array('post_type' => 'tilray_product', 'posts_per_page' => '100', 'paged' => $paged ));
			?>
			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); 
					$itemStatus = trim(get_post_meta(get_the_ID(), 'status', true));
					$itemStrainType = trim(get_post_meta(get_the_ID(), 'strain_type', true));
					
					$combined_tags = "category-" . $itemStatus . " category-" . $itemStrainType;
			?>
				<div class="col-sm-3 col-6 portbox post product-item <?= $combined_tags?>" data-id="<?=get_the_ID()?>">
						
				 <?php
					$thumb = get_post_thumbnail_id();
					$img_attrs = wp_get_attachment_image_src( $thumb,'product-thumb' ); 
					$image = $img_attrs[0];
				 ?>
							
					<div class="hthumb">
						<?php if($image) { 
							$productUrl = trim(get_post_meta(get_the_ID(), 'shop_url', true));
							if ($productUrl == null || strlen($productUrl) == 0){
								$productUrl = get_the_permalink();
							}
							?>
							<a href="<?= $productUrl ?>"><img class="img-responsive" src="<?php echo $image ?>"/></a>
						<?php } ?>
					</div>

				 
				 </div>
				

			<?php endwhile; ?>
	</div>
</div>



	</div>
</div>

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
		var combinedFilters = CombineFilters(statusFilters, strainTypeFilters);
		
		jQuery('#primary').isotope({ filter: combinedFilters });
		window.history.replaceState({}, pageTitle, pageBaseURL + "?status=" + statusFilters.join(',') + "&straintype=" + strainTypeFilters.join(','));
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

	var arrPreselectedStatus = ("<?= $statuses ?>").split(',');
	var arrPreselectedStrainType = ("<?= $strainTypes ?>").split(',');
	
	jQuery( document ).ready(function() {
		if (arrPreselectedStatus.length == 0){
			jQuery('input.product-filters-status[data-filter=""]').prop('checked', true);
		}
		else 
		{
			arrPreselectedStatus.forEach(function(item)
			{
				jQuery('input.product-filters-status[data-filter="' + item + '"]').prop('checked', true);
			});
		}
		
		if (arrPreselectedStrainType.length == 0){
			jQuery('input.product-filters-strain-type[data-filter=""]').prop('checked', true);
		}
		else 
		{
			arrPreselectedStrainType.forEach(function(item)
			{
				jQuery('input.product-filters-strain-type[data-filter="' + item + '"]').prop('checked', true);
			});
		}

		jQuery('ul.product-filters input[type=checkbox]').change(function() {
			UpdateProducts(jQuery(this));
		});
		
		var combinedFilters = CombineFilters(arrPreselectedStatus, arrPreselectedStrainType);
		jQuery('#primary').isotope({ "columnWidth": 200, "itemSelector": ".product-item", filter: combinedFilters });		
		//data-isotope-options='{ "columnWidth": 200, "itemSelector": ".product-item", "filter": "" }'
	});
</script>

</div> <!-- #page -->

<?php get_footer(); ?>
