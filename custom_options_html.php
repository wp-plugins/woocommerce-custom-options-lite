<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="woocommerce_product_option wc-metabox closed">
	<h3>
		<button type="button" class="remove_option button"><?php _e( 'Remove', 'custom-options' ); ?></button>
		<div class="handlediv" title="<?php _e( 'Click to toggle', 'custom-options' ); ?>"></div>
		<strong><?php _e( 'Option', 'custom-options' ); ?> <span class="group_name"><?php if ( $option['name'] ) echo '"' . esc_attr( $option['name'] ) . '"'; ?></span> &mdash; </strong>
		<select name="product_option_type[<?php echo $loop; ?>]" class="product_option_type">
			<option <?php selected('custom_field', $option['type']); ?> value="custom_field"><?php _e('Custom input (text field)', 'custom-options'); ?></option>
			<option <?php selected('custom_textarea', $option['type']); ?> value="custom_textarea"><?php _e('Custom input (text area)', 'custom-options'); ?></option>
		</select>
		<input type="hidden" name="product_option_position[<?php echo $loop; ?>]" class="product_option_position" value="<?php echo $loop; ?>" />
	</h3>
	<table cellpadding="0" cellspacing="0" class="wc-metabox-content">
		<tbody>
			<tr>
				<td class="option_name" width="50%">
					<label for="option_name_<?php echo $loop; ?>"><?php _e( 'Option Name', 'custom-options' ); ?></label>
					<input type="text" id="option_name_<?php echo $loop; ?>" name="product_option_name[<?php echo $loop; ?>]" value="<?php echo esc_attr( $option['name'] ) ?>" />
				</td>
				<td class="option_required" width="50%">
					<label for="option_required_<?php echo $loop; ?>"><?php _e( 'Required fields?', 'custom-options' ); ?></label>
					<input type="checkbox" id="option_required_<?php echo $loop; ?>" name="product_option_required[<?php echo $loop; ?>]" <?php checked( $option['required'], 1 ) ?> />
				</td>
			</tr>
			<tr>
				<td class="data" colspan="3">
					<table cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th><?php _e('Option Label', 'custom-options'); ?></th>
								<th class="price_column"><?php _e('Option Price', 'custom-options'); ?></th>
								<th class="minmax_column"><?php _e('Max', 'custom-options'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input class="clear_class<?php echo $loop; ?>" type="text" name="product_option_label[<?php echo $loop; ?>]" value="<?php echo esc_attr($option['label']) ?>" placeholder="<?php _e('Label', 'custom-options'); ?>" /></td>
								<td class="price_column"><input class="clear_class<?php echo $loop; ?>" type="text" name="product_option_price[<?php echo $loop; ?>]" value="<?php echo esc_attr( wc_format_localized_price( $option['price'] ) ); ?>" placeholder="0.00" class="wc_input_price" /></td>
								<td class="minmax_column"><input class="clear_class<?php echo $loop; ?>" type="number" name="product_option_max[<?php echo $loop; ?>]" value="<?php echo esc_attr( $option['max'] ) ?>" placeholder="N/A" min="0" step="any" /></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<style>
.product_option_type {

    margin-left: 10px !important;

}
.wc-metaboxes-wrapper .wc-metabox h3 strong {
    float: left;

}

</style>