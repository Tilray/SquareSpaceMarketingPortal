<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 */
?>

	</div><!-- #content -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="site-info wrap row">
			<div id="copyright-footer-container" class="fcred col-12">
				Copyright &copy; Tilray, all rights reserved <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'copyright-footer','container_class' => 'copyright-footer','menu_id'=>'copyright-footer-menu' ,'menu_class'=>'copyright-footer' ) ); ?>
			</div>		

		</div><!-- .site-info -->
	</div>	
</footer><!-- #colophon .site-footer -->


<?php wp_footer(); ?>

</body>
</html>
