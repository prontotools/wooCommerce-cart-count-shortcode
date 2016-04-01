<?php

/*
 * Plugin Name: WooCommerce Cart Count Shortcode
 * Plugin URI: https://github.com/prontotools/woocommerce-cart-count-shortcode
 * Description: Display a link to your shopping cart with the item count anywhere on your site with a customizable shortcode.
 * Version: 1.0.0
 * Author: Pronto Tools
 * Author URI: http://www.prontotools.io
 */

function woocommerce_cart_count_shortcode( $atts ) {
	$defaults = array(
        "icon"  			 => "",
        "empty_cart_text" 	 => "",
        "items_in_cart_text" => "",
        "show_items"         => "",
        "custom_css" 		 => ""
    );

    $atts = shortcode_atts( $defaults, $atts );

    $icon_html = "";
    if ( $atts["icon"] == "cart" ) {
        $icon_html = '<i class="fa fa-shopping-cart"></i>';
    } else {
    	$icon_html = '<i class="fa fa-' . $atts["icon"] . '"></i>';
    }

    return $icon_html;
}

add_shortcode( "cart_button", "woocommerce_cart_count_shortcode" );
