<?php
/**
 * Cart Page Template
 * 
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined('ABSPATH') || exit;

get_header(); ?>

<main class="site-main woocommerce-page cart-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb for cart
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php _e('Shopping Cart', 'westpace-material'); ?></h1>
        </header>

        <div class="cart-wrapper">
            <?php
            do_action('woocommerce_before_cart'); 
            
            if (WC()->cart->is_empty()) : ?>
                
                <div class="cart-empty-state">
                    <div class="empty-cart-icon">
                        <span class="material-icons" style="font-size: 4rem; color: var(--gray-400);">shopping_cart</span>
                    </div>
                    <h2><?php _e('Your cart is currently empty', 'westpace-material'); ?></h2>
                    <p><?php _e('Add some products to your cart to get started.', 'westpace-material'); ?></p>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary">
                        <span class="material-icons">store</span>
                        <?php _e('Continue Shopping', 'westpace-material'); ?>
                    </a>
                </div>

            <?php else : ?>

                <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php do_action('woocommerce_before_cart_table'); ?>

                    <div class="cart-content-wrapper">
                        <div class="cart-items-section">
                            <table class="shop_table shop_table_responsive cart woocommerce-cart-table__cart" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail"><?php _e('Product', 'westpace-material'); ?></th>
                                        <th class="product-name">&nbsp;</th>
                                        <th class="product-price"><?php _e('Price', 'westpace-material'); ?></th>
                                        <th class="product-quantity"><?php _e('Quantity', 'westpace-material'); ?></th>
                                        <th class="product-subtotal"><?php _e('Subtotal', 'westpace-material'); ?></th>
                                        <th class="product-remove">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php do_action('woocommerce_before_cart_contents'); ?>

                                    <?php
                                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                            ?>
                                            <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                                                <td class="product-thumbnail">
                                                    <?php
                                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                                    if (!$product_permalink) {
                                                        echo $thumbnail; // PHPCS: XSS ok.
                                                    } else {
                                                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                                    }
                                                    ?>
                                                </td>

                                                <td class="product-name" data-title="<?php esc_attr_e('Product', 'westpace-material'); ?>">
                                                    <?php
                                                    if (!$product_permalink) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                    } else {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                    }

                                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                                    // Meta data.
                                                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                                    // Backorder notification.
                                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'westpace-material') . '</p>', $product_id));
                                                    }
                                                    ?>
                                                </td>

                                                <td class="product-price" data-title="<?php esc_attr_e('Price', 'westpace-material'); ?>">
                                                    <?php
                                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                    ?>
                                                </td>

                                                <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'westpace-material'); ?>">
                                                    <?php
                                                    if ($_product->is_sold_individually()) {
                                                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                                    } else {
                                                        $product_quantity = woocommerce_quantity_input(
                                                            array(
                                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                'input_value'  => $cart_item['quantity'],
                                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                                'min_value'    => '0',
                                                                'product_name' => $_product->get_name(),
                                                            ),
                                                            $_product,
                                                            false
                                                        );
                                                    }

                                                    echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                                    ?>
                                                </td>

                                                <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'westpace-material'); ?>">
                                                    <?php
                                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                    ?>
                                                </td>

                                                <td class="product-remove">
                                                    <?php
                                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                            'woocommerce_cart_item_remove_link',
                                                            sprintf(
                                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="material-icons">close</span></a>',
                                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                /* translators: %s is the product name */
                                                                esc_attr(sprintf(__('Remove %s from cart', 'westpace-material'), wp_strip_all_tags($_product->get_name()))),
                                                                esc_attr($product_id),
                                                                esc_attr($_product->get_sku())
                                                            ),
                                                            $cart_item_key
                                                        );
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <?php do_action('woocommerce_cart_contents'); ?>

                                    <tr>
                                        <td colspan="6" class="actions">
                                            
                                            <div class="cart-actions">
                                                <div class="coupon-section">
                                                    <?php if (wc_coupons_enabled()) { ?>
                                                        <div class="coupon">
                                                            <label for="coupon_code" class="screen-reader-text"><?php _e('Coupon:', 'westpace-material'); ?></label>
                                                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'westpace-material'); ?>" />
                                                            <button type="submit" class="btn btn-secondary" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'westpace-material'); ?>">
                                                                <span class="material-icons">local_offer</span>
                                                                <?php esc_html_e('Apply coupon', 'westpace-material'); ?>
                                                            </button>
                                                            <?php do_action('woocommerce_cart_coupon'); ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <div class="update-cart-section">
                                                    <button type="submit" class="btn btn-primary" name="update_cart" value="<?php esc_attr_e('Update cart', 'westpace-material'); ?>">
                                                        <span class="material-icons">refresh</span>
                                                        <?php esc_html_e('Update cart', 'westpace-material'); ?>
                                                    </button>
                                                </div>
                                            </div>

                                            <?php do_action('woocommerce_cart_actions'); ?>

                                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                                        </td>
                                    </tr>

                                    <?php do_action('woocommerce_after_cart_contents'); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-sidebar">
                            <?php do_action('woocommerce_before_cart_collaterals'); ?>

                            <div class="cart-collaterals">
                                <?php
                                    /**
                                     * Cart collaterals hook.
                                     *
                                     * @hooked woocommerce_cross_sell_display
                                     * @hooked woocommerce_cart_totals - 10
                                     */
                                    do_action('woocommerce_cart_collaterals');
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php do_action('woocommerce_after_cart_table'); ?>
                </form>

                <?php do_action('woocommerce_after_cart'); ?>

            <?php endif; ?>
        </div>
    </div>
</main>

<style>
.cart-page {
    padding: var(--spacing-8) 0;
}

.cart-empty-state {
    text-align: center;
    padding: var(--spacing-12) var(--spacing-6);
    background: white;
    border-radius: var(--rounded-lg);
    box-shadow: var(--elevation-1);
}

.cart-empty-state h2 {
    margin: var(--spacing-4) 0;
    color: var(--gray-700);
}

.cart-empty-state p {
    color: var(--gray-600);
    margin-bottom: var(--spacing-6);
}

.cart-content-wrapper {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: var(--spacing-8);
    align-items: start;
}

@media (max-width: 1024px) {
    .cart-content-wrapper {
        grid-template-columns: 1fr;
        gap: var(--spacing-6);
    }
}

.cart-actions {
    display: flex;
    gap: var(--spacing-4);
    align-items: center;
    flex-wrap: wrap;
}

.coupon {
    display: flex;
    gap: var(--spacing-3);
    align-items: center;
    flex-wrap: wrap;
}

.coupon input[type="text"] {
    min-width: 150px;
    padding: var(--spacing-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--rounded-md);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-2);
    padding: var(--spacing-3) var(--spacing-4);
    border: none;
    border-radius: var(--rounded-md);
    font-weight: var(--font-weight-medium);
    text-decoration: none;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.btn-primary {
    background-color: var(--primary-600);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-700);
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: var(--gray-100);
    color: var(--gray-700);
    border: 1px solid var(--gray-300);
}

.btn-secondary:hover {
    background-color: var(--gray-200);
}

.product-remove a {
    color: var(--error-600);
    text-decoration: none;
    padding: var(--spacing-2);
    border-radius: var(--rounded-md);
    transition: all var(--transition-fast);
}

.product-remove a:hover {
    background-color: var(--error-50);
    color: var(--error-700);
}
</style>

<?php get_footer(); ?>