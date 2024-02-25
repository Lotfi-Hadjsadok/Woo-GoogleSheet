<?php
/**
 * Plugin Name: Woo Google Sheet
 * Description: Woocommerce orders to your google sheet page.
 * Version: 1.0.1
 * Author: L.hadjsadok
 * Author URI: https://www.facebook.com/lotfihadjsadok.dev
 */

use Inc\SheetApp;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require __DIR__ . '/vendor/autoload.php';
( new SheetApp() )->start();
