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
			
				$allNavItems = array_merge(wp_get_nav_menu_items("login"), wp_get_nav_menu_items("primary"));
				RenderMobileNavLI("Home", get_home_url());
				$otherLang = get_other_language();
				RenderMobileNavLI($otherLang["native_name"], $otherLang["url"]);
				
				foreach($allNavItems as $navItem){
					RenderMobileNavLI($navItem->title, $navItem->url);
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
				<h1 class="site-title logo"><a id="blogname" rel="home" href="<?=get_home_url()?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				</div>
				<div class="col-sm-9 mainmenu">
						<?php wp_nav_menu( array( 'container_id' => 'primary-menu-container', 'theme_location' => 'primary','container_class' => 'topmenu','menu_id'=>'primary-menu' ,'menu_class'=>'sfmenu' ) ); ?>
				</div>
		
			</div> <!-- end row -->
		</nav>	
	</header><!-- #masthead -->
	
	

	<div id="content" class="site-content ">
	