<?php
namespace Address_Toolkit;

/**
 * Class Settings_Page.
 */
class Settings_Page extends \WC_Integration {

	/**
	 * Initialize the integration.
	 */
	public function __construct() {
		$this->id                 = 'addresstoolkit';
		$this->method_title       = __( 'Address Toolkit', 'address-toolkit' );
		$this->method_description = __( 'An integration with Google Cloud APIs for address autocomplete and verification.', 'address-toolkit' );

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Actions.
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'api_key' => array(
				'id'          => 'addresstoolkit-api-key',
				'title'       => __( 'Google Cloud API Key', 'address-toolkit' ),
				'type'        => 'password',
				'description' => 'Enter API key for address autocomplete. <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google API Key</a>.',
				'css'         => 'min-width:300px;',
			),
		);
	}
}
