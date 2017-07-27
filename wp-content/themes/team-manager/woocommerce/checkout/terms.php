<?php
/**
 * Checkout terms and conditions checkbox
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$terms_page_id = wc_get_page_id( 'terms' );

if ( $terms_page_id > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) :
	$terms         = get_post( $terms_page_id );
	$terms_content = wc_format_content( $terms->post_content );
	?>
	<?php
		do_action( 'woocommerce_checkout_before_terms_and_conditions' );
		echo '<div class="woocommerce-terms-and-conditions" style="display: none; max-height: 200px; overflow: auto;">' . $terms_content . '</div>';
	?>
	<p class="form-row terms wc-terms-and-conditions">
		<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" onclick="activateButton()" id="terms-checkbox" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" /> <span><?php printf( __( 'Ich akzeptiere die <a href="http://www.handball-team-manager.de/wp-content/uploads/LIZENZBEDINGUNGEN.pdf" target="_blank">Lizenzbedingungen</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span> <span class="required">*</span>
		<input type="hidden" name="terms-field" value="1" />
	</p>
	<script>
		function activateButton(){
			if(document.getElementById("terms-checkbox").checked){
				document.getElementById("place_order").disabled = false;
			} else {
				document.getElementById("place_order").disabled = true;
			}
		}
	</script>
	<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>
<?php endif; ?>
