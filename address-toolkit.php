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

	/** @var Address_Toolkit */
	public static $instance;

	/** @var string */
	public static $version = '1.0.0';

	/** @var string */
	public static $required_woo = '5.6.0';

	/** @var URL for loading assets. **/
	public static string $url;

	/** @var PATH for plugin directory. **/
	public static string $dir;

	/**
	 * Main Address_Toolkit Instance.
	 *
	 * Ensures only one instance of the Address_Toolkit is loaded or can be loaded.
	 *
	 * @return Address_Toolkit - Main instance.
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

		// Enqueue scripts and styles.
		require_once self::$dir . '/includes/class-enqueue.php';
		new Address_Toolkit\Enqueue();

		// Loads the settings page.
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_settings' ) );
	}

	/**
	 * Adds a new WooCommerce Settings page.
	 */
	public function add_settings( $settings ) {
		require_once self::$dir . '/includes/class-settings-page.php';
		$settings[] = new Address_Toolkit\Settings();
		return $settings;
	}

}

Address_Toolkit::instance();
