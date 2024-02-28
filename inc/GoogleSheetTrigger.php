<?php


namespace Inc;

class GoogleSheetTrigger {
	public function init() {
		add_action( 'woocommerce_thankyou', array( $this, 'order_to_google_sheet' ) );
	}


	public function order_to_google_sheet( $order_id ) {
		$order   = wc_get_order( $order_id );
		$product = array_values( $order->get_items() )[0]->get_product();
		if ( $product->get_type() == 'variation' ) {
			$product_id = $product->get_parent_id();
		} else {
			$product_id = $product->get_ID();
		}
		$google_sheet_id = carbon_get_post_meta( $product_id, 'product_google_sheet_id' );
		$page            = carbon_get_post_meta( $product_id, 'product_google_sheet_page' );

		if ( ! $google_sheet_id || ! $page ) {
			$google_sheet_id = carbon_get_theme_option( 'product_google_sheet_id' );
			$page            = carbon_get_theme_option( 'product_google_sheet_page' );
		}

		$override_columns = carbon_get_post_meta( $product_id, 'override_product_google_sheet_order_metas' );
		if ( $override_columns ) {
			$columns = carbon_get_post_meta( $product_id, 'woo_google_sheet_order_metas' );
		} else {
			$columns = carbon_get_theme_option( 'woo_google_sheet_order_metas' );
		}
		$_60_minutes                    = time() + 60 * 60;
		$google_sheet_product_cookie    = '_google_sheet_triggered_' . $product_id;
		$google_sheet_product_transient = $order_id . 'google_sheet_product_cookie';
		if ( ! $order
		|| get_transient( $google_sheet_product_transient )
		|| isset( $_COOKIE[ $google_sheet_product_cookie ] )
		) {
			return;
		}
		$billing_info = $order->data['billing'];
		$product_data = array_values( $order->get_items() )[0];
		$product_id   = $product_data->get_data()['product_id'];
		$variation_id = $product_data->get_variation_id() ?: 0;
		$sku          = get_post_meta( $product_id, '_sku', true );
		$attribute    = '/';
		if ( $variation_id ) {
			$variation    = wc_get_product( $variation_id );
			$product_name = $variation->get_parent_data()['title'];
			$attribute    = str_replace( $product_name, '', $variation->get_data()['name'] );
			if ( $variation && $variation->get_sku() ) {
				$sku = $variation->get_sku();
			}
		}
		$data        = array();
		$order_metas = array_map(
			function ( $column ) {
				return $column['order_meta'];
			},
			$columns
		);
		foreach ( $order_metas as $order_meta ) {
			switch ( $order_meta ) {
				case 'date':
					$data[] = $order->get_date_created()->date_i18n( 'Y-m-d H:i:s' );
					break;
				case 'name':
					$data[] = $billing_info['first_name'];
					break;
				case 'phone':
					$data[] = $billing_info['phone'];
					break;
				case 'state':
					$data[] = $billing_info['state'];
					break;
				case 'city':
					$data[] = $billing_info['city'];
					break;
				case 'address':
					$data[] = $billing_info['address_1'];
					break;
				case 'product_id':
					$data[] = $product_id;
					break;
				case 'product':
					$data[] = $product_data->get_data()['name'];
					break;
				case 'attribute':
					$data[] = $attribute;
					break;
				case 'quantity':
					$data[] = $product_data->get_data()['quantity'];
					break;
				case 'sku':
					$data[] = $sku;
					break;
				case 'total_price':
					$data[] = $order->data['total'];
					break;
				case 'shipping_method':
					$data[] = array_values( $order->get_shipping_methods() )[0]->get_method_title();
					break;
				case 'status':
					$data[] = 'PENDING';
					break;
				default:
					break;
			}
		}

		$google_sheet_header = array_map(
			function ( $column ) {
				return $column['meta_custom_name'];
			},
			$columns
		);
		$client              = ( new GoogleSheet( $google_sheet_id, $page, $google_sheet_header ) );
		$client->append( $data );

		set_transient( $google_sheet_product_transient, true, $_60_minutes );
		// Expire in 60 minutes to prevent duplicate purchase event of the same product.
		setcookie( $google_sheet_product_cookie, true, $_60_minutes, '/' );
	}
}
