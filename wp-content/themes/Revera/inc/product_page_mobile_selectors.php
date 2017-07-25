					<div class="mobile-filters-row">
						<div class="filter-button-wrapper">
							<div class="filter-button mobile profiles">
								<div class="filter-button-inner profiles" data-filter-name="profile">
									<div class="filter-label"><span><?= __("Profiles")?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$filterSet->productType->qsParamName?>">
								<div class="filter-button-inner <?=$filterSet->productType->qsParamName?>" data-filter-name="<?=$filterSet->productType->qsParamName?>">
									<div class="filter-label"><span><?= _e($filterSet->productType->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$filterSet->strainCategory->qsParamName?>">
								<div class="filter-button-inner <?=$filterSet->strainCategory->qsParamName?>" data-filter-name="<?=$filterSet->strainCategory->qsParamName?>">
									<div class="filter-label"><span><?= _e($filterSet->strainCategory->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile-filters-row">
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$filterSet->status->qsParamName?>">
								<div class="filter-button-inner <?=$filterSet->status->qsParamName?>" data-filter-name="<?=$filterSet->status->qsParamName?>">
									<div class="filter-label"><span><?= _e($filterSet->status->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile <?=$filterSet->price->qsParamName?>">
								<div class="filter-button-inner <?=$filterSet->price->qsParamName?>" data-filter-name="<?=$filterSet->price->qsParamName?>">
									<div class="filter-label"><span><?= _e($filterSet->price->displayName) ?></span></div><div class="filter-corner-triangle"></div>
								</div>
							</div>
						</div>
						<div class="divider"></div>
						<div class="filter-button-wrapper">
							<div class="filter-button non-profile mobile has-selections reset">
								<div class="filter-button-inner" data-filter-name="reset">
									<div class="filter-label"><span><?= _e("RESET") ?></span></div>
								</div>
							</div>
						</div>
					</div>