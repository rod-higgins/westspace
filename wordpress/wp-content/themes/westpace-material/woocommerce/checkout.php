<?php
/**
 * Checkout Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<main class="site-main woocommerce-page checkout-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb for checkout
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php _e('Checkout', 'westpace-material'); ?></h1>
        </header>

        <div class="checkout-wrapper">
            <?php
            do_action('woocommerce_before_checkout_form_cart_notices');

            // Check if cart is empty
            if (WC()->cart->is_empty() && !is_customize_preview() && apply_filters('woocommerce_checkout_redirect_empty_cart', true)) {
                ?>
                <div class="checkout-empty-state">
                    <div class="empty-cart-icon">
                        <span class="material-icons" style="font-size: 4rem; color: var(--gray-400);">shopping_cart</span>
                    </div>
                    <h2><?php _e('Your cart is empty', 'westpace-material'); ?></h2>
                    <p><?php _e('You need to add some items to your cart before proceeding to checkout.', 'westpace-material'); ?></p>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary">
                        <span class="material-icons">store</span>
                        <?php _e('Return to Shop', 'westpace-material'); ?>
                    </a>
                </div>
                <?php
                get_footer('shop');
                return;
            }

            do_action('woocommerce_before_checkout_form');

            // If checkout registration is disabled and not logged in, the user cannot checkout.
            if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
                echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'westpace-material')));
                return;
            }
            ?>

            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

                <div class="checkout-layout">
                    
                    <!-- Billing & Shipping Details -->
                    <div class="checkout-billing-section">
                        <?php if ($checkout->get_checkout_fields()) : ?>

                            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                            <div class="col2-set" id="customer_details">
                                <div class="col-1">
                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>

                                <div class="col-2">
                                    <?php do_action('woocommerce_checkout_shipping'); ?>
                                </div>
                            </div>

                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                        <?php endif; ?>
                    </div>

                    <!-- Order Review & Payment -->
                    <div class="checkout-review-section">
                        <div class="order-review-wrapper">
                            
                            <h3 id="order_review_heading"><?php esc_html_e('Your order', 'westpace-material'); ?></h3>

                            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                            <?php do_action('woocommerce_checkout_before_order_review'); ?>

                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_after_order_review'); ?>

                        </div>
                    </div>

                </div>

            </form>

            <?php do_action('woocommerce_after_checkout_form'); ?>
        </div>
    </div>
</main>

<?php get_footer('shop'); ?>