	<div class="ie9-and-lower-only row">
		<div class="col-md-12 col-sm-12">
			<h1 class="products"><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="row filters">
		<div class="col-md-6 col-sm-12 profiles-column">
            <div class="product-page-title">
                <?php $products_page_id = get_field('consumer_products_page', 'options'); ?>
                <h1><?php the_title(); ?></h1>
                <h3><a href="<?=get_permalink($alternate_page_id)?>">View <?=get_the_title($alternate_page_id)?> &raquo;</a></h3>
            </div>
            <div class="row">
				<?php
				$filterSet->status->renderFilters();
				$filterSet->accessoryType->renderFilters();
				?>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="row">
			</div>
		</div>
	</div>
