jQuery( document ).ready( function($) {
	
	$(this).on( 'change', '.custom_field, .custom_textarea, input.qty', function() {

		show_options_final_total();
		
	});
	
	show_options_final_total();
	
	function show_options_final_total() {
	
		var option_total = 0;
		
		var product_price = $('#product-options-total').attr( 'product-price' );
		
		var product_total_price = 0;
		
		var final_total = 0;
		
		$('.custom-options').each( function() {
			
			var option_price = 0;
			
			option_price = $(this).attr('data-price');
			
			var value_entered =  $(this).val();
			
			if(value_entered != '' || option_price == 0)
			{
				option_total = parseFloat( option_total ) + parseFloat( option_price );
			}
			
		});
		
		//alert( option_total );
		
		var qty = $('.qty').val();
		
		if ( option_total > 0 && qty > 0 ) {
			
			option_total = parseFloat( option_total * qty );
			
			//alert( option_total );

			if ( product_price ) {

				product_total_price = parseFloat( product_price * qty );
				
				//alert( product_total_price );

			}
			
			//alert( option_total+product_total_price );
			final_total = option_total + product_total_price;

			html = '';
			
			if(woocommerce_custom_options_params.show_op == 1)
			{
				html = html + '<dl class="product-options-price"><dt> Options Total </dt><dd><strong><span class="amount">' + woocommerce_custom_options_params.currency_symbol+option_total + '</span></strong></dd>';
			}
			
			if ( final_total ) {
				
				if(woocommerce_custom_options_params.show_ft == 1)
				{
					html = html + '<dt>Final Total</dt><dd><strong><span class="amount">' + woocommerce_custom_options_params.currency_symbol+final_total + '</span></strong></dd>';
				}

			}

			html = html + '</dl>';

			$('#product-options-total').html( html );
				
		} else {
			
			$('#product-options-total').html( '' );
		}
	}	
		
});