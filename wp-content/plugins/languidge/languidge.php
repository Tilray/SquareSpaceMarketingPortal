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
    ?>
	<p>
		<span class="prfx-row-title">Language</span>
		<div class="prfx-row-content">
			<label for="meta-language-english">
				<input type="radio" name="meta-language" id="meta-language-english" value="english" <?php if ( isset ( $prfx_stored_meta['meta-language'] ) ) checked( $prfx_stored_meta['meta-language'][0], 'english' ); ?>>
				English
			</label>
			<label for="meta-language-french">
				<input type="radio" name="meta-language" id="meta-language-french" value="french" <?php if ( isset ( $prfx_stored_meta['meta-language'] ) ) checked( $prfx_stored_meta['meta-language'][0], 'french' ); ?>>
				French
			</label>
		</div>
	</p> 
	
    <?php
	
	create_associated_page_selector('english');
	create_associated_page_selector('french');
	
}

function create_associated_page_selector($lang_name){
?>
	<p>
		<label for="meta-associated-page-<?= $lang_name?>" class="prfx-row-title">Associated <?= $lang_name?> <?=get_post_type(get_the_ID())?></label>
		<select name="meta-select-associated-page-<?= $lang_name?>" id="meta-select-associated-page-<?= $lang_name?>">
		<?php 
			// The Query
			$queryLanguage = new WP_Query( "post_type=" . get_post_type(get_the_ID()) . "&meta_key=meta-language&meta_value=" . $lang_name . "&order=ASC" );

			// The Loop
			while ( $queryLanguage->have_posts() ) {
				$queryLanguage->the_post();
				$theID = get_the_ID();
				?>
			<option value="<?php echo $theID;?>" <?php if ( isset ( $prfx_stored_meta['meta-associated-page-'.$lang_name] ) ) selected( $prfx_stored_meta['meta-associated-page-'.$lang_name][0], $theID ); ?>><?php echo get_the_title() ?></option>';
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
 
	if( isset( $_POST[ 'meta-language' ] ) ) {
		update_post_meta( $post_id, 'meta-language', $_POST[ 'meta-language' ] );
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


