<?php
// =================================
// FILE: woocommerce/global/quantity-input.php
// =================================
/**
 * Product quantity inputs
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden">
        <input type="hidden" id="<?php echo esc_attr($input_id); ?>" class="qty" name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($min_value); ?>" />
    </div>
    <?php
} else {
    /* translators: %s: Quantity. */
    $label = !empty($args['product_name']) ? sprintf(esc_html__('Quantity for &ldquo;%s&rdquo;', 'westpace-material'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'westpace-material');
    ?>
    <div class="quantity-wrapper">
        <?php do_action('woocommerce_before_quantity_input_field'); ?>
        <label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_attr($label); ?></label>
        
        <div class="quantity-controls">
            <button type="button" class="minus btn-quantity" aria-label="<?php esc_attr_e('Decrease quantity', 'westpace-material'); ?>">
                <span class="material-icons">remove</span>
            </button>
            
            <input
                type="number"
                id="<?php echo esc_attr($input_id); ?>"
                class="input-text qty text"
                step="<?php echo esc_attr($step); ?>"
                min="<?php echo esc_attr($min_value); ?>"
                max="<?php echo esc_attr(0 < $max_value ? $max_value : ''); ?>"
                name="<?php echo esc_attr($input_name); ?>"
                value="<?php echo esc_attr($input_value); ?>"
                title="<?php echo esc_attr_x('Qty', 'Product quantity input tooltip', 'westpace-material'); ?>"
                size="4"
                placeholder="<?php echo esc_attr($placeholder); ?>"
                inputmode="<?php echo esc_attr($inputmode); ?>" />
            
            <button type="button" class="plus btn-quantity" aria-label="<?php esc_attr_e('Increase quantity', 'westpace-material'); ?>">
                <span class="material-icons">add</span>
            </button>
        </div>
        
        <?php do_action('woocommerce_after_quantity_input_field'); ?>
    </div>
    <?php
}