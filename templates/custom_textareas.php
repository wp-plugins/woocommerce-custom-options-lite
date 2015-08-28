<?php
$required = $options['required'];

if($options['price'] != 0)
{
	$price = ':- ('.woocommerce_price( $options['price'] ).')';
}
else
{
	$price = '';
}

$entered_data = $_POST['custom-options'][sanitize_title( $options['name'] )];
?>

<p class="form-row form-row-wide custom_<?php echo sanitize_title( $options['name'] ); ?>">
	<?php if ( ! empty( $options['label'] ) ) : ?>
		<label><?php echo wptexturize( $options['label'] ) . ' ' . $price;
		if($required == 1)
		{
			?>
				<abbr title="required" class="required">*</abbr>
			<?php
		}
		?>
		</label>
	<?php endif; ?>
	<textarea class="input-text custom-options custom_textarea" data-price="<?php echo $options['price']; ?>" name="custom-options[<?php echo sanitize_title( $options['name'] ); ?>]"  <?php if ( ! empty( $options['max'] ) ) echo 'maxlength="' . $options['max'] .'"'; ?> ><?php if( ! empty($entered_data) ){ echo $entered_data; } ?></textarea>
</p>