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
    		"cart_button",
    		$shortcode_tags
    	) );

    	$expected = "woocommerce_cart_count_shortcode";
    	$this->assertEquals( $expected, $shortcode_tags["cart_button"]);
    }

    public function test_put_cart_icon_should_render_icon_html_correctly() {
    	$expected = '<i class="fa fa-shopping-cart"></i>';

    	$actual = do_shortcode( '[cart_button icon="cart"]' );
    	
    	$this->assertContains( $expected, $actual );
    }
}
