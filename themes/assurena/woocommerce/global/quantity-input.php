<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by StylusThemes Team.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden number-input">
		<span class="minus"></span>
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />	
		<span class="plus"></span>
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'assurena' ), strip_tags( $args['product_name'] ) ) : __( 'Quantity', 'assurena' );
	?>
	<div class="quantity number-input">
		<label class="label-qty" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'assurena' ); ?></label>
		<div class="quantity-wrapper">
			<span class="minus"></span>
			<input
				type="number"
				id="<?php echo esc_attr( $input_id ); ?>"
				class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
				step="<?php echo esc_attr( $step ); ?>"
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( $max_value > 0 ? $max_value : 999 ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'assurena' ); ?>"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				inputmode="<?php echo esc_attr( $inputmode ); ?>"/>
			<span class="plus"></span>
		</div>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}
