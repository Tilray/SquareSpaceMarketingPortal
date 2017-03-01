<?php
/**
 * The Template for displaying all single posts.
 *
 * @package web2feel
 */

get_header();
<<<<<<< HEAD

$post_id = get_the_id();
wpb_set_post_views($post_id);

$count_key = 'wpb_post_views_count';
$count = get_post_meta($post_id, $count_key, true);
if($count==''){
    delete_post_meta($post_id, $count_key);
    add_post_meta($post_id, $count_key, '0');
}

function render_related_post($id){
    ?>
    <div id="post-<?= $id ?>">
    <a href="<?php the_permalink($id); ?>"><?php echo get_the_post_thumbnail($id, 'blog-preview'); ?></a>
    <h3><a href="<?php the_permalink($id); ?>"><?= get_the_title($id) ?></a></h3>
    </div>
    <?php
}

?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php while ( have_posts() ) : the_post(); ?>
				<h2 class="mockH1"><?=__('News')?></h2>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="row">
						<div class="content-area col-sm-8 col-xs-12">
							<?php
								$thumb = get_post_thumbnail_id();
								$img_url = wp_get_attachment_image_src( $thumb,'large' );
								if($img_url) : ?>
									<img class="img-responsive single-post-featured-image" src="<?php echo $img_url[0] ?>" alt="<?php the_title(); ?>"/>
							<?php endif; ?>
							<h1 class="mockH2"><?php the_title() ?></h1>
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
=======

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
>>>>>>> master
										{
											echo __("TAGGED") . "&nbsp;";
											$tags = [];
											foreach($allTags as $thisTag)
											{
												$tags[] = '<a href="' . get_tag_link( $thisTag->term_id ) . '">' . __($thisTag->name) . '</a>';
											}

											echo implode(", ", $tags);
										}
<<<<<<< HEAD

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
						<div class="col-sm-1 hidden-xs"></div>
						<div class="col-sm-3 col-xs-12 related">
                            <h2 class="related-posts"><?= _("You also may like") ?></h2>
							<?php
								$num_related_posts = 3;
                                $num_rendered_related_posts = 0;
                                $skip_post_ids = array($post_id);

								$tag_ids = array();
								$tags = wp_get_post_tags($post->ID);

                                if( have_rows('related_posts') ):
                                    // loop through the rows of data
                                    while ( have_rows('related_posts') ) : the_row();
                                        // display a sub field value
                                        $pid = get_sub_field('related_post');
                                        render_related_post($pid);
                                        $skip_post_ids[] = $pid;
                                        $num_rendered_related_posts++;
                                    endwhile;
                                endif;

								for ($i = 0; $i < count($tags); $i++){
									$tag_ids[] = $tags[$i]->term_id;
								}

								if (count($tag_ids) > 0){
									$query = new WP_Query( array( 'post__not_in' => $skip_post_ids, 'tag__in' => $tag_ids, 'posts_per_page' => $num_related_posts ) );
									while($query->have_posts() && $num_rendered_related_posts < $num_related_posts) : $query->the_post();
                                        $num_rendered_related_posts++;
                                        $skip_post_ids[] = get_the_ID();
                                        render_related_post(get_the_ID());
									endwhile;
								}

                                $args = array(
                                    'post__not_in' => $skip_post_ids,
                                    'post_type' => 'post',
                                    'orderby'   => 'meta_value_num',
                                    'meta_key'  => 'wpb_post_views_count',
                                    'order'     => 'DESC',
                                    'posts_per_page'    => '3',
                                );
                                $query = new WP_Query( $args );

                                if ($query->have_posts()){
                                    $posts = $query->get_posts();
                                    foreach($posts as $post){
                                        if ($num_rendered_related_posts >= $num_related_posts)
                                            break;

                                        $num_rendered_related_posts;
                                        render_related_post($post->ID);
                                    }
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
<?php

    get_footer();
?>
=======
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
							</div><!-- #primary   comments -->
						</article><!-- #post-## -->
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
>>>>>>> master
