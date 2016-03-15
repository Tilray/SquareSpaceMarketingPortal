<?php
/**
  Template name:Wide
 */

get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12 page-page">
				<h1> <?php the_title(); ?> </h1>
				<p> </p>
			</div>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">
	<div id="primary" class="content-area col-12">
		<main id="main" class="site-main" role="main">

<style>
div.process-diagram{
width: 80%;
padding: 7%;
margin-left: 10%;
background-repeat: no-repeat;
background-size: contain;
position:relative;
}

div.process-diagram div{
width:12.5%; 
height:100%; 
position: absolute;
top: 0;
background-image:url(http://tilray.staging.wpengine.com/wp-content/themes/Revera/images/process-diagram-grey.png);
background-size: 800%;
}

div.process-diagram div.layer.active,
div.process-diagram div:hover{
background-image:url(http://tilray.staging.wpengine.com/wp-content/themes/Revera/images/process-diagram.png);
}

div.process-diagram div a {
display:block;
width:100%;
height:100%;
cursor: pointer;
}

div.process-diagram .image {
width: 100%;
padding: 9%;
position:relative;
}

div.image-thumbs{
position: relative;
height: 140px;
}
div.image-thumbs div{
width:12.5%; 
height:100%; 
position: absolute;
top: 0;
}

div.layers-container{
	position: relative;
}

div.process-map{
	float: left;
	width: 44%;
}

div.process-galleries{
	width: 44%;
	margin-left: 10%;
	float: right;
}

div.process-galleries,
div.process-map{
position: relative;
}

div.process-galleries div.gallery-container,
div.process-map img{
width: 100%;
}

div.process-galleries div.gallery-container,
div.process-map img.layer{
position: absolute;
opacity: 0;
top: 0px;
-webkit-transition: opacity 1s;
-moz-transition: opacity 1s;
transition: opacity 1s;
}
div.process-galleries div.gallery-container.active,
div.process-map img.layer.active{
opacity: 1;
-webkit-transition: opacity 1s;
-moz-transition: opacity 1s;
transition: opacity 1s;
}

</style>


<div class="process-diagram">
<div class="layer chip1" style="left:0%; background-position-x: 0;"><a onClick="showLayer(1)"></a></div>
<div class="layer chip2" style="left:12.5%; background-position-x: -100%;"><a onClick="showLayer(2)"></a></div>
<div class="layer chip3" style="left:25%;  background-position-x: -200%;"><a onClick="showLayer(3)"></a></div>
<div class="layer chip4" style="left:37.5%; background-position-x: -300%;"><a onClick="showLayer(4)"></a></div>
<div class="layer chip5" style="left:50%; background-position-x: -400%;"><a onClick="showLayer(5)"></a></div>
<div class="layer chip6" style="left:62.5%; background-position-x: -500%;"><a onClick="showLayer(6)"></a></div>
<div class="layer chip7" style="left:75%; background-position-x: -600%;"><a onClick="showLayer(7)"></a></div>
<div class="layer chip8" style="left:87.5%; background-position-x: -700%;"><a onClick="showLayer(8)"></a></div>
</div>
<br><br>

<div class="layer-containers">
	<div class="process-map">
	<img src="<?php bloginfo('template_directory');?>/images/ProcessMap.png" class="base"/>
	<img class="process-layer1 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay1.png"/>
	<img class="process-layer2 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay2.png"/>
	<img class="process-layer3 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay3.png"/>
	<img class="process-layer4 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay4.png"/>
	<img class="process-layer5 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay5.png"/>
	<img class="process-layer6 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay6.png"/>
	<img class="process-layer7 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay7.png"/>
	<img class="process-layer8 layer" src="<?php bloginfo('template_directory');?>/images/ProcessOverlay8.png"/>
	</div>
	<div class="process-galleries">
	<?php
	for($step = 1; $step <= 8; $step++)
	{
		$images = get_field('step_'. $step . '_images');
		?>
		<div class="flexslider gallery-container layer gallery<?=$step?>">
			<ul class="slides"><?php
				foreach($images as $img){
					?>
					<li data-thumb='<?=$img['sizes']['thumbnail']?>'><img src='<?=$img['url']?>'/></li>
					<?php
				}
			?>
			</ul>
		</div><?php
	}
	?>
	</div>
</div>			

		</main><!-- #main -->
	</div><!-- #primary -->

	</div>
</div>
<?php get_footer(); ?>
</div><!-- #page -->
<script>
jQuery(window).load(function() {
  jQuery('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});

function showLayer(layerId){
jQuery(".layer").removeClass("active");
jQuery(".chip" + layerId).addClass("active");
jQuery(".process-layer" + layerId).addClass("active");
jQuery(".gallery" + layerId).addClass("active");
}

showLayer(1);
</script>