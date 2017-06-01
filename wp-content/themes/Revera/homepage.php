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
?>

<div class="container ">
<div class="row">
<?php
if (!$isMobile){
	get_template_part( 'inc/feature' );
}
?>
</div>
<div class="row homepage-points">
	<div class="col-sm-1 hidden-xs"></div>
	<div class="col-sm-10 col-xs-12">
		<?php
			$link1 = "/link1";
			$link2 = "/link2";
			$link3 = "/link3";
		?>
		<div class="row">
			<div class="col-sm-4 col-xs-12 homepage-point">
				<a href="<?= $link1 ?>"><img src='<?=get_template_directory_uri()?>/images/homeicon1.svg'></a>
				<a href="<?= $link1 ?>"><h2><?=_('GMP Certified')?></h2></a>
				<p><?=_('Lorem ipsum dolor sit amet, consectituer.')?></p>
			</div>
			<div class="col-sm-4 col-xs-12 homepage-point">
				<a href="<?= $link1 ?>"><img src='<?=get_template_directory_uri()?>/images/homeicon2.svg'></a>
				<a href="<?= $link1 ?>"><h2><?=_('Register')?></h2></a>
				<p><?=_('Lorem ipsum dolor sit amet, consectituer dipiscing eli.')?></p>
			</div>
			<div class="col-sm-4 col-xs-12 homepage-point">
				<a href="<?= $link1 ?>"><img src='<?=get_template_directory_uri()?>/images/homeicon3.svg'></a>
				<a href="<?= $link1 ?>"><h2><?=_('Customer Service')?></h2></a>
				<p><?=_('Lorem ipsum dolor sit amet, consectituer dipiscing.')?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-1 hidden-xs"></div>
</div>

<?php
	$langCode = get_current_language_code();
	$catName = 'news';
	if (strtolower($langCode) == "fr"){
		$catName = 'nouvelles';
	}
	$newsCategory = get_category_by_slug($catName);
?>
<div class="section-wide">
	<div class="row">
		<div class="homepage-blog-container">
			<?php
			$count = 1;
			if( have_rows('feature_sections', $post->ID) ){
				while( have_rows('feature_sections', $post->ID)){
					the_row();
					$left = $count % 2 == 0;
					$img_attrs = wp_get_attachment_image_src( get_sub_field('image'), 'large' ); 
					$image = $img_attrs[0];
					?>
						<div class="homepage-feature-section <?= $left ? "left" : "right" ?>">
							<?php if ($left){?>
								<div class="image"><img src="<?= $image ?>"></div>
							<?php } ?>
							<div class="content"><?=get_sub_field('content')?></div>
							<?php if (!$left){?>
								<div class="image"><img src="<?= $image ?>"></div>
							<?php } ?>
						</div>
					<?php

					$count++;
				}
			}
			?>
		</div>
	</div>
</div>
<div class="section-wide">
	<div class="row">
	<div class="boxitems col-lg-12 homepage-blog-container">
		<a href="/<?=strtolower($langCode)?>/<?=$catName?>">
		<h2 class="blog-section"><?=$newsCategory->name?></h2></a>
		 <?php 	
		 $numRendered = 0;
		if( have_rows('homepage_news_posts', 'options') ){
			while( have_rows('homepage_news_posts', 'options')){
				the_row();
				?>
				<div class="blog-post-preview col-sm-4">
					<?php
					$post_id = get_sub_field('news_posts');
					$image = get_image_url_from_image_id(get_sub_field('news_posts'), 'blog-preview');
					if($image) {?>
						<a href="<?php the_permalink($post_id); ?>" class="prevent-reflow">
							<img class="blog-preview" src="<?= $image ?>" alt="<?= get_the_title($post_id); ?>"/>
						</a>				
					<?php }?>
					<a href="<?php the_permalink($post_id); ?>"><h2><?= get_the_title($post_id); ?></h2></a>
					<p>
						<?php echo get_the_excerpt($post_id); ?>
						<a class="read-more-link" href="<?php the_permalink($post_id); ?>"><?= __('Read more') ?> &raquo;</a>
					</p>
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
	<div class="col-4">
	</div>
	
	</div>
</div>

</div>
</div> <!-- #page -->
<?php get_footer(); ?>

