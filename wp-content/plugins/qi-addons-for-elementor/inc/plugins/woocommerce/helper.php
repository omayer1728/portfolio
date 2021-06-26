<?php

if ( ! function_exists( 'qi_addons_for_elementor_woo_get_global_product' ) ) {
	/**
	 * Function that return global WooCommerce object
	 *
	 * @return object
	 */
	function qi_addons_for_elementor_woo_get_global_product() {
		global $product;

		return $product;
	}
}

if ( ! function_exists( 'qi_addons_for_elementor_include_woocommerce_shortcodes' ) ) {
	/**
	 * Function that includes shortcodes
	 */
	function qi_addons_for_elementor_include_woocommerce_shortcodes() {
		foreach ( glob( QI_ADDONS_FOR_ELEMENTOR_PLUGINS_PATH . '/woocommerce/shortcodes/*/include.php' ) as $shortcode ) {
			include_once $shortcode;
		}
	}

	add_action( 'qi_addons_for_elementor_action_framework_before_shortcodes_register', 'qi_addons_for_elementor_include_woocommerce_shortcodes' );
}

if ( ! function_exists( 'qi_addons_for_elementor_woo_product_get_rating_html' ) ) {
	/**
	 * Function that return ratings templates
	 *
	 * @param string $html - contains html content
	 * @param float $rating
	 * @param int $count - total number of ratings
	 *
	 * @return string
	 */
	function qi_addons_for_elementor_woo_product_get_rating_html( $html, $rating, $count ) {

		if ( ! empty( $rating ) ) {
			$html  = '<div class="qodef-m-inner">';
			$html .= '<div class="qodef-m-star qodef--initial">';
			for ( $i = 0; $i < 5; $i ++ ) {
				$html .= qi_addons_for_elementor_get_svg_icon( 'star', 'qodef-m-star-item' );
			}
			$html .= '</div>';
			$html .= '<div class="qodef-m-star qodef--active" style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
			for ( $i = 0; $i < 5; $i ++ ) {
				$html .= qi_addons_for_elementor_get_svg_icon( 'star', 'qodef-m-star-item' );
			}
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;
	}
}

if ( ! function_exists( 'qi_addons_for_elementor_woo_get_product_categories' ) ) {
	/**
	 * Function that render product categories
	 *
	 * @param string $before
	 * @param string $after
	 *
	 * @return string
	 */
	function qi_addons_for_elementor_woo_get_product_categories( $before = '', $after = '' ) {
		global $product;

		return ! empty( $product ) ? wc_get_product_category_list( $product->get_id(), '<span class="qodef-category-separator"></span>', $before, $after ) : '';
	}
}
