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



<?php
	//get incoming status and straintype params
	$qpStrain = 'straintype';
	$qpStatus = 'status';
	$status = "";
	$strainType = "";
	
	$requestedStrainType = strtolower($_GET[$qpStrain]);
	if (isset($requestedStrainType) && in_array($requestedStrainType, $allStrainTypes))
	{
		$strainType = $requestedStrainType;
	}
	
	$requestedStatus = strtolower($_GET[$qpStatus]);
	if (isset($requestedStatus) && in_array($requestedStatus, $allStatuses))
	{
		$status = $requestedStatus;
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
				<ul class="product-filters">
					<li><input type="radio" name="status" id="status-show-all" data-filter="" checked><label for="status-show-all">Show All</label></li>
					<li><input type="radio" name="status" id="status-available" data-filter=".category-available" ><label for="status-available">Available</label></li>
					<li><input type="radio" name="status" id="status-in-production" data-filter=".category-in-production" ><label for="status-in-production">In Production</label></li>
				</ul>
			</div>
			<div class="product-filters-container">
				<h3 class="gray-underline">Strain Type</h3>
				<ul class="product-filters">
					<li><input type="radio" name="strain-types" id="strain-type-show-all" data-filter="" checked><label for="strain-type-show-all">Show All</label></li>
					<li><input type="radio" name="strain-types" id="strain-type-indica" data-filter=".category-indica" ><label for="strain-type-indica">Indica</label></li>
					<li><input type="radio" name="strain-types" id="strain-type-sativa" data-filter=".category-sativa" ><label for="strain-type-sativa">Sativa</label></li>
					<li><input type="radio" name="strain-types" id="strain-type-hybrid" data-filter=".category-hybrid" ><label for="strain-type-hybrid">Hybrid</label></li>
					<li><input type="radio" name="strain-types" id="strain-type-high-cbd" data-filter=".category-high-cbd" ><label for="strain-type-high-cbd">High CBD</label></li>
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
					$all_the_tags = wp_get_post_tags( get_the_ID() );
					$combined_tags = "";
					foreach($all_the_tags as $this_tag){
						$combined_tags = $combined_tags . " category-" . str_replace(" ", "-", strtolower($this_tag->name));
					}
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
		var filter = "";
		var allFilters = jQuery('ul.product-filters input[type=radio]:checked');
		for (var i = 0; i < allFilters.length; i++)
		{
			filter += jQuery(allFilters[i]).attr('data-filter');
		}
		if (filter.trim() == '')
			filter = '*';
			
		jQuery('#primary').isotope({ filter: filter });
	}

	var preFilter = "<?= $combinedFilter?>";
	var preselectedStatus = "<?= $status ?>";
	var preselectedStrainType = "<?= $strainType ?>";
	
	jQuery( document ).ready(function() {
//		jQuery('#primary').isotope({ filter: preFilter });
		if (preselectedStatus != "")
		{
			jQuery('input[data-filter=".category-' + preselectedStatus + '"]').prop('checked', true);
		}
		if (preselectedStrainType != ""){
			jQuery('input[data-filter=".category-' + preselectedStrainType + '"]').prop('checked', true);
		}

		jQuery('ul.product-filters input[type=radio]').change(function() {
			UpdateProducts();
		});
	});
</script>

</div> <!-- #page -->

<?php get_footer(); ?>
