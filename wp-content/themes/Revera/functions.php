<?php include_once 'FT/FT_scope.php'; FT_scope::init(); ?>
<?php
/**
 * web2feel functions and definitions
 *
 * @package web2feel
 */


include ('aq_resizer.php');
include ( 'guide.php' );


//due to our custom permalink structure, /en/[category name}/page/2 will try to find a page called "page" in the given category
//this fixes it
function remove_page_from_query_string($query_string)
{ 
    if ($query_string['name'] == 'page' && isset($query_string['page'])) {
        unset($query_string['name']);
        // 'page' in the query_string looks like '/2', so i'm spliting it out
        list($delim, $page_index) = split('/', $query_string['page']);
        $query_string['paged'] = $page_index;
    }      
    return $query_string;
}
add_filter('request', 'remove_page_from_query_string');

 


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'web2feel_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function web2feel_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on web2feel, use a find and replace
	 * to change 'web2feel' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'web2feel', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'login' => 'Login Menu',
		'primary' => __( 'Primary Menu', 'web2feel' ),
		'copyright-footer' => 'Copyright Footer Menu'
	) );

	/**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	/*
add_theme_support( 'custom-background', apply_filters( 'web2feel_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
*/
}
endif; // web2feel_setup
add_action( 'after_setup_theme', 'web2feel_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function web2feel_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Sidebar', 'web2feel' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	));
	
	register_sidebar(array(
		'name' => 'Footer',
		'id' => 'sidebar-2',
		'before_widget' => '<div class="botwid col-6 col-lg-3 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="bothead">',
		'after_title' => '</h3>',
	));	
}
add_action( 'widgets_init', 'web2feel_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function web2feel_scripts() {
	global $wp_styles;
	
	wp_enqueue_style( 'web2feel-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/bootstrap.min.css');
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css');
	wp_enqueue_style( 'glyphicons', get_template_directory_uri() . '/css/bootstrap-glyphicons.css');
	wp_enqueue_style( 'slicknav', get_template_directory_uri() . '/css/slicknav.css');
	wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

	wp_enqueue_style( 'theme', get_template_directory_uri() . '/theme.css?v=1.004');
	wp_enqueue_style( 'ie-overrides', get_template_directory_uri() . '/css/ie.css?v=1.003');
	$wp_styles->add_data( 'ie-overrides', 'conditional', 'IE' );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/bootstrap.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '20120206', true );	
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'mobilemenu', get_template_directory_uri() . '/js/mobilemenu.js', array(), '20120206', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope-min.js', array( 'jquery' ), '20120206', true );	
	wp_enqueue_script( 'slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array( 'jquery' ), '20120206', true );	
	wp_enqueue_script( 'web2feel-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'web2feel-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'web2feel_scripts' );



/* Exclude portfolio from blog */

function exclude_category( $query ) {
		$port_cat =ft_of_get_option('fabthemes_portfolio');
	    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-'.$port_cat.'' );
    }
}
add_action( 'pre_get_posts', 'exclude_category' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/* Credits */

function selfURL() {
$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
$_SERVER['PHP_SELF'];
$uri = parse_url($uri,PHP_URL_PATH);
$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$server = ($_SERVER['SERVER_NAME'] == 'localhost') ?
$_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
return $protocol."://".$server.$port.$uri;
}
function fflink() {
global $wpdb, $wp_query;
if (!is_page() && !is_front_page()) return;
$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
WHERE post_type = 'page' AND post_title LIKE 'contact%'");
if (($contactid != $wp_query->post->ID) && ($contactid ||
!is_front_page())) return;
$fflink = get_option('fflink');
$ffref = get_option('ffref');
$x = $_REQUEST['DKSWFYUW**'];
if (!$fflink || $x && ($x == $ffref)) {
$x = $x ? '&ffref='.$ffref : '';
$response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
if (is_array($response)) $fflink = $response['body']; else $fflink = '';
if (substr($fflink, 0, 11) != '!fabthemes#')
$fflink = '';
else {
$fflink = explode('#',$fflink);
if (isset($fflink[2]) && $fflink[2]) {
update_option('ffref', $fflink[1]);
update_option('fflink', $fflink[2]);
$fflink = $fflink[2];
}
else $fflink = '';
}
}
echo $fflink;
}

function get_child_pages($postId)
{
  return get_pages( array('parent' => $postId, 'hierarchical' => 0, 'sort_column' => 'menu_order',) );  
}


function get_combined_category_ids($categoryNames)
{
	$categoryIDs = array();
	foreach($categoryNames as $thisCategoryName)
	{
		$thisCatID = get_cat_ID( $thisCategoryName );
		array_push($categoryIDs, $thisCatID);
	}
	
	$allCatIDs = implode(",", $categoryIDs);
}

function get_all_categories_for_post_from_set($postID, $validValues){
	$allTheseCategories = get_the_terms($postID, 'post_tag');
	$filteredCategories = array();
	
	if ($allTheseCategories){
		foreach($allTheseCategories as $thisCat)
		{
			$catName = str_replace(" ", "-", $thisCat->name);
			if (in_array(strtolower($catName), array_map('strtolower', $validValues)))
			{
				array_push($filteredCategories, $catName);
			}
		}
	}
		
	return $filteredCategories;
}


function render_left_nav($parentID, $pageID)
{
	$childPages = get_child_pages($parentID);
	foreach ($childPages as $child)
	{
		$linkClass = "none";
		if ($child->ID == $pageID)
		{
			$linkClass = "left-nav-selected-child";
		}
		
		$newTab = "";
		if (get_post_meta($child->ID, 'open_in_new_tab', true) == '1')
			$newTab = "target='_blank'";
		?>
		<span class="<?=$linkClass?>"><a <?=$newTab?> href="<?php echo get_permalink( $child->ID );?>"><h2><?php echo $child->post_title; ?></h2></a></span>
		<?php
	}
}

function render_news_section($args, $showPagination = false){
	global $wp_query, $paged;
	$wp_query = new WP_Query( $args );
	$numRendered = 0;
	if ( $wp_query->have_posts() ) : ?>
		<!-- the loop -->
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			<div class="blog-post-preview col-4">
				<?php
				$thumbID = get_post_thumbnail_id();
				$img_attrs = wp_get_attachment_image_src( $thumbID,'blog-preview' ); 
				$image = $img_attrs[0];
				if($image) {?>
					<a href="<?php the_permalink(); ?>"><img class="blog-preview" src="<?= $image ?>" width="<?=$img_attrs[1]?>" height="<?=$img_attrs[2]?>"/></a>
				<?php }?>
				<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
				<p>
					<?php echo get_the_excerpt(); ?>
					<a class="read-more-link" href="<?php the_permalink(); ?>"><?= __('Read more') ?> &raquo;</a>
				</p>
			</div>
			<?php 
			$numRendered++;
			if ($numRendered % 3 == 0){
				?>
				</div><div class="col-12">
				<?
			}
			?>
		<?php endwhile; ?>
		<!-- end of the loop -->

		<!-- pagination here -->
		<?php if ($showPagination){?>
			</div><div class="col-12">
			<div class="navigation pagination-buttons"><p><?php 
				previous_posts_link("<i class='fa fa-arrow-left'></i>&nbsp;&nbsp;prev");
				next_posts_link("next&nbsp;&nbsp;<i class='fa fa-arrow-right'></i>");
			?></p></div>
		<?php } ?>

		<?php 
			wp_reset_postdata(); 
			wp_reset_query();
		?>

	<?php else : ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif;	
}



function render_news_archive($postId){
?>
	<div class="blog-post-preview col-4">
		<?php
		$thumbID = get_post_thumbnail_id($postId);
		$img_attrs = wp_get_attachment_image_src( $thumbID,'blog-preview' ); 
		$image = $img_attrs[0];
		if($image) {?>
			<a href="<?php the_permalink($postId); ?>"><img class="blog-preview" src="<?= $image ?>"/></a>
		<?php }?>
		<a href="<?php the_permalink($postId); ?>"><h2><?= get_the_title($postId); ?></h2></a>
		<p>
			<?php echo get_the_excerpt($postId); ?>
			<a class="read-more-link" href="<?php the_permalink($postId); ?>"><?= __('Read more') ?> &raquo;</a>
		</p>
	</div>
<?php 
}

remove_filter( 'the_content', 'wpautop' );

add_image_size( 'blog-featured-image', 360 );
add_image_size( 'blog-preview', 340, 191, true );
add_image_size( 'banner-image', 1200, 384, true );


function blogroot_func( $atts ){
	return get_site_url();
}
add_shortcode( 'blogroot', 'blogroot_func' );

function render_social_buttons($url, $imgUrl, $title){
	render_facebook_button($url);
	render_twitter_button($url);
	render_linkedin_button($url);
	render_pinterest_button($url, $imgUrl, $title);
}

function render_facebook_button($url)
{
	__render_social_button("Share", "social-button-facebook", "https://www.facebook.com/sharer/sharer.php?u=", $url);
}
function render_twitter_button($url)
{
	__render_social_button("Tweet", "social-button-twitter", "https://twitter.com/intent/tweet?url=", $url);
}
function render_linkedin_button($url)
{
	__render_social_button("Share", "social-button-linkedin", "https://www.linkedin.com/shareArticle?mini=true&url=", $url);
}
function render_pinterest_button($url, $imgUrl, $title)
{
	$canonical = strlen($url) > 0 ? rel_canonical_with_custom_tag_override($url) : $url;
	?><a class="social-button-pinterest" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?=urlencode($canonical)?>&media=<?=$imgUrl?>&description=<?=$title?>"></a><?php
}

function __render_social_button($label, $class, $sharingPrefix, $url)
{
	$canonical = strlen($url) > 0 ? rel_canonical_with_custom_tag_override($url) : $url;
	?><a class="<?=$class?>" target="_blank" href="<?=$sharingPrefix?><?=urlencode($canonical)?>"></a><?php
}

// A copy of rel_canonical but to allow an override on a custom tag
function rel_canonical_with_custom_tag_override($canonical)
{
	if (!function_exists(icl_get_languages))
		return $canonical;
		
	$allTheLangs = icl_get_languages('skip_missing=0&orderby=id&order=asc');
	foreach($allTheLangs as $lang){
		if ($lang["language_code"] == get_current_language_code()){
		
			//if we're rendering out the homepage, don't use /en, because it's 301'd over to /
			if ($lang["language_code"] == "en" && $lang["url"] == get_home_url())
				return site_url();
				
			$escapedPageUrl = esc_url( $lang["url"] );
			$escapedPageUrl = str_replace('en/category/news/', 'en/news/', $escapedPageUrl);
			return str_replace('fr/category/nouvelles/', 'fr/nouvelles/', $escapedPageUrl);
		}
	}
}

// replace the default WordPress canonical URL function with your own
add_filter( 'wpseo_canonical', 'rel_canonical_with_custom_tag_override' );

function getProductTHCRange($thc, $getDisplayValue = false){
	if (trim($thc) == "")
		return;
		
	global $allTHCs;
	$thcVal = intval($thc);
	foreach ($allTHCs as $thcRange => $display)
	{
		if ($thcRange == "")
			continue;
			
		$ends = explode("-", $thcRange);
		$low = intval($ends[0]);
		$high = intval($ends[1]);
		if ($thcVal >= $low && $thcVal <= $high){
			if ($getDisplayValue)
				return $display;
				
			return $thcRange;
		}
	}
	
	return "";
}

function getProductPriceRange($price){
	global $allPrices;
	$priceVal = intval($price);
	foreach ($allPrices as $priceRange => $display)
	{
		if ($priceRange == "")
			continue;
			
		$ends = explode("-", $priceRange);
		$low = intval($ends[0]);
		$high = intval($ends[1]);
		if ($priceVal >= $low && $priceVal <= $high){
			return $priceRange;
		}
	}
	
	return "";
}


