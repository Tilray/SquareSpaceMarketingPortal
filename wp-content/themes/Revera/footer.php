<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 */

global $deviceType;
$mobileClass = "";

if ($deviceType === 'phone')
    $mobileClass = " mobile";

?>

	</div><!-- #content -->
<footer id="colophon" class="site-footer<?=$mobileClass?>" role="contentinfo">
    <?php
    global $stickyFooterContent;
    if($stickyFooterContent){
        ?>
        <div class="sticky-footer-content">
            <?=$stickyFooterContent?>
        </div><?php
    }
    ?>
    <div class="color-wrapper">
    	<div class="container primary">
            <div class="collapse-container">
                <div class="site-info wrap row">
                    <div id="copyright-footer-container device-type" class="fcred col-lg-12">
                        &copy; <?=date("Y")?> <?php _e('Tilray, all rights reserved'); ?> <?php 
                            if ($deviceType === 'phone')
                            {
                                wp_nav_menu( array( 'container' => '', 'theme_location' => 'copyright-footer-mobile','container_class' => 'copyright-footer','menu_id'=>'copyright-footer-menu' ,'menu_class'=>'copyright-footer' ) );
                            }
                            else
                            {
                                wp_nav_menu( array( 'container' => '', 'theme_location' => 'copyright-footer','container_class' => 'copyright-footer','menu_id'=>'copyright-footer-menu' ,'menu_class'=>'copyright-footer' ) );
                            }
                            ?>
                    </div>		
                </div>
            </div>
    	</div>	
    </div>
</footer>


<?php wp_footer(); ?>

</body>
</html>
