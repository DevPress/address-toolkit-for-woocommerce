<?php
namespace Address_Toolkit;

use Address_Toolkit;

/**
 * Class Enqueue.
 */
class Enqueue {

	public static $instance;

	/**
	 * Main Enqueue Instance.
	 *
	 * Ensures only one instance of the Enqueue is loaded or can be loaded.
	 *
	 * @return Enqueue - Main instance.
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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue styles and scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

		// We only need this on the checkout page.
		if ( ! is_checkout() ) {
			return;
		}

		$settings = get_option( 'woocommerce_addresstoolkit_settings' );
		$api_key  = $settings['api_key'] ?? false;

		// We need the API to continue.
		if ( ! $api_key ) {
			return;
		}

		// Custom styles.
		wp_enqueue_style(
			'addresstoolkit',
			Address_Toolkit::$url . 'assets/addresstoolkit.css',
			'',
			Address_Toolkit::$version . 'assets/addresstoolkit.css'
		);

		// Google API library.
		wp_enqueue_script(
			'google-api',
			'https://maps.googleapis.com/maps/api/js?key=' . esc_attr( $api_key ) . '&libraries=places',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		// Custom script.
		wp_enqueue_script(
			'addresstoolkit',
			Address_Toolkit::$url . 'assets/addresstoolkit.js',
			array( 'jquery' ),
			Address_Toolkit::$version . 'assets/addresstoolkit.js',
			true
		);

		// Add vars to the script.
		wp_localize_script(
			'addresstoolkit',
			'addresstoolkit_vars',
			array(
				'geo_country' => self::get_geo_country_user(),
			)
		);
	}

	/**
	 * Get user country from geolocation.
	 *
	 * @return string
	 */
	protected static function get_geo_country_user() {
		$user_ip = \WC_Geolocation::get_ip_address();

		if ( ! $user_ip ) {
			return '';
		}

		$user_geo = \WC_Geolocation::geolocate_ip( $user_ip );

		if ( isset( $user_geo['country'] ) && $user_geo['country'] ) {
			return $user_geo['country'];
		}

		return '';
	}

}
