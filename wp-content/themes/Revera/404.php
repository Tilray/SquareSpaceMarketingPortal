<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package web2feel
 */

get_header(); ?>
<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1> 404 </h1>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">

	<div id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="pages-header">
					<h1 class="page-title"><?php _e( 'That page can&rsquo;t be found.', 'web2feel' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php echo get_field('the_404_page_content', 'options'); ?></p>
					<p>
						<form method="get" id="search-form" class="search-404" action="<?php echo get_search_page_url(); ?>">
							<label>
								<span class="screen-reader-text">Search for:</span>
								<input type="search" class="search-field" placeholder="" value="" name="term" title="Search for:">
							</label>
							<button type="submit" class="search-submit">
								<i class="icon-search"></i>
							</button>
							<input type="hidden" name="lang" value="en"></form>                            
						</form>
					</p>

					<div class="more-content">
						<h3>More from Tilray</h3>
						<div class="row">
						<?php
							$post1 = get_field('the_404_page_post_1', 'options');
							$post2 = get_field('the_404_page_post_2', 'options');

							if ($post1){
								?><div class="blog-post-preview col-sm-6 col-md-4"><?php
									render_single_news_post($post1->ID);
								?></div><?php
							}

							if ($post2){
								?><div class="blog-post-preview col-sm-6 col-md-4"><?php
									render_single_news_post($post2->ID);								
								?></div><?php
							}
						?>
						</div>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
	</div>
</div>
<?php get_footer(); ?>