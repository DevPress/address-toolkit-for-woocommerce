<?php
namespace Address_Toolkit;

use Address_Toolkit;

/**
 * Class Enqueue.
 */
class Address_Verification {

	public static $instance;

	/**
	 * Main Address_Verification Instance.
	 *
	 * Ensures only one instance of the Address_Verification is loaded or can be loaded.
	 *
	 * @return Address_Verification - Main instance.
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
		// Placeholder.
	}

}
