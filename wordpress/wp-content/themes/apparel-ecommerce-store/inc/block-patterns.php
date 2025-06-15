<?php
/**
 * Block Patterns
 *
 * @package apparel_ecommerce_store
 * @since 1.0
 */

function apparel_ecommerce_store_register_block_patterns() {
	$apparel_ecommerce_store_block_pattern_categories = array(
		'apparel-ecommerce-store' => array( 'label' => esc_html__( 'Apparel Ecommerce Store', 'apparel-ecommerce-store' ) ),
		'pages' => array( 'label' => esc_html__( 'Pages', 'apparel-ecommerce-store' ) ),
	);

	$apparel_ecommerce_store_block_pattern_categories = apply_filters( 'apparel_ecommerce_store_apparel_ecommerce_store_block_pattern_categories', $apparel_ecommerce_store_block_pattern_categories );

	foreach ( $apparel_ecommerce_store_block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}
}
add_action( 'init', 'apparel_ecommerce_store_register_block_patterns', 9 );