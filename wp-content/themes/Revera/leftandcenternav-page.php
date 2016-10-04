<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left and Center Nav
*/
get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1> <?php the_title(); ?> </h1>
				<p> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
		<div id="secondary" class="col-sm-3 left-nav-menu">
			<?php
				$parID = wp_get_post_parent_id(get_the_ID());
				if ($parID)
				{
					render_left_nav($parID, get_the_ID());
				}
			?>
		</div>
		<div id="primary" class="content-area col-sm-9">
			<div id="center-nav" class="col-sm-4">
			</div>
			<div id="right-pane" class="col-sm-8">
				<?php the_content(); ?>
			</div>
		</div><!-- #primary -->
		<script>
			var allPanes = jQuery('.switchpane');
			var centerNavItemSelector = 'span.center-nav-item';
			
			function SelectPane(index){
				var offset = jQuery('div[data-index="' + index + '"]').offset().top - 40;

				//don't scroll to the first one, it just looks weird
				if (index > 0)
					jQuery('html, body').animate({scrollTop: offset}, 750);

				jQuery(allCenterNavItems).removeClass('center-nav-selected-child');
				jQuery(allCenterNavItems[index]).addClass('center-nav-selected-child');
			};
		
			for(var i = 0; i < allPanes.length; i++)
			{
				var title = jQuery(allPanes[i]).attr('data-title');
				jQuery(allPanes[i]).append("<p class='back-to-top'><a href='#' onclick='jQuery(\"html, body\").animate({scrollTop:0});'><i class='fa fa-arrow-up' aria-hidden='true'></i><?php _e('Back to Top')?></a></p>");

				jQuery(allPanes[i]).attr('data-index', i);
				var parentDiv = jQuery('#center-nav')[0];
				
				jQuery(parentDiv).append('<span data-index="'+ i +'" class="center-nav-item"><a><span class="left-nav-bullet"></span><h3>' + title + '</h3></a></span>');
				
				jQuery(allPanes[i]).click(function(){
					jQuery(this).toggleClass("drawer-open");
				});
			}

			var allCenterNavItems = jQuery(centerNavItemSelector);
			allCenterNavItems.click(function() {
				var $this = jQuery(this);
				var thisIndex = $this.attr('data-index');
				SelectPane(thisIndex);
			});
			
			
			SelectPane(0);
		</script>
	</div>	
</div>
</div> <!-- #page -->
<?php get_footer(); ?>
