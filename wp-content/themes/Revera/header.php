<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package web2feel
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-useragent="<?=$_SERVER['HTTP_USER_AGENT']?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<meta name="msvalidate.01" content="8D1268D07946606791541B9681F5FBBE" />
<meta name="p:domain_verify" content="f120c771cc01596bc34ee72616a99494"/>
<?php
	global $extra_header_content;
	global $structured_data_itemscope;

	if (isset($extra_header_content)){
		echo $extra_header_content;
	}

	if (!isset($structured_data_itemscope)){
		$structured_data_itemscope = "";
	}
?>
</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'inc/googletagmanager' ); ?>
<?php
	$ieClass = "";
	if(preg_match('/(?i)msie (.*?);/',$_SERVER['HTTP_USER_AGENT'])){
		$ieClass = "ie";
	}

	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "msie 9") > 0){
		$ieClass .= " ie9";
	}
	else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "msie 8") > 0){
		$ieClass .= " ie8";
	}
	else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "msie 7") > 0){
		$ieClass .= " ie7";
	}
?>
<div id="page" <?=$structured_data_itemscope?> class="hfeed site <?=$ieClass?>">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div id="mobile-nav">
			<ul>
			<?php 
				function RenderMobileNavLI($text, $url){
					?><li><a href="<?=$url?>"><?=$text?></a></li><?php
				}
				
				function RenderMobileNavSubMenu($navItem, $items)
				{
					?><li><a href="<?=$navItem->url?>"><?=$navItem->title?></a><ul><?
					foreach($items as $item){
						?><li><a href="<?=$item->url?>"><?=$item->title?></a></li><?php
					}
					?></ul></li><?
				}
					
				$allNavItems = wp_get_nav_menu_items("mobile-primary-menu");
				$childPagesByParentId = array();
				$primaryNavItems = array();
				//walk the array, looking for items with parent_id's
				foreach($allNavItems as $navItem){
					$parentId = $navItem->menu_item_parent;
					if ($parentId == "0")
					{
						$primaryNavItems[] = $navItem;
					}
					else{
						if (!array_key_exists($parentId, $childPagesByParentId)){
							$childPagesByParentId[$parentId] = array();
						}
						
						$childPagesByParentId[$parentId][] = $navItem;
					}
				}
				
				RenderMobileNavLI(__("Home"), get_home_url() . "/");
				$otherLang = get_other_language();
				RenderMobileNavLI(ucwords($otherLang["native_name"]), $otherLang["url"]);
				
				foreach($primaryNavItems as $navItem){
					if (array_key_exists($navItem->ID, $childPagesByParentId))
					{
						RenderMobileNavSubMenu($navItem, $childPagesByParentId[$navItem->ID]);
					}
					else{
						RenderMobileNavLI($navItem->title, $navItem->url);
					}
				}
			?>
			</ul>
		</div>
		
		<div class="container">
			<div class="login-nav-wrapper">
				<?php 
				if (function_exists("get_current_language_name")){
					?><div id="language-chooser" class="language-chooser"><a id="languagechooserbutton"><?php 
						echo get_current_language_name();
						?><span class="caret"></span></a></div>
				<?php
				}
				?>
				<?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'login','container_class' => 'login-menu-container','menu_id'=>'login-menu' ,'menu_class'=>'login-menu' ) ); ?>
				<span class="social-connections">
					<a href="https://www.facebook.com/tilray" target="_blank">
						<i class="icon-facebook"></i>
					</a>
					<a href="https://twitter.com/@tilray" target="_blank">
						<i class="icon-twitter"></i>
					</a>
					<a href="https://www.instagram.com/tilraycanada/" target="_blank">
						<i class="icon-instagram"></i>
					</a>
				</span>
            </div>
			<div id="languagedropdownwrapper">
				<div id="languagedropdown" class="closed">
				<?php
					create_language_chooser("lang-chooser-dropdown");
				?>	
				</div>				
			</div>
		</div>
			
		<nav class="container">
			<div class="row">
				<div class="site-branding col-sm-3">
				<?php
					$tag = "h2";
					if ($_SERVER["REQUEST_URI"] == '/')
						$tag = "h1";
				?>
				<<?=$tag?> class="site-title logo"><a id="blogname" rel="home" href="<?=get_wpml_home_url()?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><meta itemprop="logo" content="http://tilray.staging.wpengine.com/wp-content/themes/Revera/images/tilray-nav-logo.svg"><?php bloginfo( 'name' ); ?></a></<?=$tag?>>
				</div>
				<div class="col-sm-9 mainmenu">
                    <div id="primary-menu-container" class="topmenu">
                        <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'primary','container_class' => '','menu_id'=>'primary-menu' ,'menu_class'=>'sfmenu' ) ); ?>
                        <form method="get" id="search-form" action="<?php echo get_search_page_url(); ?>">
                            <label>
                                <span class="screen-reader-text">Search for:</span>
                                <input type="search" class="search-field" placeholder="" value="" name="term" title="Search for:">
                            </label>
                            <button type="submit" class="search-submit">
                                <i class="icon-search"></i>
                            </button>
                            <input type="hidden" name="lang" value="en">                           
                        </form>
                    </div>
				</div>		
			</div> <!-- end row -->
		</nav>	
		<meta itemprop="name" content="Tilray">
	</header><!-- #masthead -->
	
	

	<div id="content" class="site-content ">
	