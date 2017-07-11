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
