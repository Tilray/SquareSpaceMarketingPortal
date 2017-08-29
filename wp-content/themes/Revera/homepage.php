<?php
/**
 * Template name:Homepage
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package web2feel
 */

header("Vary: User-Agent, Accept"); 

get_header(); ?>

<?php
	$postContent = $post->post_content;

	$langCode = strtolower(get_current_language_code());
?>

<div class="container ">
	<?php
	if (!$isMobile){
		get_template_part( 'inc/feature' );
	}
	?>
	<div class="container">
		<div class="row homepage-points">
			<div class="col-sm-1 hidden-xs"></div>
			<div class="col-sm-10 col-xs-12">
				<?php
					$link1 = "https://store.tilray.ca";
					$link2 = "https://customer.tilray.ca/en/Signup";
					$link3 = "/en/resources/ways-to-register/";

					if ($langCode == "fr"){
						$link2 = "https://customer.tilray.ca/fr/Signup";
						$link3 = "/fr/ressources/comment-sinscrire/";
					}
				?>
				<div class="row">
					<div class="col-sm-4 col-xs-12 homepage-point">
						<a href="<?= $link1 ?>"><img src='<?=get_template_directory_uri()?>/images/homeicon1.svg'><h2><?=__('Shop Now')?></h2></a>
						<p><?=__('Shop from our collection of GMP-certified medical cannabis')?></p>
					</div>
					<div class="col-sm-4 col-xs-12 homepage-point">
						<a href="<?= $link2 ?>"><img src='<?=get_template_directory_uri()?>/images/homeicon2.svg'><h2><?=__('Register')?></h2></a>
						<p><?=__('Become a Tilray customer')?></p>
					</div>
					<div class="col-sm-4 col-xs-12 homepage-point">
						<a href="<?= $link3 ?>"><img src='<?=get_template_directory_uri()?>/images/homeicon3.svg'><h2><?=__('Questions?')?></h2></a>
						<p><?=__('Contact our Patient Services team at 1-844-845-7291, available 24 hours a day, 7 days a week.')?></p>
					</div>
				</div>
			</div>
			<div class="col-sm-1 hidden-xs"></div>
		</div>
	</div>
	<?php
		$catName = 'news';
		if ($langCode == "fr"){
			$catName = 'nouvelles';
		}
		$newsCategory = get_category_by_slug($catName);
	?>
	<div class="section-wide">
		<div class="homepage-blog-container">
			<?php
			$count = 1;
			if( have_rows('feature_sections', $post->ID) ){
				while( have_rows('feature_sections', $post->ID)){
					the_row();
					$left = $count % 2 == 0;
					$img_attrs = wp_get_attachment_image_src( get_sub_field('image'), 'large' ); 
					$imagetag = '<img src="' . $img_attrs[0] . '">';
					$video_class = '';

					$youtube_id = get_sub_field('youtube_id');
					if (strlen($youtube_id)){
						$imagetag = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allowfullscreen></iframe>';
						$video_class = ' video-container';
					}
					?>
						<div class="homepage-feature-section <?= $left ? "left" : "right" ?>">
							<?php if ($left){?>
								<div class="image<?=$video_class?>"><?= $imagetag ?></div>
							<?php } ?>
							<div class="content"><?=get_sub_field('content')?></div>
							<?php if (!$left){?>
								<div class="image<?=$video_class?>"><?= $imagetag ?></div>
							<?php } ?>
						</div>
					<?php

					$count++;
				}
			}
			?>
		</div>
	</div>
	<div class="section-wide">
		<div class="boxitems homepage-blog-container">
			<a href="/<?=$langCode?>/<?=$catName?>">
				<h2 class="blog-section"><?=$newsCategory->name?></h2>
			</a>
			<div class='row'>
			 <?php 	
			 $numRendered = 0;
			if( have_rows('homepage_news_posts', 'options') ){
				while( have_rows('homepage_news_posts', 'options')){
					the_row();
					?>
					<div class="blog-post-preview col-sm-4 col-xs-12">
						<?php
						$post_id = get_sub_field('news_posts');
						render_single_news_post($post_id);
						?>
					</div>
					<?php 
					$numRendered++;
					if ($numRendered % 3 == 0){
						?>
						<div class="clearfix"></div></div><div class="col-sm-12">
						<?php
					}
				}

				$pageLink = '/en/news/';
				if (get_current_language_code() == "fr"){
					$pageLink = '/fr/nouvelles/';
				}
				?>
				<div class="navigation pagination-buttons"><p><a href="<?=$pageLink?>"><?=__('next')?>&nbsp;&nbsp;<i class="icon-right-big"></i></a></p></div>
				<?php
			}	
			else{
				?><h1>No news posts found</h1><?php
			}	
			?>
			</div>			 
		</div>
	</div>

</div>
</div> <!-- #page -->
<?php get_footer(); ?>

