jQuery( document ).ready( function($) {
	
	$(this).on( 'change', '.custom_field, .custom_textarea, input.qty', function() {
		
		$(this).trigger( 'show_options_final_total' );
		
	});
	
	(function(){
		
	 $(this).trigger( 'show_options_final_total' );
			
	})();
	
	$(this).on( 'found_variation', function( event, variation ) {
			
			var $variation_form = $(this);
			
			var $totals         = $variation_form.find( '#product-options-total' );

			if ( $( variation.price_html ).find('.amount:last').size() ) {
		 		product_price = $( variation.price_html ).find('.amount:last').text();
				product_price = product_price.replace( woocommerce_custom_options_params.thousand_separator, '' );
				product_price = product_price.replace( woocommerce_custom_options_params.decimal_separator, '.' );
				product_price = product_price.replace(/[^0-9\.]/g, '');
				product_price = parseFloat( product_price );

				$totals.data( 'product-price', product_price );
			}
			
			$variation_form.trigger( 'show_options_final_total' );
	} );
	
	$(this).on( 'show_options_final_total', function() {
	
		var option_total = 0;

		var product_price = $(this).find( '#product-options-total' ).data( 'product-price' );
		
		//alert(typeof product_price);
		if(typeof product_price == 'undefined' )
		{
			var product_price = $( '#product-options-total' ).attr( 'product-price' );
		}
		
		product_price = parseFloat( product_price ); 
		
		//alert(product_price);
		
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
			
			option_total = option_total * qty;
			
			option_total = option_total.toFixed(2); 
			
			option_total = parseFloat( option_total ); 
			
			//console.log( product_price );

			if ( product_price ) {

				product_total_price = product_price * qty;
				
				product_total_price = product_total_price.toFixed(2); 
				
				product_total_price = parseFloat( product_total_price ); 
				
				//alert( product_total_price );

			}
			
			//alert( option_total+'--'+product_price );
			
			final_total = option_total + product_total_price;
			
			final_total = final_total.toFixed(2); 
			
			//alert( final_total );

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
		
	});

	$(this).find( '.variations select' ).change();
	
});