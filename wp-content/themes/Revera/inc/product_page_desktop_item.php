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
							<?= __($product->name) ?>
						</div>
						<div class="strain-category">
							<?= __($product->straincategory) ?>
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
							<div class="overview">
								<?=__("THC:")?> <span class='thc percent'></span>&nbsp;&nbsp;<?=__('CBD:')?> <span class='cbd percent'>
							</div>
							<?php if (get_current_language_code() == "en"): ?>
								<div class="product-link">For more information about this product, click <a href="">here</a>.</div>
							<?php else: ?>
								<div class="product-link">Cliquez <a href="">ici</a> pour en apprendre davantage sur ce produit.</div>
							<?php endif; ?>
						</div>
						<div class="buy-column">
							<div class="price">
								<span class="price"></span>
								<a class="buy call-to-action-button orange"><span><?= __("Buy Now") ?></span></a>
							</div>
						</div>
					</div>
				</div>
