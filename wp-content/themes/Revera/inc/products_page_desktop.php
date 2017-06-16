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
				<div class="col-2 portbox post product-item filterable-item <?= $activeClass?>" 
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
						<a class="track-product-buy-button" href="<?=$product->productUrl?><?=$hcpParam?>"><img src="<?=$imageUrl?>" alt="<?=$product->productName?>"/></a>
					</div>
				 </div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
