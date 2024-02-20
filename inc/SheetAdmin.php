<?php

namespace Inc;

use Carbon_Fields\Field;
use Carbon_Fields\Container;

class SheetAdmin {
	public function init() {
		add_action( 'carbon_fields_register_fields', array( $this, 'google_sheet_fields' ) );
	}


	function google_sheet_fields() {

		$google_sheet_order_fields =
		array(
			Field::make( 'text', 'product_google_sheet_id', 'Google_Sheet ID' )
				->set_width( 50 ),
			Field::make( 'text', 'product_google_sheet_page', 'Google_Sheet Page' )
			->set_width( 50 ),
			Field::make( 'complex', 'woo_google_sheet_order_metas', 'Order Details to send to google sheet' )
			->set_layout( 'tabbed-horizontal' )
			->add_fields(
				array(
					Field::make( 'select', 'order_meta' )
					->set_options(
						array(
							'date'            => 'Order Date',
							'name'            => 'Client Name',
							'phone'           => 'Client Phone',
							'state'           => 'Client State',
							'city'            => 'Client City',
							'adress'          => 'Client Full Adress',
							'product'         => 'Product Name',
							'product_id'      => 'Product ID',
							'attribute'       => 'Attribute',
							'sku'             => 'SKU',
							'quantity'        => 'Quantity',
							'total_price'     => 'Total Price',
							'shipping_method' => 'Shipping Method',
							'status'          => 'Status',
						)
					)
					->set_width( 40 ),

					Field::make( 'text', 'meta_custom_name', 'Meta Custom Name' )
					->set_help_text( 'Name of google sheet column' )
					->set_width( 60 ),
				)
			)
		->set_default_value(
			array(
				array(
					'order_meta'       => 'date',
					'meta_custom_name' => 'Date',
				),
				array(
					'order_meta'       => 'name',
					'meta_custom_name' => 'Name',
				),
				array(
					'order_meta'       => 'phone',
					'meta_custom_name' => 'Phone',
				),
				array(
					'order_meta'       => 'state',
					'meta_custom_name' => 'State',
				),
				array(
					'order_meta'       => 'city',
					'meta_custom_name' => 'City',
				),
				array(
					'order_meta'       => 'product',
					'meta_custom_name' => 'Product',
				),
				array(
					'order_meta'       => 'attribute',
					'meta_custom_name' => 'Attribute',
				),
				array(
					'order_meta'       => 'total_price',
					'meta_custom_name' => 'Total Price',
				),
				array(
					'order_meta'       => 'shipping_method',
					'meta_custom_name' => 'Shipping Method',
				),
				array(
					'order_meta'       => 'status',
					'meta_custom_name' => 'Status',
				),
			)
		),
		);

		// Global Settings
		Container::make( 'theme_options', __( 'Woo GoogleSheet' ) )
		->set_icon( 'dashicons-media-spreadsheet' )
		->set_page_menu_position( 6 )
		->add_fields(
			$google_sheet_order_fields
		);

		// On Woocommerce product
		Container::make( 'post_meta', __( 'Override Gooogle Sheet ?' ) )
		->where( 'post_type', '=', 'product' )
		->add_fields(
			array(
				Field::make( 'checkbox', 'override_product_google_sheet_order_metas', '0verride Order Metas ?' ),
			)
		);

		Container::make( 'post_meta', __( 'Google Sheet Override' ) )
		->where( 'post_type', '=', 'product' )
		->add_fields( $google_sheet_order_fields );
	}
}
