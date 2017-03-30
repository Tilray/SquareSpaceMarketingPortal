<?php
/**
 * The template for displaying pages with left nav that displays all siblings.
 *
  Template name:Left & Center Nav, Self+Children
*/
get_header();

$group_parent_id = get_the_ID();

$this_template_slug = get_page_template_slug(get_the_ID());
$parent_page_id = wp_get_post_parent_id(get_the_ID());
$parent_template_slug = get_page_template_slug($parent_page_id);

if ($this_template_slug === $parent_template_slug){
	//parent is same template, so we are a child page
	$group_parent_id = $parent_page_id;
}

class groupPage{
	public $title;
	public $url;
	public $isCurrentPage;

	function __construct($title, $url, $isCurrentPage)
	{
		$this->title = $title;
		$this->url = $url;
		$this->isCurrentPage = $isCurrentPage;
	}
}

$allGroupPages = array();

$p = get_post($group_parent_id);
$allGroupPages[] = new groupPage($p->post_title, $p->post_name, $p->ID == get_the_ID());

$children_args = array(
	'post_parent' => $group_parent_id,
	'post_type'   => 'page',
	'numberposts' => -1,
	'post_status' => 'publish'
);
$children = get_children( $children_args );

foreach ($children as $child){
	$allGroupPages[] = new groupPage($child->post_title, $child->post_name, $child->ID == get_the_ID());
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
				$parID = wp_get_post_parent_id($group_parent_id);
				if ($parID)
				{
					render_left_nav($parID, $group_parent_id);
				}
			?>
		</div>
		<div id="primary" class="content-area col-sm-9">
			<div id="center-nav" class="col-sm-4">
				<?php
					foreach($allGroupPages as $groupPage){
						$selectedClass = $groupPage->isCurrentPage ? "center-nav-selected-child" : "";
						?>
						<span class="center-nav-item <?=$selectedClass?>"><a href="<?=$groupPage->url?>"><span class="left-nav-bullet"></span><h3><?=$groupPage->title?></h3></a></span>
						<?php
					}
//					echo get_all_the_pages(get_the_ID());
				?>
			</div>
			<div id="right-pane" class="col-sm-8">
				<?php the_content(); ?>
			</div>
		</div><!-- #primary -->
	</div>
</div>
</div> <!-- #page -->
<?php get_footer(); ?>
