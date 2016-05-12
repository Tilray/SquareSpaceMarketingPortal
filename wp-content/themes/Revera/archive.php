<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package web2feel
 */

get_header(); 

$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
$headerOpenTag = "<h1>";
$headerCloseTag = "</h1>";

if ($paged > 1)
{
    $headerOpenTag = "<h2 class='mockH1'>";
    $headerCloseTag = "</h2>";
}

?>

<div class="page-head">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
                <?php 
                    echo $headerOpenTag;
                
                    if ( is_category() ) :
                        single_cat_title();

                    elseif ( is_tag() ) :
                        single_tag_title();

                    elseif ( is_author() ) :
                        /* Queue the first post, that way we know
                         * what author we're dealing with (if that is the case).
                        */
                        the_post();
                        printf( __( 'Author: %s', 'web2feel' ), '<span class="vcard">' . get_the_author() . '</span>' );
                        /* Since we called the_post() above, we need to
                         * rewind the loop back to the beginning that way
                         * we can run the loop properly, in full.
                         */
                        rewind_posts();

                    elseif ( is_day() ) :
                        printf( __( 'Day: %s', 'web2feel' ), '<span>' . get_the_date() . '</span>' );

                    elseif ( is_month() ) :
                        printf( __( 'Month: %s', 'web2feel' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

                    elseif ( is_year() ) :
                        printf( __( 'Year: %s', 'web2feel' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

                    elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
                        _e( 'Asides', 'web2feel' );

                    elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
                        _e( 'Images', 'web2feel');

                    elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
                        _e( 'Videos', 'web2feel' );

                    elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
                        _e( 'Quotes', 'web2feel' );

                    elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
                        _e( 'Links', 'web2feel' );

                    else :
                        _e( 'Archives', 'web2feel' );

                    endif;
                
                    echo $headerCloseTag;
                ?>
			</div>
			
		</div>
	</div>
</div>

<div class="container">	
	<div class="row">
		<div id="secondary" class="col-sm-12">
		<?php
			$searchType = 'category_name';
			$searchValue = get_query_var('category_name');
			if (is_tag()){
				$searchType = 'tag';
				$searchValue = get_query_var('tag');
			}
		
			$page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
            $otherPage = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $paged = max($page, $otherPage);
			$args = array(
				$searchType => $searchValue,
				'posts_per_page' => '6',
				'paged' => $paged
			);
			render_news_section($args, true);
		?>
		</div><!-- #primary -->
	</div>
</div>
<?php get_footer(); ?>
</div> <!-- #page -->
