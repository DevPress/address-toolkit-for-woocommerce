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
 * Class Address_Toolkit
 * @package Address_Toolkit
 */
class Address_Toolkit {

	/** @var WC_Coupon_Restrictions */
	public static $instance;

	/** @var string */
	public $version = '1.0.0';

	/** @var string */
	public $required_woo = '5.6.0';

	/** @var URL for loading assets. **/
	public static string $url;

	/** @var PATH for plugin directory. **/
	public static string $dir;

	/**
	 * Main Address_Toolkit Instance.
	 *
	 * Ensures only one instance of the Address_Toolkit is loaded or can be loaded.
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
		self::$url = plugin_dir_url( __FILE__ );
		self::$dir = plugin_dir_path( __FILE__ );

		// Loads the settings page.
		add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ) );
	}

	/**
	 * Adds a new section to the WooCommerce integration settings.
	 */
	public function add_integration( $integrations ) {
		require_once self::$dir . '/includes/class-settings-page.php';
		new Address_Toolkit\Settings_Page();

		$integrations[] = 'Address_Toolkit\Settings_Page';
		return $integrations;
	}

}

Address_Toolkit::instance();
