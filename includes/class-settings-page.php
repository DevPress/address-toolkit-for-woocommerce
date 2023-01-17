<?php
namespace Address_Toolkit;

/**
 * Address_Toolkit/Settings
 */
class Settings extends \WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'address-toolkit';
		$this->label = __( 'Address Toolkit', 'address-toolkit' );

		parent::__construct();
	}

	/**
	 * Get settings or the default section.
	 *
	 * @return array
	 */
	protected function get_settings_for_default_section() {

		$settings =
			array(

				array(
					'title' => __( 'Google Cloud Integration', 'address-toolkit' ),
					'type'  => 'title',
					'desc'  => __( 'Address autocomplete and address verification requires a connection to the Google Places API.', 'address-toolkit' ),
					'id'    => 'addresskit_google_cloud',
				),

				array(
					'title'   => __( 'Google Cloud API Key', 'address-toolkit' ),
					'desc'    => sprintf(
						__( 'Generate a <a href="%s" target="_blank">Google API Key</a>.', 'address-toolkit' ),
						'https://developers.google.com/maps/documentation/javascript/get-api-key',
					),
					'id'      => 'addresskit_api_key',
					'default' => '',
					'type'    => 'password',
				),

				array(
					'type' => 'sectionend',
					'id'   => 'autocomplete_settings',
				),

				array(
					'title' => __( 'Address Autocomplete', 'address-toolkit' ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'addresskit_autocomplete',
				),

				array(
					'title'   => __( 'Enable on checkout page', 'address-toolkit' ),
					'desc'    => __( 'Enables address autocomplete for shipping and billing fields on checkout.', 'woocommerce' ),
					'id'      => 'addresskit_enable_autocomplete_checkout',
					'default' => 'yes',
					'type'    => 'checkbox',
				),

				array(
					'title'   => __( 'Restrict to specific countries', 'address-toolkit' ),
					'desc'    => 'Leave blank to enable autocomplete suggestions for all countries you sell to.',
					'id'      => 'addresskit_allowed_countries',
					'css'     => 'min-width: 350px;',
					'default' => '',
					'type'    => 'multi_select_countries',
				),

				array(
					'type' => 'sectionend',
				),
			);

		return apply_filters( 'address_toolkit_settings', $settings );
	}
}
