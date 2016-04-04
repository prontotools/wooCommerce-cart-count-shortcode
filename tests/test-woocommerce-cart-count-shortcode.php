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

class Fake_WC_Store {
    public function get_cart_contents_count() {
        return 0;
    }
}

class WooCommerce_Cart_Count_Shortcode_Test extends WP_UnitTestCase {
	public function setUp() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Cart;
		
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
        $expected = '(3)';

        $actual = do_shortcode( '[cart_button show_items="true"]' );

        $this->assertContains( $expected, $actual );
    }

    public function test_not_show_items_in_the_cart_if_set_show_items_as_false() {
        $expected = '(3)';

        $actual = do_shortcode( '[cart_button show_items="false"]' );

        $this->assertNotContains( $expected, $actual );
    }

    public function test_show_cart_if_has_item_in_cart_and_set_items_in_cart_text() {
        $expected = 'Cart (3)';

        $actual = do_shortcode( '[cart_button show_items="true" items_in_cart_text="Cart"]' );

        $this->assertContains( $expected, $actual );
    }

    public function test_should_not_show_cart_text_if_no_item_in_cart() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Store;

        $expected = 'Cart';

        $actual = do_shortcode( '[cart_button show_items="true" items_in_cart_text="Cart"]' );
        $this->assertNotContains( $expected, $actual );
    }

    public function test_put_empty_cart_text_as_store_should_show_text_if_no_product_in_cart() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Store;

        $expected = 'Store';

        $actual = do_shortcode( '[cart_button show_items="true" empty_cart_text="Store"]' );
        $this->assertContains( $expected, $actual );
    }

    public function test_put_custom_class_should_render_html_correctly() {
        $expected = '<a href="/cart/" class="custom">Cart</a>';

        $actual = do_shortcode( '[cart_button items_in_cart_text="Cart" custom_css="custom"]' );
        $this->assertContains( $expected, $actual );
    }

    public function test_show_link_to_shop_if_has_no_product_in_cart() {
        global $woocommerce;

        $woocommerce = new WooCommerce;
        $woocommerce->cart = new Fake_WC_Store;

        $expected = '<a href="/shop/">Store</a>';

        $actual = do_shortcode( '[cart_button empty_cart_text="Store"]' );

        $this->assertContains( $expected, $actual );
    }

    public function test_show_link_to_cart_if_has_product_in_cart() {
        $expected = '<a href="/cart/">Cart</a>';

        $actual = do_shortcode( '[cart_button items_in_cart_text="Cart"]' );

        $this->assertContains( $expected, $actual );
    }
}
