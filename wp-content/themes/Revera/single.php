<?php
/**
 * The Template for displaying all single posts.
 *
 * @package web2feel
 */

get_header(); ?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php while ( have_posts() ) : the_post(); ?>
				<h2 class="mockH1"><?=__('News')?></h2>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="mockH2"><?php the_title() ?></h1>
					<div class="row">
						<div class="content-area col-sm-8 col-xs-12">
							<?php
								$thumb = get_post_thumbnail_id();
								$img_url = wp_get_attachment_image_src( $thumb,'large' );
								if($img_url) : ?>
									<img class="img-responsive single-post-featured-image" src="<?php echo $img_url[0] ?>" alt="<?php the_title(); ?>"/>
							<?php endif; ?>
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
							$disableDisqus = trim(ft_of_get_option('fabthemes_disable_disqus'));
							if (comments_open() && $disableDisqus != "0") :
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
							<?php endif; // comments_open ?>
						</div>
						<div id="primary" class="col-sm-1 hidden-xs"></div>
						<div id="primary" class="col-sm-3 col-xs-12 related">
							<?php
								$num_related_posts = 3;
								$tag_ids = array();
								$tags = wp_get_post_tags($post->ID);

								for ($i = 0; $i < count($tags); $i++){
									$tag_ids[] = $tags[$i]->term_id;
								}

								if (count($tag_ids) > 0){
									$query = new WP_Query( array( 'tag__in' => $tag_ids, 'posts_per_page' => $num_related_posts ) );
									while($query->have_posts()) : $query->the_post(); ?>

										<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
											<?php the_post_thumbnail('blog-preview'); ?>
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										</div>

									<?php endwhile;
								}
							?>
						</div><!-- #primary   comments -->
					</div>
				</article><!-- #post-## -->
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>