<?php

namespace AddressToolkit\Test\Unit;

use WP_UnitTestCase;
use WC_Helper_Order;
use AddressToolkit;

class Basic_Test extends WP_UnitTestCase {
	/**
	 * Example test.
	 */
	public function basic_test() {
		$this->assertEquals( '0.00', '0.00' );
	}
}
