<?php
// =================================
// FILE: woocommerce/global/wrapper-start.php
// =================================
?>
<main class="site-main woocommerce-page">
    <div class="container">
        <?php
        // Custom breadcrumb for WooCommerce pages
        if (function_exists('westpace_breadcrumb') && !is_shop()) {
            westpace_breadcrumb();
        }
        ?>
        <div class="woocommerce-content">
