<?php
/**
 * The template for the Tilray Process page
 *
  Template name:Process  
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

div.layout-left{
	width: 55%;
	position: relative;
	float: left;
}
div.layout-right{
	margin-left: 10%;
	width: 35%;
	float: right;
}

div.process-diagram{
width: 100%;
padding: 7%;
background-repeat: no-repeat;
background-size: contain;
position:relative;
}

div.process-map{
margin-left: 5%;
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

div.process-galleries{
}

div.process-galleries img{
	margin-bottom: 30px;
	margin-bottom: 30px;
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
display: none;
-webkit-transition: opacity 1s;
-moz-transition: opacity 1s;
transition: opacity 1s;
}
div.process-galleries div.gallery-container.active,
div.process-map img.layer.active{
display: block;
-webkit-transition: opacity 1s;
-moz-transition: opacity 1s;
transition: opacity 1s;
}
div.process-map img.layer{
	position: absolute;
	top: 0;
}

div.process-steps-background{}

div.process-steps-foreground
{
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
}
div.process-steps-foreground img{
	opacity: 0;
}
div.process-steps-foreground a{
	cursor: pointer;
}
div.process-steps-foreground img.active,
div.process-steps-foreground img:hover{
	opacity: 1;
}
</style>

<?php
function makeProcessStep($stepName, $layerIndex, $showBlueVersion){
	$blue = "";
	if ($showBlueVersion){
		$blue = "_blue";
	}
	echo "<a onClick='showLayer(" . $layerIndex . ")' onMouseOver='showBlue(this)' onMouseOut='showGray(this)'>";
	echo "<img class='layer step" . $layerIndex . "' style='width:12.5%' src='" . get_bloginfo('template_directory') . "/images/process/" . $stepName . $blue . ".png'/>";
	echo "</a>";
}

function makeProcessGallery($stepName, $stepNumber, $numImages)
{
	$text = get_field('step_'. $stepNumber . '_text');
	$images = get_field('step_'. $stepNumber . '_images');
	?>
	<div class="gallery-container layer step<?=$stepNumber?>">
		<p>
		<?=$text?>
		</p>
	<?php
	foreach($images as $img)
	{
		?>
		<img src='<?=$img['url']?>'/>
		<?php
	}
	?>
	</div>
	<?php
}

function makeMapLayer($stepNumber){
	$image = get_field('step_'. $stepNumber . '_map');
	?>
		<img class="step<?=$stepNumber?> layer" src='<?=$image?>'/>
	<?php
}
?>

	<div class="layout-left">
		<div class="process-steps-container">
			<div class="process-steps-background">
			<?php
				makeProcessStep('mother', 1, false);
				makeProcessStep('clone', 2, false);
				makeProcessStep('flower', 3, false);
				makeProcessStep('cure', 4, false);
				makeProcessStep('trim', 5, false);
				makeProcessStep('analyze', 6, false);
				makeProcessStep('package', 7, false);
				makeProcessStep('ship', 8, false);
			?>
			</div>
			<div class="process-steps-foreground">
			<?php
				makeProcessStep('mother', 1, true);
				makeProcessStep('clone', 2, true);
				makeProcessStep('flower', 3, true);
				makeProcessStep('cure', 4, true);
				makeProcessStep('trim', 5, true);
				makeProcessStep('analyze', 6, true);
				makeProcessStep('package', 7, true);
				makeProcessStep('ship', 8, true);
			?>
			</div>
		</div>
		<div class="process-galleries">
		<?php
			makeProcessGallery('mother', 1, 2);
			makeProcessGallery('clone', 2, 3);
			makeProcessGallery('flower', 3, 3);
			makeProcessGallery('cure', 4, 2);
			makeProcessGallery('trim', 5, 2);
			makeProcessGallery('analyze', 6, 2);
			makeProcessGallery('package', 7, 2);
			makeProcessGallery('ship', 8, 2);
		?>
		</div>
	</div>
	<div class="layout-right">
		<div class="layer-containers">
			<div class="process-map">
			<?php
			$image = get_field('step_1_map');
			?>
				<img class="base" src='<?=$image?>'/>
			<?php			
			for ($i = 1; $i <= 8; $i++)
			{
				makeMapLayer($i);
			}
			?>
			</div>
		</div>			
	</div>
</div>
<?php the_content(); ?>
		</main><!-- #main -->
	</div><!-- #primary -->
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
jQuery(".step" + layerId).addClass("active");
}

showLayer(1);
</script>

</div> <!-- #page -->
<?php get_footer(); ?>

