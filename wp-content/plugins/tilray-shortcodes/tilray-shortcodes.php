<?php
 
/*
Plugin Name: Tilray Shortcodes
Description: Adds some new shortcodes
Author: Kyall Barrows
Version: 1.0
*/

function render_svg_icon($icon_name){
	//"you should use sprintf"   --somebody who has time to google using sprintf
	$icon_url = get_stylesheet_directory_uri() . "/images/" . $icon_name . ".svg";
	return "<img class='svg' src='" . $icon_url . "'/>";
}

function icon_email_func(){	return render_svg_icon("icon_email");	}
function icon_pdf_func(){	return render_svg_icon("icon_pdf");}
function icon_phone_func(){	return render_svg_icon("icon_phone");}
function icon_user_func(){	return render_svg_icon("icon_user");}
function icon_ban_func(){	return render_svg_icon("icon_ban");}

function call_to_action_button_func($atts){
	$newTab = "target='_self'";
	if (isset($atts['target']) && $atts['target'] != "")
		$newTab = "target='" . $atts['target'] . "'";
		
	$classes = "";
	if (isset($atts['classes'])){
		$classes = $atts['classes'];
	}

	return sprintf('<a href="%s" %s class="call-to-action-button ' . $classes . '">%s<span>%s</span></a>', 
					$atts['href'],
					$newTab,
					render_svg_icon($atts['icon_name']),
					$atts['label']);
}

function icon_bullet_line_func($atts, $content = null){
	return sprintf('<div class="icon-bullet-line">%s<span class="icon-bullet-content">%s</span></div>', 
					render_svg_icon($atts['icon_name']),
					$content);
}


function reg_tilray_shortcodes(){
	add_shortcode( 'icon_email', 'icon_email_func' );
	add_shortcode( 'icon_pdf', 'icon_pdf_func' );
	add_shortcode( 'icon_phone', 'icon_phone_func' );
	add_shortcode( 'icon_user', 'icon_email_func' );
	add_shortcode( 'icon_ban', 'icon_ban_func' );
	add_shortcode( 'call_to_action_button', 'call_to_action_button_func' );
	add_shortcode( 'icon_bullet_line', 'icon_bullet_line_func' );
}

add_action( 'init', 'reg_tilray_shortcodes');

function render_svg_inliner_script()
{
?>
<script>
jQuery('img.svg').each(function(){
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');

    jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if(typeof imgID !== 'undefined') {
            $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if(typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Replace image with new SVG
        $img.replaceWith($svg);

    }, 'xml');

});
</script>
<?php
}

add_action('wp_footer', 'render_svg_inliner_script');