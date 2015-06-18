<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

		$woo_custom_option_plugin =  get_option( 'woo_custom_option_plugin' );

		if($woo_custom_option_plugin == 1) {
			
			add_filter( 'woocommerce_add_cart_item',  'add_cart_item' , 20, 1 );

			// Load cart data per page load
			add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_item_from_session' , 20, 2 );

			// Get item data to display
			add_filter( 'woocommerce_get_item_data',  'get_item_data' , 10, 2 );

			// Add item data to the cart
			add_filter( 'woocommerce_add_cart_item_data',  'add_to_cart_product' , 10, 2 );

			// Validate when adding to cart
			add_filter( 'woocommerce_add_to_cart_validation',  'validate_add_cart_product' , 10, 3 );

			// Add meta to order
			add_action( 'woocommerce_add_order_item_meta',  'order_item_meta' , 10, 2 );
		
		}
		
		add_action('admin_menu', 'register_custom_options_submenu_page',99);
		
		function register_custom_options_submenu_page() {
		
			add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, custom_Options_plugin_dir_url.'/images/logo-wp.png', 57 );
        
			add_submenu_page( 'phoeniixx', 'Custom Options', 'Custom Options', 'manage_options', 'custom_options_setting', 'custom_options_setting' ); 
		
		}
		
		function custom_options_setting() {
			
			if($_POST['submit']) {
				
				$checkco = $_POST['checkco'];
				
				$showot = $_POST['showot'];
				
				$showft = $_POST['showft'];
				
				$checkco = ($checkco == '' ? '0' : '1'); 
				
				$showot = ($showot == '' ? '0' : '1'); 
				
				$showft = ($showft == '' ? '0' : '1'); 
				
				update_option( 'woo_custom_option_plugin', $checkco );
				
				update_option( 'woo_custom_option_optn_total', $showot );
				
				update_option( 'woo_custom_option_fnl_total', $showft );
				
			}
			
				
			?>
			<div id="profile-page" class="wrap">
				<?php
				
					$woo_custom_option_plugin =  get_option( 'woo_custom_option_plugin' );
					
					$woo_custom_option_optn_total =  get_option( 'woo_custom_option_optn_total' );
					
					$woo_custom_option_fnl_total =  get_option( 'woo_custom_option_fnl_total' );
					
					$tab = $_GET['tab'];

				?>
				<h2>
				WooCommerce Custom Options - Plugin Options
				</h2>
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
							<a class="nav-tab <?php if($tab == 'general' || $tab == ''){ echo ( "nav-tab-active" ); } ?>" href="?page=custom_options_setting&amp;tab=general">General</a>
							<a class="nav-tab <?php if($tab == 'premium'){ echo ( "nav-tab-active" ); } ?>" href="?page=custom_options_setting&amp;tab=premium">Premium</a>
					</h2>
					<form novalidate="novalidate" method="post" action="" >
						<?php 
						if($tab == 'general' || $tab == '')
						{
							?>
							<table class="form-table">

								<tbody>

									<h3>General Options</h3>
									
									<tr class="user-nickname-wrap">

										<th><label for="checkco">Enable Custom Options</label></th>

										<td><input type="checkbox" value="1" <?php if($woo_custom_option_plugin == 1){ echo "checked"; }  ?> id="checkco" name="checkco" ></label></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="showot">Show Options Total</label></th>

										<td><input type="checkbox" value="1" <?php if($woo_custom_option_optn_total == 1){ echo "checked"; } ?> id="showot" name="showot" ></label></td>

									</tr>
									
									<tr class="user-nickname-wrap">

										<th><label for="showft">Show Final Total</label></th>

										<td><input type="checkbox" value="1" <?php if($woo_custom_option_fnl_total == 1){ echo "checked"; } ?> id="showft" name="showft" ></label></td>

									</tr>
									
								</tbody>	

							</table>
							
							
							<p class="submit"><input type="submit" value="Save" class="button button-primary" id="submit" name="submit"></p>
							<?php
						}
						?>
					</form>

				</div>
			<?php
		
		}
		
		function add_to_cart_product( $cart_item_data,$product_id ) {
				
				if ( empty( $cart_item_data['options'] ) ) {
					
					$cart_item_data['options'] = array();
					
				}
				
				$array_options  = (array) get_post_meta( $product_id, '_product_custom_options', true );
				
					foreach ( $array_options as $options_key => $options ) {
						
						$val_post = $_POST['custom-options'][sanitize_title( $options['name'] )];
						
						if($val_post != '')
						{
							$data[] = array(
								'name'  => sanitize_title( $options['label'] ),
								'value' => $val_post,
								'price' => $options['price']
							);
							
							$cart_item_data['options'] =  $data;
						}
					}
					

					return $cart_item_data;
					
		}
			
		function validate_add_cart_product(  $passed, $product_id, $quantity ) {
			
			global $woocommerce;
			
			$array_options  = (array) get_post_meta( $product_id, '_product_custom_options', true );
			
				foreach ( $array_options as $options_key => $options ) {
					
						
						$post_data =  $_POST['custom-options'][sanitize_title( $options['name'] )];
						
						if( $options['required'] == 1  )
						{
							if ( $post_data == "" && strlen( $post_data ) == 0 ) {
								
								$data = new WP_Error( 'error', sprintf( __( '"%s" is a required field.', 'custom-options' ), $options['label'] ) );
								
									wc_add_notice( $data->get_error_message(), 'error' );
									
									$data_msg = 1;
							}
							
						}
						if ( strlen( $post_data ) > $options['max']) {
							
							$data = new WP_Error( 'error', sprintf( __( 'The maximum allowed length for "%s" is %s letters.', 'custom-options' ), $options['label'], $options['max'] ) );
							
							wc_add_notice( $data->get_error_message(), 'error' );
							
							$data_msg = 1;
						}
						
				}
				
				if($data_msg == 1)
				{
					return false;
				}
						
				return $passed;
					
		}
		
		function get_item_data( $other_data, $cart_item_data ) {
			
			if ( ! empty( $cart_item_data['options'] ) ) {
				
				foreach ( $cart_item_data['options'] as $options ) {
									
					$name = $options['name'];

					if ( $options['price'] > 0 ) {
						
						$name .= ' (' . woocommerce_price( get_product_addition_options_price ( $options['price'] ) ) . ')';
					
					}

					$other_data[] = array(
						'name'    => $name,
						'value'   => $options['value'],
						'display' => ''
					);
				}
			}
			return $other_data;
		}
		
		/**
		* add_cart_item function.
		*
		* @access public
		* @param mixed $cart_item
		* @return void
		*/
		function add_cart_item($cart_item_data) {
		
			if ( ! empty( $cart_item_data['options'] ) ) {

				$extra_cost = 0;

				foreach ( $cart_item_data['options'] as $options ) {
					
					if ( $options['price'] > 0 ) {
						
						$extra_cost += $options['price'];
						
					}
				}

				$cart_item_data['data']->adjust_price( $extra_cost );
			}

			return $cart_item_data;
		}

		/**
		* get_cart_item_from_session function.
		*
		* @access public
		* @param mixed $cart_item
		* @param mixed $values
		* @return void
		*/
		function get_cart_item_from_session($cart_item_data, $values) {
			
			if ( ! empty( $values['options'] ) ) {
				
				$cart_item_data['options'] = $values['options'];
				
				$cart_item_data = add_cart_item( $cart_item_data );
				
			}
			return $cart_item_data;
		}

		
		/**
		* order_item_meta function.
		*
		* @access public
		* @param mixed $item_meta
		* @param mixed $cart_item
		* @return void
		*/
		function order_item_meta($item_id,$values) {
					
			if ( ! empty( $values['options'] ) ) {
				
				foreach ( $values['options'] as $options ) {

					$name = $options['name'];

					if ( $options['price'] > 0 ) {
						
						$name .= ' (' . woocommerce_price( get_product_addition_options_price( $options['price'] ) ) . ')';
					}

					  woocommerce_add_order_item_meta( $item_id, $name, $options['value'] );
					
				}
			}
			
		}
		
		function get_product_addition_options_price( $price ) {
			
			global $product;

			if ( $price === '' || $price == '0' ) {
				
				return;
				
			}

			if ( is_object( $product ) ) {
				
				$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
				
				$display_price    = $tax_display_mode == 'incl' ? $product->get_price_including_tax( 1, $price ) : $product->get_price_excluding_tax( 1, $price );
			
			} else {
				
				$display_price = $price;
				
			}

			return $display_price;
		}

?>