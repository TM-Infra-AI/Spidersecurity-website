<?php
/**
 * Show messages
 *
 * This template can be overridden by StylusThemes Team.
 *
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ) {
	return;
}

?>

<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-message assurena_module_message_box type_success wpb_animate_when_almost_visible wpb_right-to-left right-to-left wpb_start_animation animated"<?php echo wc_get_notice_data_attr( $message ); ?> role="alert"><div class="message_icon_wrap"><i class="message_icon "></i></div><div class="message_content"><div class="message_text"> <?php echo wc_kses_notice( $message ); ?></div></div></div>
<?php endforeach; ?>