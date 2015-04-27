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
	$status = "";
	$strainType = "";
	
	if (isset($_GET[$qpStrain]) && array_key_exists(strtolower($_GET[$qpStrain]), $allStrainTypes))
	{
		$strainType = strtolower($_GET[$qpStrain]);
	}
	
	if (isset($_GET[$qpStatus]) && array_key_exists(strtolower($_GET[$qpStatus]), $allStatuses))
	{
		$status = strtolower($_GET[$qpStatus]);
	}
	
	//write noscript block with links to all straintypes, current status
	//write noscript block wiht links to all statuses, current strain type
	//somehow hide all products and filters if noscript is rendered
	//render filtered products in noscript block

	$combinedFilter = "";
	if ($status != "")
	{
		$combinedFilter = $combinedFilter . ".category-" . $status;
	}
	if ($strainType != "")
	{
		$combinedFilter = $combinedFilter . ".category-" . $strainType;
	}
	
	if ($combinedFilter == "")
	{
		$combinedFilter = "*";
	}
?>

<div class="container">	
	<div class="row filters">
		<div class="col-12">
			<div class="product-filters-container">
				<h3 class="gray-underline">Status</h3>
				<ul class="product-filters product-filters-status">
					<li><input type="radio" class="product-filters-status" name="status" id="status-show-all" data-filter="" checked><label for="status-show-all">Show All</label></li>
					<li><input type="radio" class="product-filters-status" name="status" id="status-available" data-filter="available" ><label for="status-available">Available</label></li>
					<li><input type="radio" class="product-filters-status" name="status" id="status-in-production" data-filter="in-production" ><label for="status-in-production">In Production</label></li>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline">Strain Type</h3>
				<ul class="product-filters product-filters-strain-type">
					<li><input type="radio" class="product-filters-strain-type" name="strain-types" id="strain-type-show-all" data-filter="" checked><label for="strain-type-show-all">Show All</label></li>
					<li><input type="radio" class="product-filters-strain-type" name="strain-types" id="strain-type-indica" data-filter="indica" ><label for="strain-type-indica">Indica</label></li>
					<li><input type="radio" class="product-filters-strain-type" name="strain-types" id="strain-type-sativa" data-filter="sativa" ><label for="strain-type-sativa">Sativa</label></li>
					<li><input type="radio" class="product-filters-strain-type" name="strain-types" id="strain-type-hybrid" data-filter="hybrid" ><label for="strain-type-hybrid">Hybrid</label></li>
					<li><input type="radio" class="product-filters-strain-type" name="strain-types" id="strain-type-high-cbd" data-filter="high-cbd" ><label for="strain-type-high-cbd">High CBD</label></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
		
			<div id="primary" class="js-isotope" data-isotope-options='{ "columnWidth": 200, "itemSelector": ".product-item", "filter": "<?= $combinedFilter ?>" }'>
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
	function UpdateProducts()
	{
		var statusFilter = "";
		var statusParam = "";
		var statusFilters = jQuery('ul.product-filters-status input[type=radio]:checked');
		if (statusFilters.length > 0 && jQuery(statusFilters[0]).attr('data-filter') != ""){
			statusParam = jQuery(statusFilters[0]).attr('data-filter');
			statusFilter = '.category-' + statusParam;
		}

		var strainTypeFilter = "";
		var strainTypeParam = "";
		var strainTypeFilters = jQuery('ul.product-filters-strain-type input[type=radio]:checked');
		if (strainTypeFilters.length > 0 && jQuery(strainTypeFilters[0]).attr('data-filter') != ""){
			strainTypeParam = jQuery(strainTypeFilters[0]).attr('data-filter');
			strainTypeFilter = '.category-' + strainTypeParam;
		}

		var filter = statusFilter + strainTypeFilter;
		if (filter.trim() == '')
			filter = '*';
			
		jQuery('#primary').isotope({ filter: filter });
		
		window.history.replaceState({}, pageTitle, pageBaseURL + "?status=" + statusParam + "&straintype=" + strainTypeParam);
	}

	var preFilter = "<?= $combinedFilter?>";
	var preselectedStatus = "<?= $status ?>";
	var preselectedStrainType = "<?= $strainType ?>";
	
	jQuery( document ).ready(function() {
		if (preselectedStatus != "")
		{
			jQuery('input[data-filter="' + preselectedStatus + '"]').prop('checked', true);
		}
		if (preselectedStrainType != ""){
			jQuery('input[data-filter="' + preselectedStrainType + '"]').prop('checked', true);
		}

		jQuery('ul.product-filters input[type=radio]').change(function() {
			UpdateProducts();
		});
	});
</script>

</div> <!-- #page -->

<?php get_footer(); ?>
