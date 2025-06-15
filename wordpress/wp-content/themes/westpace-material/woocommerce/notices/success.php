<?php
// =================================
// FILE: woocommerce/notices/success.php
// =================================
/**
 * Show success messages
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

if (!$notices) {
    return;
}
?>

<div class="woocommerce-message material-alert alert-success" role="alert">
    <div class="alert-icon">
        <span class="material-icons">check_circle</span>
    </div>
    <div class="alert-content">
        <?php foreach ($notices as $notice) : ?>
            <div class="alert-message"><?php echo wc_kses_notice($notice['notice']); ?></div>
        <?php endforeach; ?>
    </div>
    <button class="alert-close" aria-label="<?php esc_attr_e('Close', 'westpace-material'); ?>">
        <span class="material-icons">close</span>
    </button>
</div>