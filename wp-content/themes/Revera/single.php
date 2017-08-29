<?php
/**
 * The Template for displaying all single posts.
 *
 * @package web2feel
 */

get_header();

$post_id = get_the_id();
wpb_set_post_views($post_id);

$count_key = 'wpb_post_views_count';
$count = get_post_meta($post_id, $count_key, true);
if($count==''){
    delete_post_meta($post_id, $count_key);
    add_post_meta($post_id, $count_key, '0');
}

echo "<div data-count='" . $count . "'></div>";

?>

	<div class="page-head">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php while ( have_posts() ) : the_post(); ?>
						<h2 class="mockH1"><?=__('News')?></h2>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<h1 class="mockH2"><?php the_title() ?></h1>
							<div class="col-sm-4">
								<?php
								$thumb = get_post_thumbnail_id();
								$img_url = wp_get_attachment_image_src( $thumb,'blog-featured-image' );
								if($img_url) : ?>
									<img class="img-responsive single-post-featured-image" src="<?php echo $img_url[0] ?>" alt="<?php the_title(); ?>"/>
								<?php endif; ?>
							</div>
							<div id="primary" class="content-area col-sm-8">
								<main id="main" class="site-main" role="main">
									<div class="entry-content">
										<?php the_content(); ?>
									</div><!-- .entry-content -->
								</main><!-- #main -->
								<div class="buttons-container">
									<?php
									$disableSocial = trim(ft_of_get_option('fabthemes_disable_social_sharing'));
									if ($disableSocial != "0"){
										?>
										<div class="social-buttons">
											<?php render_social_buttons(get_permalink(), wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0], get_the_title()); ?>
										</div>
									<?php } ?>
									<div class="tags">
										<?
										$allTags = wp_get_post_tags(get_the_ID());
										if (count($allTags) > 0)
										{
											echo __("TAGGED") . "&nbsp;";
											$tags = [];
											foreach($allTags as $thisTag)
											{
												$tags[] = '<a href="' . get_tag_link( $thisTag->term_id ) . '">' . __($thisTag->name) . '</a>';
											}

											echo implode(", ", $tags);
										}
										?>
									</div>
								</div>
								<?php
								$global_disqus_enabled = (get_field('use_disqus', 'options')[0] == "enabled");

								if (!isset($_GET['nodisqus'])) :
									if (comments_open() && $global_disqus_enabled) : 
									?>
										<div id="disqus_thread"></div>
										<script>
											var disqus_config = function () {
												this.page.url = "<?= get_permalink()?>";
												this.page.identifier = "<?=str_replace(" ", "_", get_the_title())?>";
											};
											(function() {
												var d = document, s = d.createElement('script');
												s.src = '//tilray.disqus.com/embed.js';
												s.setAttribute('data-timestamp', +new Date());
												(d.head || d.body).appendChild(s);
											})();
										</script>
										<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
									<?php 

									else : 
										$related_posts = get_random_related_posts($post_id, 3);
										?>
										<div class="row">
											<?php
											for ($i = 0; $i < count($related_posts); $i++) {
												?>
												<div class="blog-post-preview col-sm-6 col-md-4">
													<?php
													$related_id = $related_posts[$i];
													$thumbID = get_post_thumbnail_id($related_id);
													$img_attrs = wp_get_attachment_image_src( $thumbID,'blog-preview' ); 
													$image = $img_attrs[0];
													if($image) {?>
														<a href="<?= get_permalink($related_id) ?>" class="prevent-reflow">
															<img class="blog-preview" src="<?= $image ?>" alt="<?php the_title(); ?>"/>
														</a>				
													<?php }?>
													<h2><a href="<?= get_permalink($related_id) ?>"><?= get_the_title($related_id) ?></a></h2>
												</div>
												<?php 
											}
											?>
										</div>
										<?php 
									endif; 
								endif;	//!isset disqus 
								?>
							</div><!-- #primary   comments -->
						</article><!-- #post-## -->
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>