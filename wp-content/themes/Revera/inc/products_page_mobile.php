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

<?php
global $stickyFooterContent;
$stickyFooterContent = "<div class='mobile-products-flyout' style='height:200px'></div>";
?>

<script>
	var pageBaseURL = "<?= the_permalink() ?>";
	var pageTitle = "<?= the_title() ?>";


</script>

<div class="container">	
	<div class="filters mobile">
		<div class="col-12">
			<?php $productFilters->renderMobileFilters();?>
			<div class="product-filters-underline">
				<div class="gray-underline"></div>
			</div>
		</div>
	</div>
</div>
<div>
	<div class="noscript-hide">
		<?php
		
		foreach($theProducts as $product){
            
            $activeClass = $product->initiallyActive ? "active" : "";
			?>
			<div class="post mobile-product-item <?= $activeClass?>" 
				data-id="<?=$product->id?>" 
				data-straincategory="<?=$product->straincategory?>" 
				data-status="<?=$product->status?>" 
				data-producttype="<?=$product->producttype?>" 
				data-thc="<?=$product->thc?>" 
				data-price="<?=$product->price?>">
				<div class="hthumb">
					<?php 
					$imageUrl = $product->image;
					$hcpParam = "";
					if ($displayMode == 'hcp'){
						$imageUrl = $product->hcpImage;
						$hcpParam = "?hcp=1";
					}
					?>
					<a href="<?=$product->productUrl?><?=$hcpParam?>">
						<div class="mobile-products-page-image-container">
							<div class="mobile-products-color-stripe <?= str_replace("|", "_", $product->straincategory)?>"></div>
							<div class="mobile-product-image" style="background-image:url(<?=$imageUrl?>);" alt="<?=$product->productName?>"></div>
						</div>
					</a>
				</div>
				<div class="mobile-product-description">
					<div class="description-inner">
						<h3><?=$product->productName ?></h3>
						<h4><?=$product->primaryStrainCategoryName ?></h4>
					</div>
				</div>
			 </div>
		<?php } ?>
	</div>
</div>
