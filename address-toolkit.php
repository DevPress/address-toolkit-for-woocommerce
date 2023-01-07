<?php
/**
 * Plugin Name: Address Toolkit for WooCommerce
 * Plugin URI: https://devpress.com
 * Description: Address validation and autocomplete for WooCommerce using Google Places APIs.
 * Version: 1.0.0
 * Author: DevPress
 * Author URI: https://devpress.com
 * Developer: Devin Price
 * Developer URI: https://devpress.com
 *
 * WC requires at least: 5.6.0
 * WC tested up to: 7.2.2
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Class AddressToolkit
 * @package AddressToolkit
 */
class AddressToolkit {

	/**
	 * The single instance of the class.
	 *
	 * @var mixed $instance
	 */
	protected static $instance;

	/**
	 * Main AddressToolkit Instance.
	 *
	 * Ensures only one instance of the AddressToolkit is loaded or can be loaded.
	 *
	 * @return AddressToolkit - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
	}

}

AddressToolkit::instance();
