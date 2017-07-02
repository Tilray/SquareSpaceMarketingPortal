				<div class="portbox post product-item accessory filterable-item <?= $activeClass ?>"
					 data-id="<?= $product->id ?>"
					 data-status="<?= $product->status ?>"
					 data-price="<?= $product->price ?>"
				>
					<div class="accessory-item-inner init">
						<a class="track-product-buy-button" href="<?=$product->productUrl?>">
							<img src="<?=$product->image?>" alt="<?=$product->productName?>"/>
							<div class="accessory-name">
								<?= $product->name ?>
							</div>
						</a>
					</div>
				</div>
