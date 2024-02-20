<?php
/**
 * Plugin Name: Woo Google Sheet
 * Description: Woocommerce orders to your google sheet page.
 * Version: 1.0.0
 * Author: L.hadjsadok
 * Author URI: https://dz.linkedin.com/in/lotfi-hadjsadok-6599571ba
 */

use Inc\SheetApp;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require __DIR__ . '/vendor/autoload.php';
( new SheetApp() )->start();
