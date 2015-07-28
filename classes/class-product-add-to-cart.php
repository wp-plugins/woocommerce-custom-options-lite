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
					
						<?php 
						if($tab == 'general' || $tab == '')
						{
							?>
							<form novalidate="novalidate" method="post" action="" >
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
							</form>
							<?php
						}
						else
						{
						?>
						<style>
						 /*upgrade css*/

						.upgrade{background:#f4f4f9;padding: 50px 0; width:100%; clear: both;}
						.upgrade .upgrade-box{ background-color: #808a97;
							color: #fff;
							margin: 0 auto;
						   min-height: 110px;
							position: relative;
							width: 60%;}

						.upgrade .upgrade-box p{ font-size: 15px;
							 padding: 19px 20px;
							text-align: center;}

						.upgrade .upgrade-box a{background: none repeat scroll 0 0 #6cab3d;
							border-color: #ff643f;
							color: #fff;
							display: inline-block;
							font-size: 17px;
							left: 50%;
							margin-left: -150px;
							outline: medium none;
							padding: 11px 6px;
							position: absolute;
							text-align: center;
							text-decoration: none;
							top: 36%;
							width: 277px;}

						.upgrade .upgrade-box a:hover{background: none repeat scroll 0 0 #72b93c;}
                       
					   /**premium box**/    
						.premium-box{ width:100%; height:auto; background:#fff; float:left; }
						.premium-features{}
						.premium-heading{color:#484747;font-size: 40px; padding-top:35px;text-align:center;text-transform:uppercase;}
						.premium-features li{ width:100%; float:left;  padding: 80px 0; margin: 0; }
						.premium-features li .detail{ width:50%; }
						.premium-features li .img-box{ width:50%; }

						.premium-features li:nth-child(odd) { background:#f4f4f9; }
						.premium-features li:nth-child(odd) .detail{float:right; text-align:left; }
						.premium-features li:nth-child(odd) .detail .inner-detail{}
						.premium-features li:nth-child(odd) .detail p{ }
						.premium-features li:nth-child(odd) .img-box{ float:left; text-align:right;}

						.premium-features li:nth-child(even){  }
						.premium-features li:nth-child(even) .detail{ float:left; text-align:right;}
						.premium-features li:nth-child(even) .detail .inner-detail{ margin-right: 46px;}
						.premium-features li:nth-child(even) .detail p{ float:right;} 
						.premium-features li:nth-child(even) .img-box{ float:right;}

						.premium-features .detail{}
						.premium-features .detail h2{ color: #484747;  font-size: 24px; font-weight: 700; padding: 0;}
						.premium-features .detail p{  color: #484747;  font-size: 13px;  max-width: 327px;}
					 
					 /**images**/
					 
					  .custom-input-field { background:url("<?php echo custom_Options_plugin_dir_url; ?>/images/custom-input-field.png"); width:356px; height:194px; display:inline-block; margin-right: 25px; background-repeat:no-repeat;}
					  
					 .multiple-field{background:url("<?php echo custom_Options_plugin_dir_url; ?>/images/add-multiple-fields.png"); width:500px; height:229px; display:inline-block; margin-right:30px; background-size:500px auto; }
					
                    .text-limit{background:url("<?php echo custom_Options_plugin_dir_url; ?>/images/text-limit.png"); width:248px;   height:209px; display:inline-block;}

                    .input-field-conditonal{background:url("<?php echo custom_Options_plugin_dir_url; ?>/images/input-field-conditonal.png"); width:493px; height:76px; display:inline-block; margin-right: 30px;}	
                    
                    .add-description{background:url("<?php echo custom_Options_plugin_dir_url; ?>/images/add-description.png"); width:331px;   height:151px; display:inline-block; margin-right:30px; }					
					

                    .multiple-styling{background:url("<?php echo custom_Options_plugin_dir_url; ?>/images/multiple-styling.png");  height: 930px; width: 533px; display:inline-block; background-size:500px auto; background-repeat:no-repeat; }  					
				</style>
				<div class="premium-box">	
					<div class="upgrade">
						<div class="upgrade-box">
						<a target="_blank" href="http://www.phoeniixx.com/product/woocommerce-product-custom-options/"><b>UPGRADE</b> to the <span class="premium-vr">premium version</span></a>

						</div>
					</div>
											
						<ul class="premium-features">
							<h1 class="premium-heading">Premium Features</h1>
							<li>
							<div class="img-box"><span class="custom-input-field"></span></div>
							 <div class="detail">
							  <div class="inner-detail">
							   <h2>Custom Input Fields</h2>
								<p>
								  You could create Custom Input Fields Options (Text Field, Text Area, Check Box, Radio Button, File Upload and Dropdown) depending upon the kind of inputs that are required by you. This would assist your users in filling the right kind of data in that particular field. 
								</p>
							   </div>
                              </div>							  
							</li>
							
                            <li>
							 <div class="detail">
							  <div class="inner-detail">
							   <h2>Add multiple fields within Input Field</h2>
								<p>
								 You are allowed to add multiple fields within the same Input Field, based on your requirement
								</p>
							   </div> 
							 </div>
							 <div class="img-box"><span class="multiple-field"></span></div>
							</li>
						   
						   <li>
							<div class="img-box"><span class="text-limit"></span></div>
							 <div class="detail">
							  <div class="inner-detail">
							   <h2>Define Text Limit on Input Field</h2>
								<p>
								 Using this option, you could set a certain limit on the number of input characters. This will allow your users to be precise and specific. 
								</p>
							   </div>
                              </div>							  
							</li>
						 										
							
							<li>
								
								 <div class="detail">
								  <div class="inner-detail">
								   <h2>Add Description to every Option</h2>
									<p>
									 You have the choice to describe every option. This field will allow the customer to fill in any description that he wants to.
									</p>
								   </div>
								  </div>
                                  <div class="img-box"><span class="add-description"></span></div>								  
							</li>
							
							
							<li>
								 <div class="detail">
								  <div class="inner-detail">
								   <h2>Make Custom Input field Conditional or Compulsory </h2>
									<p>
									 You have the option of making a particular Custom Input Field either Conditional or Compulsory to fill. Any input field could be made to be a 'required field'.
									</p>
								   </div> 
								 </div>
							    <div class="img-box"><span class="input-field-conditonal"></span></div>
							</li>
							
						  	<li>
								<div class="img-box"><span class="multiple-styling"></span></div>
								 <div class="detail">
								  <div class="inner-detail">
								   <h2>Availability of Multiple Styling Options</h2>
									<p>
									There are various styling options that are available. 
									</p>
								   </div>
								  </div>							  
							</li>
						 
						 
						</ul>
						
						<div class="upgrade">
						<div class="upgrade-box">
						<a target="_blank" href="http://www.phoeniixx.com/product/woocommerce-product-custom-options/"><b>UPGRADE</b> to the <span class="premium-vr">premium version</span></a>

						</div>
					   </div>
						
				   </div>	
						<?php
						}
						?>
					

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


		function get_cart_item_from_session($cart_item_data, $values) {
			
			if ( ! empty( $values['options'] ) ) {
				
				$cart_item_data['options'] = $values['options'];
				
				$cart_item_data = add_cart_item( $cart_item_data );
				
			}
			return $cart_item_data;
		}

		

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