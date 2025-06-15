<?php
/**
 * Checkout Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/checkout.php.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<main class="site-main woocommerce-page checkout-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php _e('Checkout', 'westpace-material'); ?></h1>
            <p class="page-subtitle"><?php _e('Complete your order securely', 'westpace-material'); ?></p>
        </header>

        <div class="woocommerce">
            <?php do_action('woocommerce_before_checkout_form', $checkout); ?>

            <?php if (!is_user_logged_in() && 'no' !== get_option('woocommerce_enable_checkout_login_reminder')) : ?>
                <div class="checkout-login-reminder">
                    <div class="material-card elevation-2">
                        <div class="card-content">
                            <div class="login-reminder-header">
                                <span class="material-icons">account_circle</span>
                                <h3><?php _e('Returning customer?', 'westpace-material'); ?></h3>
                            </div>
                            <p><?php _e('If you have an account, please log in for a faster checkout experience.', 'westpace-material'); ?></p>
                            <a href="#" class="show-login-form btn btn-outline">
                                <?php _e('Click here to login', 'westpace-material'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (wc_coupons_enabled()) : ?>
                <div class="coupon-section">
                    <div class="material-card elevation-1">
                        <div class="card-content">
                            <div class="coupon-header">
                                <span class="material-icons">local_offer</span>
                                <h3><?php _e('Have a coupon?', 'westpace-material'); ?></h3>
                            </div>
                            <p><?php _e('If you have a coupon code, please apply it below.', 'westpace-material'); ?></p>
                            <a href="#" class="show-coupon-form btn btn-outline">
                                <?php _e('Click here to enter your code', 'westpace-material'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (WC()->cart->is_empty()) : ?>
                
                <div class="checkout-empty-state">
                    <div class="empty-cart-icon">
                        <span class="material-icons" style="font-size: 4rem; color: var(--gray-400);">shopping_cart</span>
                    </div>
                    <h2><?php _e('Your cart is empty', 'westpace-material'); ?></h2>
                    <p><?php _e('You cannot proceed to checkout with an empty cart.', 'westpace-material'); ?></p>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary">
                        <span class="material-icons">store</span>
                        <?php _e('Continue Shopping', 'westpace-material'); ?>
                    </a>
                </div>

            <?php else : ?>

                <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                    
                    <div class="checkout-layout">
                        
                        <!-- Billing Details -->
                        <div class="checkout-billing-section">
                            <div class="billing-details">
                                <h2 id="billing-details-heading">
                                    <span class="material-icons">location_on</span>
                                    <?php _e('Billing details', 'westpace-material'); ?>
                                </h2>
                                
                                <div class="billing-fields">
                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>
                            </div>

                            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                <div class="shipping-details">
                                    <h2 id="shipping-details-heading">
                                        <span class="material-icons">local_shipping</span>
                                        <?php _e('Shipping details', 'westpace-material'); ?>
                                    </h2>
                                    
                                    <div class="shipping-fields">
                                        <?php do_action('woocommerce_checkout_shipping'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php do_action('woocommerce_checkout_before_order_review'); ?>
                        </div>

                        <!-- Order Review -->
                        <div class="checkout-review-section">
                            <div class="order-review-wrapper">
                                <h2 id="order_review_heading">
                                    <span class="material-icons">receipt</span>
                                    <?php _e('Your order', 'westpace-material'); ?>
                                </h2>
                                
                                <div class="order-review-content">
                                    <div id="order_review" class="woocommerce-checkout-review-order">
                                        <?php do_action('woocommerce_checkout_order_review'); ?>
                                    </div>
                                </div>

                                <!-- Payment Methods -->
                                <div class="payment-methods-section">
                                    <h3 class="payment-methods-title">
                                        <span class="material-icons">payment</span>
                                        <?php _e('Payment methods', 'westpace-material'); ?>
                                    </h3>
                                    
                                    <div class="payment-methods">
                                        <?php if (WC()->cart->needs_payment()) : ?>
                                            <ul class="wc_payment_methods payment_methods methods">
                                                <?php
                                                if (!empty($available_gateways)) {
                                                    foreach ($available_gateways as $gateway) {
                                                        wc_get_template('checkout/payment-method.php', array('gateway' => $gateway), '', '');
                                                    }
                                                } else {
                                                    echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')) . '</li>'; // @codingStandardsIgnoreLine
                                                }
                                                ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <?php if (wc_get_page_id('terms') > 0 && apply_filters('woocommerce_checkout_show_terms', true)) : ?>
                                        <div class="terms-and-conditions">
                                            <p class="form-row terms wc-terms-and-conditions">
                                                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                                    <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true); ?> id="terms" />
                                                    <span class="woocommerce-form__label-for-checkbox-text">
                                                        <?php printf(__('I have read and agree to the website %s', 'westpace-material'), '<a href="' . esc_url(wc_get_page_permalink('terms')) . '" class="woocommerce-terms-and-conditions-link" target="_blank">' . __('terms and conditions', 'westpace-material') . '</a>'); ?>
                                                    </span>
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="hidden" name="terms-field" value="1" />
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Place Order Button -->
                                    <div class="place-order-section">
                                        <?php do_action('woocommerce_review_order_before_submit'); ?>
                                        
                                        <button type="submit" class="button alt btn btn-success place-order-btn" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e('Place order', 'westpace-material'); ?>" data-value="<?php esc_attr_e('Place order', 'westpace-material'); ?>">
                                            <span class="btn-text"><?php esc_html_e('Place order', 'westpace-material'); ?></span>
                                            <span class="btn-loading" style="display: none;">
                                                <span class="material-icons">hourglass_empty</span>
                                                <?php esc_html_e('Processing...', 'westpace-material'); ?>
                                            </span>
                                        </button>

                                        <?php do_action('woocommerce_review_order_after_submit'); ?>
                                        
                                        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Badge -->
                            <div class="checkout-security-badge">
                                <div class="security-info">
                                    <span class="material-icons">security</span>
                                    <div class="security-text">
                                        <strong><?php _e('Secure Checkout', 'westpace-material'); ?></strong>
                                        <p><?php _e('Your information is protected by SSL encryption', 'westpace-material'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            <?php endif; ?>

            <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
        </div>
    </div>
</main>

<?php get_footer('shop'); ?>