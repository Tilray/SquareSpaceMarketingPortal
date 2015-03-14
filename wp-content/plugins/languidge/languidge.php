<?php
 
/*
Plugin Name: Languidge
Description: Provides a way to associate posts in different languages with each other
Author: Kyall Barrows
Version: 1.0
*/

function add_language_meta() {
    add_meta_box( 'language_meta_language', 'Language Settings', 'add_language_callback', 'post' );
    add_meta_box( 'language_meta_language', 'Language Settings', 'add_language_callback', 'page' );
}

function add_language_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), "language_nonce" );
    $stored_meta = get_post_meta( $post->ID );

	$lang = getLanguage($post->ID);
	if ($lang == "fr"){
		create_associated_page_selector($post->post_type, $stored_meta, "english", "en");
	}
	else if ($lang == "en"){
		create_associated_page_selector($post->post_type, $stored_meta, "french", "fr");
	}
	
}

function create_associated_page_selector($post_type, $post_meta, $lang_name, $lang_slug){
?>
	<p>
		<label for="meta-associated-page-<?= $lang_name?>" class="prfx-row-title">Associated <?= $lang_name?> <?=get_post_type(get_the_ID())?></label>
		<select name="meta-associated-page" id="meta-associated-page">
		<?php
			$childPages = array();
			if ($post_type == 'post')
			{
				$childPages = get_posts(array('category_name' => $lang_slug));
				echo "found this many posts for " . $lang_slug . "   " . sizeof($childPages);
			}
			else {
				$parentPage = get_page_by_path($lang_slug);
				$childPages = get_pages(array('child_of' => $parentPage->ID));
			}
			foreach ( $childPages as $childPage ) {
				?>
			<option value="<?php echo $childPage->ID;?>" <?php if ( isset ( $post_meta['meta-associated-page'] ) ) selected( $post_meta['meta-associated-page'][0], $childPage->ID ); ?>><?php echo $childPage->post_title ?></option>';
				<?php
			}

			wp_reset_postdata();		
		?>
		</select>
	</p>	
	<?php
}

/**
 * Saves the custom meta input
 */
function language_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ "language_nonce" ] ) && wp_verify_nonce( $_POST[ "language_nonce" ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
	if( isset( $_POST[ 'meta-associated-page' ] ) ) {
		update_post_meta( $post_id, 'meta-associated-page', $_POST[ 'meta-associated-page' ] );
	} 
}
add_action( 'save_post', 'language_save' );

add_action( 'add_meta_boxes', 'add_language_meta' );

function getLanguage($postID)
{
	$thisPost = get_post($postID);
	if ($thisPost->post_type == 'post')
	{
		$categories = wp_get_post_categories( $postID );
		foreach ($categories as $category_id)
		{
			$cat = get_category( $category_id );
			$slug = $cat->slug;
			if ($slug === 'en' || $slug === 'fr')
			{
				return $cat->slug;
			}
		}
		return 'no lang set';
	}
	
	if ($thisPost->post_parent)
	{
		$parentPost = get_post($thisPost->post_parent);
		return $parentPost->post_name;
	}
	
	return "none set";
}


