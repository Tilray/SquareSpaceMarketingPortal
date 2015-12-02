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
				<h1><?=__('News')?></h1>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h2><?php the_title() ?></h2>
					<div class="col-sm-4">
						<?php
							$thumb = get_post_thumbnail_id();
							$img_url = wp_get_attachment_image_src( $thumb,'blog-featured-image' );
							if($img_url) : ?>
						<img class="img-responsive single-post-featured-image" src="<?php echo $img_url[0] ?>"/>
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
							$disableDisqus = trim(ft_of_get_option('fabthemes_disable_disqus'));
							if (comments_open() && $disableDisqus != "0") : 
						?>
						<div id="disqus_thread"></div>
						<script>
							/**
							 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
							 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
							 */
							/*
							var disqus_config = function () {
								this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
								this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
							};
							*/
							(function() {  // DON'T EDIT BELOW THIS LINE
								var d = document, s = d.createElement('script');
								
								s.src = '//EXAMPLE.disqus.com/embed.js';
								
								s.setAttribute('data-timestamp', +new Date());
								(d.head || d.body).appendChild(s);
							})();
						</script>
						<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
						<?php endif; // comments_open ?>						
					</div><!-- #primary   comments -->
				</article><!-- #post-## -->
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>