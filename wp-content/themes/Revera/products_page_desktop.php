
<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";
</script>

<div class="container desktop">
	<?php
	if ($is_accessories_page)
		include "inc/accessories_page_desktop_selectors.php";
	else
		include "inc/product_page_desktop_selectors.php";

	function renderProductsSection($allProducts, $productType, $sectionTitle, $skipSectionTitle){
		$sectionTitleActiveClass = "";
		foreach($allProducts as $product) {
			if ($product->producttype == $productType && $product->initiallyActive) {
				$sectionTitleActiveClass = " active";
			}
		}

		if (!$skipSectionTitle){
			?>
			<div class="section-title product-item section-title-<?=$productType?><?=$sectionTitleActiveClass?>">
				<h3><?=__($sectionTitle)?></h3>
				<hr/>
			</div>
			<?php
		}
		
		foreach($allProducts as $product) {
			if ($product->producttype == $productType) {
				$activeClass = $product->initiallyActive ? "active" : "";
				global $is_accessories_page;
				if ($is_accessories_page){
					include "inc/accessories_page_desktop_item.php";
				}
				else{
					include "inc/product_page_desktop_item.php";
				}
			}
		}
	}

	?>

	<div class="row noscript-hide">
		<div class="col-12">
		
			<div id="primary" class="js-isotope" data-isotope-options='{ "masonry" : {"columnWidth": 239}, "itemSelector": ".product-item", "filter": ".active" }'>
			<?php
				$skipSectionTitle = (count($sections) < 2);
				foreach ($sections as $sectionid => $sectionlabel) {
					renderProductsSection($theProducts, $sectionid, $sectionlabel, $skipSectionTitle);
				}
			?>
			</div>
		</div>
	</div>
</div>

