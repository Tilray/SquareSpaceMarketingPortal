
<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";
</script>

<div class="container desktop">
	<div class="ie9-and-lower-only row">
		<div class="col-md-12 col-sm-12">
			<h1 class="products"><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="row filters">
		<div class="col-md-6 col-sm-12 profiles-column">
			<h1 class="products"><?php the_title(); ?></h1>
			<div class="row">
				<?php
				$productFilters->renderChemicalFilters();
				?>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="row">
				<?php
				$productFilters->productType->renderFilters();
				$productFilters->strainCategory->renderFilters();
				$productFilters->status->renderFilters();
				$productFilters->price->renderFilters();
				?>
			</div>
		</div>
	</div>

	<?php
	function renderProductsSection($allProducts, $productType, $sectionTitle){
		$sectionTitleActiveClass = "";
		foreach($allProducts as $product) {
			if ($product->producttype == $productType && $product->initiallyActive) {
				$sectionTitleActiveClass = " active";
			}
		}
		?>
		<div class="section-title product-item section-title-<?=$productType?><?=$sectionTitleActiveClass?>">
			<h3><?=_($sectionTitle)?></h3>
			<hr/>
		</div>
		<?php
		foreach($allProducts as $product) {
			if ($product->producttype == $productType) {
				$activeClass = $product->initiallyActive ? "active" : "";
				?>
				<div class="portbox post product-item filterable-item <?= $activeClass ?>"
					 data-id="<?= $product->id ?>"
					 data-straincategory="<?= $product->straincategory ?>"
					 data-status="<?= $product->status ?>"
					 data-producttype="<?= $product->producttype ?>"
					 data-thc="<?= $product->thc ?>"
					 data-price="<?= $product->price ?>"
				>
					<div class="product-item-inner init <?= $product->profile ?>">
						<div class="chem-type <?= $product->profile ?>">
							<div class="text-align">
								<span class="text-align-inner"><?= $product->profile ?></span>
							</div>
						</div>
						<div class="strain-name">
							<?= $product->name ?>
						</div>
						<div class="strain-category">
							<?= $product->straincategory ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 product-details-row product-item portbox"
					 data-id="<?=$product->id?>" data-straincategory="" data-status=""
					 data-producttype="" data-thc="" data-price="">
					<div class="details-panel-arrow"></div>
					<div class="details-panel">
						<div class="header-column">
							<h3 class="name"></h3>
							<h4 class="subtitle"></h4>
						</div>
						<div class="overview-column">
							<div class="overview"></div>
							<div class="product-link"><?=_("For cannabinoid and terpene information about this strain,")?> <a href=""><?=_("here")?></a></div>
						</div>
						<div class="buy-column">
							<div class="price">
								<span class="price"></span>
								<a class="buy">Buy Now</a>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
		}
	}

	?>

	<div class="row noscript-hide">
		<div class="col-12">
		
			<div id="primary" class="js-isotope" data-isotope-options='{ "masonry" : {"columnWidth": 239}, "itemSelector": ".product-item", "filter": ".active" }'>
			<?php
				renderProductsSection($theProducts, "flower", "Whole Flower");
				renderProductsSection($theProducts, "blend", "Flower Blends");
				renderProductsSection($theProducts, "extract", "Extracts");
			?>
			</div>
		</div>
	</div>
</div>

