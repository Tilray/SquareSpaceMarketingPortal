<?php
/**
 * The template for the Tilray Process page
 *
  Template name:Mobile Clinic  
 */

get_header(); ?>

<style>

h4 {
	color: #858585;
	font-size: 15px;
	text-transform: uppercase;
	margin-top: 0;
}

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

div.province-date.layer{
display: none;
-webkit-transition: opacity 1s;
-moz-transition: opacity 1s;
transition: opacity 1s;
}
div.province-date.layer.active{
display: block;
-webkit-transition: opacity 1s;
-moz-transition: opacity 1s;
transition: opacity 1s;
}
div.process-map img.layer{
	position: absolute;
	top: 0;
}

div.provinces-list a{
	cursor: pointer;
}

div.provinces-list a h3{
	margin-top: 0;
	color: #858585;
}

div.provinces-list a.active h3,
div.provinces-list a:hover h3{
	color: 	#084875;
}

div.provinces-list a.active h3::after{
	content: ' »';
}

div.find-us-heading{
	margin-bottom: 20px;
}


div.fsBody.fsEmbed {
	padding: 0;
}

div.fsBody.fsEmbed form{
	padding: 0;
}

div.fsBody.fsEmbed form div.fsPage,
div.fsBody.fsEmbed form div.fsSubmit{
	padding: 0;
	max-width: 700px;
	text-align: left;
}

div.fb-image{
	display: inline-block;
	width: 50%;
	padding: 10px;
	float: left;
}
div.fb-image img{
}


</style>

<?php
function makeProvinceSelector($provinceName, $layerIndex){
	echo "<a onClick='showLayer(" . $layerIndex . ")' class='layer step". $layerIndex . "'>";
	echo "	<h3 class='province-selector'>" . _($provinceName) . "</h3>";
	echo "</a>";
}

function makeProvinceDates($provinceId, $stepNumber)
{
	$text = get_field($provinceId . '_dates');
	?>
	<div class="province-date layer step<?=$stepNumber?>">
		<?=$text?>
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

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12 page-page">
				<h1> <?php the_title(); ?> </h1>
				<?php
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_image_src( $thumb,'page-width' );
					if($img_url) : ?>
						<img class="img-responsive single-post-featured-image" src="<?php echo $img_url[0] ?>"/>
				<?php endif; ?>						
				<p><?php the_content(); ?></p>
			</div>
		</div>
	</div>
</div>
<div class="container">	
	<div class="row">
		<div id="primary" class="content-area col-12">
			<main id="main" class="site-main" role="main">
				<div class="row">
					<div class="col-sm-7">
						<div class="row">
							<div class="col-sm-12 find-us-heading">
								<h2><?=_('Find us in your area') ?></h2>
								<h4><?=_('Select your province to see dates and locations')?></h4>
							</div>
							<div class="col-sm-5 provinces-list">
								<?php
									makeProvinceSelector('Ontario', 1);
									makeProvinceSelector('Quebec', 2);
									makeProvinceSelector('Nova Scotia', 3);
									makeProvinceSelector('New Brunswick', 4);
									makeProvinceSelector('Manitoba', 5);
									makeProvinceSelector('British Columbia', 6);
									makeProvinceSelector('Prince Edward Island', 7);
									makeProvinceSelector('Saskatchewan', 8);
									makeProvinceSelector('Alberta', 9);
									makeProvinceSelector('Newfoundland & Labrador', 10);
								?>
							</div>
							<div class="col-sm-7">
								<?php
									makeProvinceDates('ontario', 1);
									makeProvinceDates('quebec', 2);
									makeProvinceDates('nova_scotia', 3);
									makeProvinceDates('new_brunswick', 4);
									makeProvinceDates('manitoba', 5);
									makeProvinceDates('british_columbia', 6);
									makeProvinceDates('prince_edward_island', 7);
									makeProvinceDates('saskatchewan', 8);
									makeProvinceDates('alberta', 9);
									makeProvinceDates('newfoundland_and_labrador', 10);
								?>
							</div>
						</div><!-- row-->
					</div><!-- sm-7 -->
					<div class="col-sm-1">
					</div>
					<div class="col-sm-4">
						<div id="facebook-feed">
							<?php
								$galleryImages = get_field('facebook_gallery');
								//useful elements: src, width, height, link 
								for ($i = 0; $i < 8 || $i < count($galleryImages); $i++){
									?><div class="fb-image"><a target="blank" href="<?=$galleryImages[$i]['link']?>"><img src='<?= $galleryImages[0]['src'] ?>' /></a></div><?php
								}
							?>
						</div>
						<?php
							echo get_field('twitter_widget');
						?>
					</div>
				</div><!-- row -->
				<div class="row">
					<div class="col-sm-12 formstackContainer">
						<h1><?= _('Want more information?')?></h1>
						<?php echo get_field('formcraft_embed_code'); ?>
						<script>
							var $formElement = jQuery('div.fsBody.fsEmbed');
							if ($formElement)
								jQuery($formElement).appendTo('div.formstackContainer');
						</script>
					</div>
				</div>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- row -->
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

showLayer(0);

Galleria.loadTheme('js/galleria/themes/classic/galleria.classic.min.js');
Galleria.run('#galleria', {
 facebook: 'album:291489504249941',
 width: 745,
 height: 550,
 lightbox: true,
 facebookOptions: {
   max: 30, // optional override for limit of 40 photos on an album
   facebook_access_token: 'YOUR_ACCESS_TOKEN_FROM_STEP_2'
 }
});
</script>

<?php get_footer(); ?>
</div> <!-- #page -->

