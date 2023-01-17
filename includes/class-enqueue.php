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

		$api_key = get_option( 'addresskit_api_key', false );

		// We need the API to continue.
		if ( ! $api_key ) {
			return;
		}

		// Custom styles.
		wp_enqueue_style(
			'addresstoolkit',
			Address_Toolkit::$url . 'assets/addresstoolkit.css',
			array(),
			Address_Toolkit::$version,
		);

		// Google API library.
		wp_enqueue_script(
			'addresskit-google-places-api',
			'https://maps.googleapis.com/maps/api/js?key=' . esc_attr( $api_key ) . '&libraries=places',
			array(),
			'1.0.0',
			true
		);

		// Custom script.
		wp_enqueue_script(
			'addresstoolkit',
			Address_Toolkit::$url . 'assets/addresstoolkit.js',
			array( 'addresskit-google-places-api' ),
			Address_Toolkit::$version,
			true
		);

		// Add vars to the script.
		$allowed_countries = get_option( 'addresskit_allowed_countries', false );
		if ( $allowed_countries ) {
			wp_localize_script(
				'addresstoolkit',
				'addresstoolkit',
				array(
					'allowed_countries' => implode( ',', $allowed_countries ),
				)
			);
		}
	}
}
