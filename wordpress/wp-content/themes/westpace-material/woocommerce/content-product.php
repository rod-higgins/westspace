<?php
// =================================
// FILE: woocommerce/content-product.php
// =================================
/**
 * The template for displaying product content within loops
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('product-item', $product); ?>>
    <div class="product-card material-card">
        
        <!-- Product Image -->
        <div class="product-image-wrapper">
            <a href="<?php the_permalink(); ?>" class="product-image-link">
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop_item_title.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action('woocommerce_before_shop_loop_item_title');
                ?>
            </a>
            
            <!-- Quick View Button -->
            <button class="quick-view-btn" data-product-id="<?php echo get_the_ID(); ?>" aria-label="<?php esc_attr_e('Quick view', 'westpace-material'); ?>">
                <span class="material-icons">visibility</span>
            </button>
            
            <!-- Wishlist Button -->
            <button class="wishlist-btn" data-product-id="<?php echo get_the_ID(); ?>" aria-label="<?php esc_attr_e('Add to wishlist', 'westpace-material'); ?>">
                <span class="material-icons">favorite_border</span>
            </button>
            
            <!-- Sale Badge -->
            <?php if ($product->is_on_sale()) : ?>
                <div class="sale-badge">
                    <?php
                    $percentage = '';
                    if ($product->get_type() === 'simple' || $product->get_type() === 'external') {
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        if ($regular_price && $sale_price) {
                            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                            echo '-' . $percentage . '%';
                        } else {
                            echo esc_html__('Sale!', 'westpace-material');
                        }
                    } else {
                        echo esc_html__('Sale!', 'westpace-material');
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Product Content -->
        <div class="product-content">
            
            <!-- Category -->
            <?php
            $product_cats = wp_get_post_terms(get_the_ID(), 'product_cat');
            if (!empty($product_cats)) {
                echo '<div class="product-category">';
                echo '<a href="' . esc_url(get_term_link($product_cats[0])) . '">' . esc_html($product_cats[0]->name) . '</a>';
                echo '</div>';
            }
            ?>
            
            <!-- Product Title -->
            <h3 class="product-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            
            <!-- Product Rating -->
            <?php if (wc_review_ratings_enabled()) : ?>
                <div class="product-rating">
                    <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                    <span class="rating-count">(<?php echo $product->get_review_count(); ?>)</span>
                </div>
            <?php endif; ?>
            
            <!-- Product Price -->
            <div class="product-price">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item_title.
                 *
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action('woocommerce_after_shop_loop_item_title');
                ?>
            </div>
            
            <!-- Product Actions -->
            <div class="product-actions">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action('woocommerce_after_shop_loop_item');
                ?>
            </div>
        </div>
    </div>
</li>