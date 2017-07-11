<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left and Center Nav
*/
get_header(); 

function get_anchor_name($title){
    $title = strtolower($title);
    $title = preg_replace("/[^0-9a-zA-Z_]+/", "", $title);
    $title = str_replace(" +", "_", $title);
    return $title;
}
?>

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
			<?php
				$titles = array();
				$contents = array();
				if( have_rows('sections') ):
				    while( have_rows('sections') ) : the_row();
				        $titles[] = get_sub_field('title');
				        $contents[] = get_sub_field('content');
				    endwhile;
				endif;

				foreach ($titles as $this_title) {
					?>
					<span class="center-nav-item" data-index="<?=get_anchor_name($this_title)?>"><a class="anchor" href="#"><span class="left-nav-bullet"></span><h3><?=$this_title?></h3></a></span>
					<?php
				}
			?>
			</div>
			<div id="right-pane" class="col-sm-8">
			<?php
				$index = 0;
				foreach ($contents as $this_content) {
					?>
					<a name="<?=get_anchor_name($titles[$index])?>" data-index="<?=get_anchor_name($titles[$index])?>"></a>
					<div class="switchpane">
						<h3><?=$titles[$index]?></h3>
						<div class="answer"><?=$this_content?></div>
						<p class="back-to-top">
							<a href="#" onclick="jQuery(&quot;html, body&quot;).animate({scrollTop:0});"><i class="icon-up-big" aria-hidden="true"></i><?=__("Back to Top")?></a>
						</p>
					</div>
			<?php
					$index++;
				}
			?>
			</div>
		</div><!-- #primary -->
		<script>
			var allPanes = jQuery('.switchpane');
			var centerNavItemSelector = 'span.center-nav-item';
			
			function SelectPane(index, element){
				var offset = jQuery('a[data-index="' + index + '"]').offset().top - 40;

				//don't scroll to the first one, it just looks weird
				jQuery('html, body').animate({scrollTop: offset}, 750);

				jQuery(allCenterNavItems).removeClass('center-nav-selected-child');
				jQuery(element).addClass('center-nav-selected-child');
			};
		
			for(var i = 0; i < allPanes.length; i++)
			{
				var title = jQuery(allPanes[i]).attr('data-index');
				jQuery(allPanes[i]).attr('data-index', i);
				var parentDiv = jQuery('#center-nav')[0];
			}

			var allCenterNavItems = jQuery(centerNavItemSelector);
			allCenterNavItems.click(function() {
				var $this = jQuery(this);
				var thisIndex = $this.attr('data-index');
				console.log("Selecting " + thisIndex);
				SelectPane(thisIndex, $this);
			});

			jQuery(centerNavItemSelector).first().addClass('center-nav-selected-child');
			
			
//			SelectPane(0);
		</script>
	</div>	
</div>
</div> <!-- #page -->
<?php get_footer(); ?>
