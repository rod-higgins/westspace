<?php
/**
 * Block Filters
 *
 * @package apparel_ecommerce_store
 * @since 1.0
 */

function apparel_ecommerce_store_block_wrapper( $apparel_ecommerce_store_block_content, $apparel_ecommerce_store_block ) {

	if ( 'core/button' === $apparel_ecommerce_store_block['blockName'] ) {
		
		if( isset( $apparel_ecommerce_store_block['attrs']['className'] ) && strpos( $apparel_ecommerce_store_block['attrs']['className'], 'has-arrow' ) ) {
			$apparel_ecommerce_store_block_content = str_replace( '</a>', apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'caret-circle-right' ) ) ) . '</a>', $apparel_ecommerce_store_block_content );
			return $apparel_ecommerce_store_block_content;
		}
	}

	if( ! is_single() ) {
	
		if ( 'core/post-terms'  === $apparel_ecommerce_store_block['blockName'] ) {
			if( 'post_tag' === $apparel_ecommerce_store_block['attrs']['term'] ) {
				$apparel_ecommerce_store_block_content = str_replace( '<div class="taxonomy-post_tag wp-block-post-terms">', '<div class="taxonomy-post_tag wp-block-post-terms flex">' . apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'tags' ) ) ), $apparel_ecommerce_store_block_content );
			}

			if( 'category' ===  $apparel_ecommerce_store_block['attrs']['term'] ) {
				$apparel_ecommerce_store_block_content = str_replace( '<div class="taxonomy-category wp-block-post-terms">', '<div class="taxonomy-category wp-block-post-terms flex">' . apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'category' ) ) ), $apparel_ecommerce_store_block_content );
			}
			return $apparel_ecommerce_store_block_content;
		}
		if ( 'core/post-date' === $apparel_ecommerce_store_block['blockName'] ) {
			$apparel_ecommerce_store_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'calendar' ) ) ), $apparel_ecommerce_store_block_content );
			return $apparel_ecommerce_store_block_content;
		}
		if ( 'core/post-author' === $apparel_ecommerce_store_block['blockName'] ) {
			$apparel_ecommerce_store_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'user' ) ) ), $apparel_ecommerce_store_block_content );
			return $apparel_ecommerce_store_block_content;
		}
	}
	if( is_single() ){

		// Add chevron icon to the navigations
		if ( 'core/post-navigation-link' === $apparel_ecommerce_store_block['blockName'] ) {
			if( isset( $apparel_ecommerce_store_block['attrs']['type'] ) && 'previous' === $apparel_ecommerce_store_block['attrs']['type'] ) {
				$apparel_ecommerce_store_block_content = str_replace( '<span class="post-navigation-link__label">', '<span class="post-navigation-link__label">' . apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'prev' ) ) ), $apparel_ecommerce_store_block_content );
			}
			else {
				$apparel_ecommerce_store_block_content = str_replace( '<span class="post-navigation-link__label">Next Post', '<span class="post-navigation-link__label">Next Post' . apparel_ecommerce_store_get_svg( array( 'icon' => esc_attr( 'next' ) ) ), $apparel_ecommerce_store_block_content );
			}
			return $apparel_ecommerce_store_block_content;
		}
		if ( 'core/post-date' === $apparel_ecommerce_store_block['blockName'] ) {
            $apparel_ecommerce_store_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . apparel_ecommerce_store_get_svg( array( 'icon' => 'calendar' ) ), $apparel_ecommerce_store_block_content );
            return $apparel_ecommerce_store_block_content;
        }
		if ( 'core/post-author' === $apparel_ecommerce_store_block['blockName'] ) {
            $apparel_ecommerce_store_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . apparel_ecommerce_store_get_svg( array( 'icon' => 'user' ) ), $apparel_ecommerce_store_block_content );
            return $apparel_ecommerce_store_block_content;
        }

	}
    return $apparel_ecommerce_store_block_content;
}
	
add_filter( 'render_block', 'apparel_ecommerce_store_block_wrapper', 10, 2 );
