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
		$this->form_fields = $this->get_settings();
	}

	/**
	 * Returns the settings array.
	 *
	 * @return array
	 */
	public function get_settings() {
		return array(
			'api_key' => array(
				'id'          => 'addresstoolkit_api_key',
				'title'       => __( 'Google Cloud API Key', 'address-toolkit' ),
				'type'        => 'password',
				'description' => 'Enter API key for address autocomplete. <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Google API Key</a>.',
				'css'         => 'min-width:300px;',
			),

			// @todo Add country_restrictions with multi_select_countries type.
			'example' => array(
				'title'   => __( 'Sell to specific countries', 'woocommerce' ),
				'desc'    => '',
				'id'      => 'woocommerce_specific_allowed_countries',
				'css'     => 'min-width: 350px;',
				'default' => '',
				'type'    => 'multi_select_countries',
			),
		);
	}

	/**
	 * Output the gateway settings screen.
	 */
	public function admin_options() {
		echo '<h2>' . esc_html( parent::get_method_title() ) . '</h2>';
		echo wp_kses_post( wpautop( parent::get_method_description() ) );
		echo '<div><input type="hidden" name="section" value="' . esc_attr( $this->id ) . '" /></div>';
		\WC_Admin_Settings::output_fields(
			$this->get_settings()
		);
	}
}
