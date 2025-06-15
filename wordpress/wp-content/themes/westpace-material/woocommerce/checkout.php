<?php
/**
 * Checkout Page Template
 * 
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 */

defined('ABSPATH') || exit;

get_header(); ?>

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
                get_footer();
                return;
            }

            do_action('woocommerce_before_checkout_form');

            // If checkout registration is disabled and not logged in, the user cannot checkout.
            if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
                echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'westpace-material')));
                get_footer();
                return;
            }

            $checkout = WC()->checkout();
            ?>

            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

                <div class="checkout-content">
                    <div class="checkout-billing-shipping">
                        
                        <?php if ($checkout->get_checkout_fields()) : ?>
                            
                            <div class="checkout-step billing-step">
                                <div class="step-header">
                                    <h3>
                                        <span class="step-number">1</span>
                                        <?php _e('Billing Information', 'westpace-material'); ?>
                                    </h3>
                                </div>
                                
                                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                                <div class="woocommerce-billing-fields">
                                    <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>
                                        <h4><?php _e('Billing &amp; Shipping', 'westpace-material'); ?></h4>
                                    <?php else : ?>
                                        <h4><?php _e('Billing Details', 'westpace-material'); ?></h4>
                                    <?php endif; ?>

                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>
                            </div>

                            <?php if (WC()->cart->needs_shipping() && !wc_ship_to_billing_address_only()) : ?>
                                
                                <div class="checkout-step shipping-step">
                                    <div class="step-header">
                                        <h3>
                                            <span class="step-number">2</span>
                                            <?php _e('Shipping Information', 'westpace-material'); ?>
                                        </h3>
                                    </div>
                                    
                                    <div class="woocommerce-shipping-fields">
                                        <h4><?php _e('Ship to a different address?', 'westpace-material'); ?></h4>
                                        
                                        <p class="form-row form-row-wide ship-to-different-address">
                                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                                <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?> type="checkbox" name="ship_to_different_address" value="1" />
                                                <span><?php _e('Ship to a different address?', 'westpace-material'); ?></span>
                                            </label>
                                        </p>

                                        <div class="shipping_address">
                                            <?php do_action('woocommerce_checkout_shipping'); ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                        <?php endif; ?>

                        <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_checkout_order_notes_field'))) : ?>
                            
                            <div class="checkout-step notes-step">
                                <div class="step-header">
                                    <h3>
                                        <span class="step-number">3</span>
                                        <?php _e('Additional Information', 'westpace-material'); ?>
                                    </h3>
                                </div>
                                
                                <div class="woocommerce-additional-fields">
                                    <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                                        <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>

                    <div class="checkout-review-order">
                        <div class="checkout-step review-step">
                            <div class="step-header">
                                <h3>
                                    <span class="step-number">4</span>
                                    <?php _e('Your Order', 'westpace-material'); ?>
                                </h3>
                            </div>
                            
                            <?php do_action('woocommerce_checkout_before_order_review'); ?>

                            <div class="woocommerce-checkout-review-order">
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

<style>
.checkout-page {
    padding: var(--spacing-8) 0;
    background-color: var(--gray-50);
}

.checkout-empty-state {
    text-align: center;
    padding: var(--spacing-12) var(--spacing-6);
    background: white;
    border-radius: var(--rounded-lg);
    box-shadow: var(--elevation-1);
}

.checkout-empty-state h2 {
    margin: var(--spacing-4) 0;
    color: var(--gray-700);
}

.checkout-empty-state p {
    color: var(--gray-600);
    margin-bottom: var(--spacing-6);
}

.checkout-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: var(--spacing-8);
    align-items: start;
}

@media (max-width: 1024px) {
    .checkout-content {
        grid-template-columns: 1fr;
        gap: var(--spacing-6);
    }
    
    .checkout-review-order {
        order: -1;
    }
}

.checkout-step {
    background: white;
    border-radius: var(--rounded-lg);
    box-shadow: var(--elevation-1);
    margin-bottom: var(--spacing-6);
    overflow: hidden;
}

.step-header {
    background: var(--primary-50);
    padding: var(--spacing-4) var(--spacing-6);
    border-bottom: 1px solid var(--primary-100);
}

.step-header h3 {
    display: flex;
    align-items: center;
    gap: var(--spacing-3);
    margin: 0;
    color: var(--primary-700);
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
}

.step-number {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--primary-600);
    color: white;
    border-radius: 50%;
    font-size: var(--text-sm);
    font-weight: var(--font-weight-bold);
}

.woocommerce-billing-fields,
.woocommerce-shipping-fields,
.woocommerce-additional-fields,
.woocommerce-checkout-review-order {
    padding: var(--spacing-6);
}

.woocommerce-billing-fields h4,
.woocommerce-shipping-fields h4,
.woocommerce-additional-fields h4 {
    margin-bottom: var(--spacing-4);
    color: var(--gray-800);
    font-size: var(--text-base);
    font-weight: var(--font-weight-semibold);
}

/* Checkout form styling */
.form-row {
    margin-bottom: var(--spacing-4);
}

.form-row label {
    display: block;
    margin-bottom: var(--spacing-2);
    font-weight: var(--font-weight-medium);
    color: var(--gray-700);
}

.form-row input[type="text"],
.form-row input[type="email"],
.form-row input[type="tel"],
.form-row textarea,
.form-row select {
    width: 100%;
    padding: var(--spacing-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--rounded-md);
    font-size: var(--text-base);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.form-row input:focus,
.form-row textarea:focus,
.form-row select:focus {
    outline: none;
    border-color: var(--primary-600);
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.form-row-first,
.form-row-last {
    width: calc(50% - var(--spacing-2));
    display: inline-block;
}

.form-row-first {
    margin-right: var(--spacing-4);
}

@media (max-width: 768px) {
    .form-row-first,
    .form-row-last {
        width: 100%;
        margin-right: 0;
    }
}

/* Shipping toggle */
.ship-to-different-address {
    background: var(--gray-50);
    padding: var(--spacing-4);
    border-radius: var(--rounded-md);
    margin-bottom: var(--spacing-4);
}

.ship-to-different-address label {
    display: flex;
    align-items: center;
    gap: var(--spacing-3);
    margin: 0;
    cursor: pointer;
}

.ship-to-different-address input[type="checkbox"] {
    width: auto;
    margin: 0;
}

/* Order review styling */
.checkout-review-order {
    position: sticky;
    top: var(--spacing-6);
}

/* Payment methods */
.wc_payment_methods {
    list-style: none;
    margin: 0;
    padding: 0;
}

.wc_payment_methods li {
    background: var(--gray-50);
    margin-bottom: var(--spacing-2);
    border-radius: var(--rounded-md);
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.wc_payment_methods li input {
    margin: var(--spacing-3);
}

.wc_payment_methods li label {
    display: block;
    padding: var(--spacing-3) var(--spacing-4);
    cursor: pointer;
    font-weight: var(--font-weight-medium);
    margin: 0;
}

.wc_payment_methods li.payment_method_selected {
    background: var(--primary-50);
    border-color: var(--primary-200);
}

/* Place order button */
#place_order {
    width: 100%;
    padding: var(--spacing-4) var(--spacing-6);
    background-color: var(--primary-600);
    color: white;
    border: none;
    border-radius: var(--rounded-md);
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    cursor: pointer;
    transition: all var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-2);
}

#place_order:hover {
    background-color: var(--primary-700);
    transform: translateY(-1px);
    box-shadow: var(--elevation-2);
}

#place_order:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Loading state */
.checkout.processing {
    opacity: 0.7;
    pointer-events: none;
}

.checkout.processing::after {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Error messages */
.woocommerce-error,
.woocommerce-message {
    padding: var(--spacing-4);
    border-radius: var(--rounded-md);
    margin-bottom: var(--spacing-4);
}

.woocommerce-error {
    background-color: var(--error-50);
    border: 1px solid var(--error-200);
    color: var(--error-700);
}

.woocommerce-message {
    background-color: var(--success-50);
    border: 1px solid var(--success-200);
    color: var(--success-700);
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
</style>

<?php get_footer(); ?>