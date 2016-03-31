<?php

require_once( "woocommerce-cart-count-shortcode.php" );

class WooCommerce_Cart_Count_Shortcode_Test extends WP_UnitTestCase {
	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

    public function test_woocommerce_cart_count_shortcode_is_registered_to_shortcode_handler() {
    	global $shortcode_tags;

    	$this->assertTrue( array_key_exists(
    		"woocommerce_cart_count",
    		$shortcode_tags
    	) );

    	$expected = "woocommerce_cart_count_shortcode";
    	$this->assertEquals( $expected, $shortcode_tags["woocommerce_cart_count"]);
    }
}
