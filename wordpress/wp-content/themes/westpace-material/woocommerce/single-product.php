<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<main class="site-main single-product-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>

        <?php while (have_posts()) : ?>
            <?php the_post(); ?>

            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
                
                <div class="product-layout">
                    
                    <!-- Product Gallery -->
                    <div class="product-gallery-section">
                        <?php
                        /**
                         * Hook: woocommerce_before_single_product_summary.
                         *
                         * @hooked woocommerce_show_product_sale_flash - 10
                         * @hooked woocommerce_show_product_images - 20
                         */
                        do_action('woocommerce_before_single_product_summary');
                        ?>
                    </div>

                    <!-- Product Summary -->
                    <div class="product-summary-section">
                        <div class="summary entry-summary">
                            <?php
                            /**
                             * Hook: woocommerce_single_product_summary.
                             *
                             * @hooked woocommerce_template_single_title - 5
                             * @hooked woocommerce_template_single_rating - 10
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             * @hooked WC_Structured_Data::generate_product_data() - 60
                             */
                            do_action('woocommerce_single_product_summary');
                            ?>
                        </div>
                    </div>

                </div>

                <!-- Product Tabs & Related Products -->
                <div class="product-additional-info">
                    <?php
                    /**
                     * Hook: woocommerce_after_single_product_summary.
                     *
                     * @hooked woocommerce_output_product_data_tabs - 10
                     * @hooked woocommerce_upsell_display - 15
                     * @hooked woocommerce_output_related_products - 20
                     */
                    do_action('woocommerce_after_single_product_summary');
                    ?>
                </div>

            </div>

        <?php endwhile; // end of the loop. ?>

    </div>
</main>

<?php
do_action('woocommerce_after_single_product');

get_footer('shop');
?>