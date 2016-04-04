<?php

require_once( "woocommerce-cart-count-shortcode.php" );

class WooCommerce {
    public $cart;
}

class Fake_WC_Cart {
    public function get_cart_contents_count() {
        return 3;
    }
}

class Fake_WC_Strore {
    public function get_cart_contents_count() {
        return 0;
    }
}

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

    public function test_put_cart_icon_should_render_cart_icon_html_correctly() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;
        
        $expected = '<i class="fa fa-shopping-cart"></i>';

        $actual = do_shortcode( '[cart_button icon="cart"]' );
        
        $this->assertContains( $expected, $actual );
    }

    public function test_put_any_icon_should_render_any_icon_html_correctly() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;
    	
        $expected = '<i class="fa fa-truck"></i>';

    	$actual = do_shortcode( '[cart_button icon="truck"]' );
    	
    	$this->assertContains( $expected, $actual );
    }

    public function test_if_no_put_icon_should_not_render_icon_html() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;
        
        $expected = '<i class="fa fa-"></i>';

        $actual = do_shortcode( '[cart_button icon=""]' );
        
        $this->assertNotContains( $expected, $actual );   
    }

    public function test_show_items_in_the_cart_if_set_show_items_as_true() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;
        
        $expected = '(3)';

        $actual = do_shortcode( '[cart_button show_items="true"]' );

        $this->assertContains( $expected, $actual );
    }

    public function test_not_show_items_in_the_cart_if_set_show_items_as_false() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;
        
        $expected = '(3)';

        $actual = do_shortcode( '[cart_button show_items="false"]' );

        $this->assertNotContains( $expected, $actual );
    }

    public function test_show_cart_if_has_item_in_cart_and_set_items_in_cart_text() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;

        $expected = 'Cart (3)';

        $actual = do_shortcode( '[cart_button show_items="true" items_in_cart_text="Cart"]' );

        $this->assertContains( $expected, $actual );
    }

    public function test_should_not_show_cart_text_if_no_item_in_cart() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Strore;

        $expected = 'Cart';

        $actual = do_shortcode( '[cart_button show_items="true" items_in_cart_text="Cart"]' );
        $this->assertNotContains( $expected, $actual );
    }
}
