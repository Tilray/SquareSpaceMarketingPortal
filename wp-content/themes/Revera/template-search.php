<?php
/**
 * Template Name: SearchForm
 * The template for displaying Search Results pages.
 *
 * @package web2feel
 */

get_header(); 

$page_base_url = get_the_permalink();
$term = '';
$whichpage = 0;
$start_row = 0;
$rows_per_page = 10;

if (isset($_GET['term']))
	$term = $_GET['term'];

if (isset($_GET['pg']))
	$whichpage = intval($_GET['pg']);

$start_row = $whichpage * $rows_per_page;


global $wpdb;
$sql_query = "SELECT wp_posts.* " . 
	"FROM wp_posts JOIN wp_icl_translations t ON wp_posts.ID = t.element_id AND t.element_type = CONCAT('post_', wp_posts.post_type) " .
	"WHERE wp_posts.post_status = 'publish' " . 
	"AND ((wp_posts.post_title LIKE '%%%s%%') OR (wp_posts.post_excerpt LIKE '%%%s%%') OR (wp_posts.post_content LIKE '%%%s%%')) " . 
	"AND t.language_code = '%s'" .
	"AND wp_posts.post_type IN ('post','page','tilray_banners','tilray_product' ) " . 
	"AND wp_posts.ID NOT IN (SELECT post_id from wp_postmeta WHERE meta_key = 'hidden_from_search' AND meta_value = '1') " .
	"ORDER BY wp_posts.post_date DESC " .
	"LIMIT %d,%d";

$sql = $wpdb->prepare(
	$sql_query,
	$wpdb->esc_like($term),
	$wpdb->esc_like($term),
	$wpdb->esc_like($term),
	get_current_language_code(),
	$start_row,
	$rows_per_page+1
);
$rows = $wpdb->get_results($sql);

$has_prev_page = ($start_row > 0);
$has_next_page = false;
$prev_page_url = $page_base_url . "?term=" . $term . "&pg=" . ($whichpage - 1);
$next_page_url = $page_base_url . "?term=" . $term . "&pg=" . ($whichpage + 1);
if (count($rows) > $rows_per_page){
	$has_next_page = true;
	array_pop($rows);
}

?>

<div class="page-head searchphp">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1><?=__("Search")?></h1>
				<p><?php printf( __( 'You searched for: %s', 'web2feel' ), '<span>' . urldecode($term) . '</span>' ); ?> </p>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">

		<?php foreach( $rows as $row) {
			?>
			<div class="search-result col-sm-12">
				<div class="search-image col-sm-2">
					<?php
					$thumbID = get_post_thumbnail_id($row->ID);
					$img_attrs = wp_get_attachment_image_src( $thumbID,'blog-preview' ); 
					$image = $img_attrs[0];
					if(!$image) {
						$image = get_bloginfo('stylesheet_directory') . '/images/defaultimage_360x202.png';
					}
					?>
					<a href="<?php the_permalink($row->ID); ?>"><img class="blog-preview" src="<?= $image ?>" alt="<?php echo get_the_title($row->ID);?>"/></a>
				</div>
				<div class="search-result-body col-sm-6">
					<h3><?php
					 $rawType = get_post_type($row->ID);
					 switch(strtolower($rawType)){
					 	case "post":
					 		echo __('News Page');
					 		break;
					 	case "tilray_product":
					 		echo __('Product Page');
					 		break;
					 	default:
					 		echo __('Information Page');
					 }
					 ?></h3>
					<a href="<?php the_permalink($row->ID); ?>"><h2><?php echo get_the_title($row->ID); ?></h2></a>
					<p>
						<?php echo custom_excerpt(25, "...", $row->ID); ?>
						<a class="read-more-link" href="<?php the_permalink($row->ID); ?>"><?= __('Read more') ?> &raquo;</a>
					</p>
				</div>
			</div>
		<?php } 
		if (count($rows) > 0):
		?>
			<div class="navigation pagination-buttons col-sm-12">
				<p>
				<?php 
				if ($has_prev_page){ ?>
					<a href="<?=$prev_page_url?>"><i class='icon-left-big'></i>&nbsp;&nbsp;<?=__("prev")?></a>
				<?php } 
				if ($has_next_page){ ?>
					<a href="<?=$next_page_url?>"><?=__("next")?>&nbsp;&nbsp;<i class='icon-right-big'></i></a>
				<?php } ?>
				</p>
			</div>

		<?php else : ?>

			<h2>No results found</h2>
			<p>Search again:
            <form method="get" id="search-form" action="<?php echo get_search_page_url(); ?>">
                <label>
                    <span class="screen-reader-text">Search for:</span>
                    <input type="search" class="search-field" style="width: 200px; border: solid gray 1px;" placeholder="" value="" name="term" title="Search for:">
                </label>
                <button type="submit" class="search-submit">
                    <i class="icon-search">
                        
                    </i>
                </button>
                <input type="hidden" name="lang" value="en">                           
            </form>
            </p>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

	</div>
</div>
<?php get_footer(); ?>