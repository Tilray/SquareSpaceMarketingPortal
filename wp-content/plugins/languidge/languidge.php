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
    wp_nonce_field( basename( __FILE__ ), 'languidge_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );

	$lang = getLanguage($post->ID);
	if ($lang == 'en'){
		create_associated_page_selector($prfx_stored_meta, 'french', 'fr');
	}
	else if ($lang == 'fr'){
		create_associated_page_selector($prfx_stored_meta, 'english', 'en');
	}
	
}

function create_associated_page_selector($post_meta, $lang_name, $parent_slug){
?>
	<p>
		<label for="meta-associated-page-<?= $lang_name?>" class="prfx-row-title">Associated <?= $lang_name?> <?=get_post_type(get_the_ID())?></label>
		<select name="meta-associated-page" id="meta-associated-page">
		<?php
			$parentPage = get_page_by_path($parent_slug);
			$childPages = get_pages(array('child_of' => $parentPage->ID));
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
    $is_valid_nonce = ( isset( $_POST[ 'languidge_nonce' ] ) && wp_verify_nonce( $_POST[ 'languidge_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
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
	if ($thisPost->post_parent)
	{
		$parentPost = get_post($thisPost->post_parent);
		return $parentPost->post_name;
	}
	
	return "none set";
}


