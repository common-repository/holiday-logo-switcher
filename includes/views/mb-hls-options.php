<?php
/**
 * Generated by the WordPress Meta Box generator
 * at http://jeremyhixon.com/tool/wordpress-meta-box-generator/
 */

function whls_options_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function whls_options_add_meta_box() {
	add_meta_box(
		'whls_options-logo-options',
		__( 'Logo options', 'whls_options' ),
		'whls_options_html',
		'holiday_logos',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'whls_options_add_meta_box' );

function whls_options_html( $post ) {
	/**
	 * Enqueue Datepicker + jQuery UI CSS
	 * https://www.designbyhn.se/adding-a-datepicker-to-a-wordpress-metabox/
	 */
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'jquery-ui-style', plugin_dir_url( __FILE__ ) . 'librairies/jquery-ui/jquery-ui.min.css', true);

	wp_nonce_field( '_whls_options_nonce', 'whls_options_nonce' ); ?>

	<script>
		jQuery( document ).ready( function( $ ) {
			$( '.hls_date' ).datepicker( { dateFormat : 'dd/mm/yy' } );
		});
	</script>

	<p>
		<label for="whls_options_from_date_"><?php _e( 'From (date)', 'whls_options' ); ?></label><br>
		<input type="text" name="whls_options_from_date_" class="hls_date" id="whls_options_from_date_" value="<?php echo whls_options_get_meta( 'whls_options_from_date_' ); ?>">
	</p>	<p>
		<label for="whls_options_to_date_"><?php _e( 'To (date)', 'whls_options' ); ?></label><br>
		<input type="text" name="whls_options_to_date_" class="hls_date" id="whls_options_to_date_" value="<?php echo whls_options_get_meta( 'whls_options_to_date_' ); ?>">
	</p>	<p>
		<label for="whls_options_image_alt"><?php _e( 'Image Alt', 'whls_options' ); ?></label><br>
		<input type="text" name="whls_options_image_alt" id="whls_options_image_alt" value="<?php echo whls_options_get_meta( 'whls_options_image_alt' ); ?>">
	</p><?php
}

function whls_options_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['whls_options_nonce'] ) || ! wp_verify_nonce( $_POST['whls_options_nonce'], '_whls_options_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['whls_options_from_date_'] ) )
		update_post_meta( $post_id, 'whls_options_from_date_', sanitize_text_field( $_POST['whls_options_from_date_'] ) );
	if ( isset( $_POST['whls_options_to_date_'] ) )
		update_post_meta( $post_id, 'whls_options_to_date_', sanitize_text_field( $_POST['whls_options_to_date_'] ) );
	if ( isset( $_POST['whls_options_image_alt'] ) )
		update_post_meta( $post_id, 'whls_options_image_alt', sanitize_text_field( $_POST['whls_options_image_alt'] ) );
}
add_action( 'save_post', 'whls_options_save' );

/*
	Usage: whls_options_get_meta( 'whls_options_from_date_' )
	Usage: whls_options_get_meta( 'whls_options_to_date_' )
	Usage: whls_options_get_meta( 'whls_options_image_alt' )
*/
