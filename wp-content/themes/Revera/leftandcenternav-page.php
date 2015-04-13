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
					$childPages = get_child_pages($parID);
					foreach ($childPages as $child)
					{
						$linkClass = "none";
						if ($child->ID == get_the_ID())
						{
							$linkClass = "left-nav-selected-child";
						}
						?>
						<span class="<?=$linkClass?>"><a href="<?php echo get_permalink( $child->ID );?>"><span class="left-nav-bullet"></span><h2><?php echo $child->post_title; ?></h2></a></span>
						<?php
					}
				}
			?>
		</div>
		<div id="primary" class="content-area col-sm-9">
			<div id="center-nav" class="col-sm-4">
			</div>
			<div class="col-sm-8">
				<?php the_content(); ?>
			</div>
		</div><!-- #primary -->
		<script>
			var allPanes = jQuery('.switchpane');
			var centerNavItemSelector = 'span.center-nav-item';
			
			function SelectPane(index){
				jQuery(allPanes).removeClass('active');
				jQuery(allPanes[index]).addClass('active');
				jQuery(allCenterNavItems).removeClass('center-nav-selected-child');
				jQuery(allCenterNavItems[index]).addClass('center-nav-selected-child');
			};
		
			for(var i = 0; i < allPanes.length; i++)
			{
				var title = jQuery(allPanes[i]).attr('data-title');
				var parentDiv = jQuery('#center-nav')[0];
				
				jQuery(parentDiv).append('<span data-index="'+ i +'" class="center-nav-item"><a><span class="left-nav-bullet"></span><h3>' + title + '</h3></a></span>');
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
