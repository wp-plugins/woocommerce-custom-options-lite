<?php
/*
Plugin Name: Woocommerce Product Custom Options Lite
Plugin URI: http://www.phoeniixx.com
Description: This plugin is designed to give your Ecommerce website the space to add customized options for your products.
Version: 1.1
Text Domain: custom-options
Domain Path: /i18n/languages/
Author: Phoeniixx
Author URI: http://www.phoeniixx.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
ob_start();

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Check if WooCommerce is active
**/

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
	{
	 
		define("custom_Options_plugin_dir_url", esc_url( plugin_dir_url( __FILE__ ) ) );

		/**
		* Custom Tab for Product display with TinyMCE Editor
		* Outputs an extra tab to the default set of info tabs on the single product page.
		*/
	 
		class Product_Custom_Options {
			
				public function __construct() {
					
					if ( is_admin() ) {
					
						add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'custom_options_tab' ) );
						
						add_action( 'woocommerce_product_write_panels', array( $this, 'custom_options_tab_options' ) );
						
						add_action( 'woocommerce_process_product_meta', array( $this, 'process_product_meta_custom_tab' ) );
					
					}
					
						
						include_once( 'classes/class-product-page-options.php' );
						
						include_once( 'classes/class-product-add-to-cart.php' );
						
			
				}
				
				function custom_options_tab() {
				
					?>
					
					<script>
					jQuery( document ).ready( function($) {

						$("#product-type").change(function () {
							
							var value = this.value;
							
							if(value === 'grouped' || value === 'external')
							{
								$('.custom_tab').hide();
							}
							else
							{
								$('.custom_tab').show();
							}
							
						});
						
						var valuep  = $('#product-type :selected').val();
						
						if( valuep === 'grouped' || valuep === 'external' )
						{
							$('.custom_tab').hide();
						}
						else
						{
							$('.custom_tab').show();
						}
						
					});
					</script>
		
						<li class="custom_tab"><a href="#custom_tab_data"><?php _e('Custom Options', 'custom-options'); ?></a></li>
					
					<?php
				
				}

				 /**
				 * Custom Tab Options
				 * Provides the input fields and add/remove buttons for custom tabs on the single product page.
				 */

				function custom_options_tab_options() {
				
					global $post;
					
					$product_custom_options_added = array_filter( (array) get_post_meta( $post->ID, '_product_custom_options', true ) );
					
					//print_r($product_custom_options_added);

					?>
						<div id="custom_tab_data" class="panel woocommerce_options_panel wc-metaboxes-wrapper">
								
								<div id="custom_tab_data_options" class="wc-metaboxes">
								
								<?php
									
										$loop = 0;

										foreach ( $product_custom_options_added as $option ) {
											
											include( 'custom_options_html.php' );
											//print_r( $option );
											
											$loop++;
										}
									?>

								</div>

							<div class="toolbar">
								
								<button type="button" class="button add_new_custom_option button-primary"><?php _e( 'New Custom Option', 'custom-options' ); ?></button>
							
							</div>
							
							<script type="text/javascript">
								jQuery(function(){

									jQuery('#custom_tab_data').on( 'click', '.add_new_custom_option', function() {
										//alert();
										var loop = jQuery('#custom_tab_data_options .woocommerce_product_option').size();

										var html = '<?php
											
											ob_start();

											$option['name'] 			= '';
											
											$option['required'] 		= '';
											
											$option['type'] 			= 'custom';
											
											$option['options'] 		= array();
											
											$loop = "{loop}";

											include( 'custom_options_html.php' );
										
											$html = ob_get_clean();
											
											echo str_replace( array( "\n", "\r" ), '', str_replace( "'", '"', $html ) );
										
										?>';
										html = html.replace( /{loop}/g, loop );
										
										jQuery('#custom_tab_data_options').append( html );
										
										jQuery('.clear_class'+loop).val( '' );
									});
									
									
									jQuery('#custom_tab_data').on( 'click', '.remove_option', function() {

											var conf = confirm('<?php _e('Are you sure you want remove this option?', 'custom-options'); ?>');

											if (conf) {
												
												var option = jQuery(this).closest('.woocommerce_product_option');
												
												//alert( option );
												
												jQuery(option).find('input').val('');
												
												jQuery(option).hide();
												
											}

											return false;
									});
									
									jQuery('#custom_tab_data_options').sortable({
										
										items:'.woocommerce_product_option',
										
										cursor:'move',
										
										axis:'y',
										
										handle:'h3',
										
										scrollSensitivity:50,
										
										helper:function(e,ui){
											
											return ui;
											
										},
										
										start:function(event,ui){
											
											ui.item.css('border-style', 'dashed');
											
										},
										
										stop:function(event,ui){
											
											ui.item.removeAttr('style');
											
											options_row_indexes();
											
										}
										
										
									});
									
									function options_row_indexes() {
										
											jQuery('#custom_tab_data .woocommerce_product_option').each(function(index, sel) {
					
												jQuery('.product_option_position', sel).val( parseInt( index ) ); 
											
											});
									
									};
									
								});
							</script>
							
							<style>
							#custom_tab_data input {
								
								min-width: 139px;
								
							}
							#custom_tab_data label {
								
								margin: 0;
								
							}
							</style>
						</div>
					<?php
				
				}

				
				function process_product_meta_custom_tab( $post_id ) {

					$product_custom_options = $this->save_all_data_in_db();
					
					update_post_meta( $post_id, '_product_custom_options', $product_custom_options );
						
				}
				


				function save_all_data_in_db() {
					
					$product_custom_options = array();
					
					if ( isset( $_POST[ 'product_option_name' ] ) ) 
					{
						
						$option_name  = $_POST['product_option_name'];
						
						$option_type  = $_POST['product_option_type'];
						
						$option_position  = $_POST['product_option_position'];
						
						$option_required   = isset( $_POST['product_option_required'] ) ? $_POST['product_option_required'] : array();
						
						$option_label = $_POST['product_option_label'];
						
						$option_price = $_POST['product_option_price'];
						
						$option_max   = $_POST['product_option_max'];
						 
						for ( $i = 0; $i < sizeof( $option_name ); $i++ ) 
						{

							if ( ! isset( $option_name[ $i ] ) || ( '' == $option_name[ $i ] ) ) {
								
								continue;
								
							}

							$data                = array();
							
							$data['name']        = sanitize_text_field( stripslashes( $option_name[ $i ] ) );
							
							$data['type']        = sanitize_text_field( stripslashes( $option_type[ $i ] ) );
							
							$data['position']    = absint( $option_position[ $i ] );
							
							$data['required']    = isset( $option_required[ $i ] ) ? 1 : 0;
							
							$data['label'] = sanitize_text_field( stripslashes( $option_label[ $i ] ) );
							
							$data['price'] = wc_format_decimal( sanitize_text_field( stripslashes( $option_price[ $i ] ) ) );
							
							$data['max']   = sanitize_text_field( stripslashes( $option_max[ $i ] ) );

							// Add to array
							$product_custom_options[] = apply_filters( 'custom_options_save_data', $data, $i );
				
						}
						
					}
					
					uasort( $product_custom_options, array( $this, 'sort_options' ) );
					
					return $product_custom_options;
				}

				function sort_options( $a, $b ) {
					
					if ( $a['position'] == $b['position'] ) {
						
						return 0;
						
					}

					return ( $a['position'] < $b['position'] ) ? -1 : 1;
					
				}
				
		}
		
		$Product_Custom_Options_obj = new Product_Custom_Options();
		
	}
	else 
	{
		
		add_action('admin_notices', 'custom_options_admin_notice');

		function custom_options_admin_notice() {
			global $current_user ;
				$user_id = $current_user->ID;
				/* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta($user_id, 'custom_options_ignore_notice') ) {
				echo '<div class="error"><p>'; 
				printf(__('Woocommerce custom options could not detect an active Woocommerce plugin. Make sure you have activated it. | <a href="%1$s">Hide Notice</a>'), '?custom_options_nag_ignore=0');
				echo "</p></div>";
			}
		}

		add_action('admin_init', 'custom_options_nag_ignore');

		function custom_options_nag_ignore() {
			global $current_user;
				$user_id = $current_user->ID;
				/* If user clicks to ignore the notice, add that to their user meta */
				if ( isset($_GET['custom_options_nag_ignore']) && '0' == $_GET['custom_options_nag_ignore'] ) {
					 add_user_meta($user_id, 'custom_options_ignore_notice', 'true', true);
			}
		}
	}
?>