	<div class="ie9-and-lower-only row">
		<div class="col-md-12 col-sm-12">
			<h1 class="products"><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="row filters">
        <div class="col-sm-12">
            <div class="row">
                <div class="product-page-title">
                    <?php $accessories_page_id = get_field('consumer_accessories_page', 'options'); ?>
                    <h1><?php the_title(); ?></h1>
                <h3><a href="<?=get_permalink($alternate_page_id)?>">View <?=get_the_title($alternate_page_id)?> &raquo;</a></h3>
                </div>
            </div>
        </div>
		<div class="col-md-6 col-sm-12 profiles-column">
			<div class="row">
				<?php
				$filterSet->renderChemicalFilters();
				?>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="row">
				<?php
				$filterSet->productType->renderFilters();
				$filterSet->strainCategory->renderFilters();
				$filterSet->status->renderFilters();
				$filterSet->price->renderFilters();
				?>
			</div>
		</div>
	</div>
