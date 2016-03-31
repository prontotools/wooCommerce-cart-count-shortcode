<?php

require_once( "woocommerce-cart-count-shortcode.php" );

class WooCommerce_Cart_Count_Shortcode_Test extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

    public function test_should_pass() {
        $this->assertTrue( true );
    }
}
