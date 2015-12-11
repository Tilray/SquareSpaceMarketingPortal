<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package web2feel
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<script src="//use.typekit.net/cfw8inp.js"></script>
<script>try{Typekit.load();}catch(e){}</script>
<meta name="msvalidate.01" content="8D1268D07946606791541B9681F5FBBE" />
</head>

<body <?php body_class(); ?>>
<?php get_template_part( 'inc/googletagmanager' ); ?>
<div id="page" class="hfeed site">
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
					
				$allNavItems = array_merge(wp_get_nav_menu_items("login"), wp_get_nav_menu_items("primary"));
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
				
				RenderMobileNavLI("Home", get_home_url());
				$otherLang = get_other_language();
				RenderMobileNavLI($otherLang["native_name"], $otherLang["url"]);
				
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
					<a href="http://www.facebook.com/tilray" target="_blank">
						<span class="fa fa-facebook"></span>
					</a>
					<a href="http://twitter.com/@tilray" target="_blank">
						<span class="fa fa-twitter"></span>
					</a>
					<a href="http://www.instagram.com/tilray" target="_blank">
						<span class="fa fa-instagram"></span>
					</a>
				</span>		
			</div>
			<div id="languagedropdownwrapper">
				<div id="languagedropdown" class="closed"><?php
								if (function_exists("render_language_chooser")){
									render_language_chooser("lang-chooser-dropdown");
								}
				?></div>				
			</div>
		</div>
			
		<nav class="container">
			<div class="row">
				<div class="site-branding col-sm-3">
				<h2 class="site-title logo"><a id="blogname" rel="home" href="<?=get_wpml_home_url()?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h2>
				</div>
				<div class="col-sm-9 mainmenu">
						<?php wp_nav_menu( array( 'container_id' => 'primary-menu-container', 'theme_location' => 'primary','container_class' => 'topmenu','menu_id'=>'primary-menu' ,'menu_class'=>'sfmenu' ) ); ?>
				</div>
		
			</div> <!-- end row -->
		</nav>	
	</header><!-- #masthead -->
	
	

	<div id="content" class="site-content ">
	