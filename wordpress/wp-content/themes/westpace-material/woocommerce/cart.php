<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<main class="site-main woocommerce-page cart-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php _e('Shopping Cart', 'westpace-material'); ?></h1>
        </header>

        <div class="woocommerce">
            <?php do_action('woocommerce_before_cart'); ?>

            <?php if (WC()->cart->is_empty()) : ?>

                <div class="cart-empty-state">
                    <div class="empty-cart-icon">
                        <span class="material-icons" style="font-size: 4rem; color: var(--gray-400);">shopping_cart</span>
                    </div>
                    <h2><?php _e('Your cart is currently empty', 'westpace-material'); ?></h2>
                    <p><?php _e('Browse our products and discover something you like.', 'westpace-material'); ?></p>
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

                                                <!-- Product Thumbnail -->
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

                                                <!-- Product Name -->
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

                                                <!-- Product Price -->
                                                <td class="product-price" data-title="<?php esc_attr_e('Price', 'westpace-material'); ?>">
                                                    <?php
                                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                    ?>
                                                </td>

                                                <!-- Product Quantity -->
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

                                                <!-- Product Subtotal -->
                                                <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'westpace-material'); ?>">
                                                    <?php
                                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                    ?>
                                                </td>

                                                <!-- Product Remove -->
                                                <td class="product-remove">
                                                    <?php
                                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                            'woocommerce_cart_item_remove_link',
                                                            sprintf(
                                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="material-icons">close</span></a>',
                                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                esc_html__('Remove this item', 'westpace-material'),
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

                                            <?php if (wc_coupons_enabled()) { ?>
                                                <div class="coupon">
                                                    <label for="coupon_code"><?php esc_html_e('Coupon:', 'westpace-material'); ?></label> 
                                                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'westpace-material'); ?>" /> 
                                                    <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'westpace-material'); ?>"><?php esc_attr_e('Apply coupon', 'westpace-material'); ?></button>
                                                    <?php do_action('woocommerce_cart_coupon'); ?>
                                                </div>
                                            <?php } ?>

                                            <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e('Update cart', 'westpace-material'); ?>"><?php esc_html_e('Update cart', 'westpace-material'); ?></button>

                                            <?php do_action('woocommerce_cart_actions'); ?>

                                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                                        </td>
                                    </tr>

                                    <?php do_action('woocommerce_after_cart_contents'); ?>
                                </tbody>
                            </table>
                            <?php do_action('woocommerce_after_cart_table'); ?>
                        </div>

                        <!-- Cart Totals -->
                        <div class="cart-collaterals">
                            <div class="cart-totals">
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
                </form>

                <?php do_action('woocommerce_before_cart_collaterals'); ?>

                <div class="cart-actions">
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-outline-primary">
                        <span class="material-icons">arrow_back</span>
                        <?php _e('Continue Shopping', 'westpace-material'); ?>
                    </a>
                </div>

                <?php do_action('woocommerce_after_cart'); ?>

            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer('shop'); ?>