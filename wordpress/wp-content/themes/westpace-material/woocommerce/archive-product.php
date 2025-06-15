<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<main class="site-main woocommerce-page shop-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>

        <header class="woocommerce-products-header page-header">
            <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                <h1 class="woocommerce-products-header__title page-title">
                    <?php woocommerce_page_title(); ?>
                </h1>
            <?php endif; ?>

            <?php
            /**
             * Hook: woocommerce_archive_description.
             *
             * @hooked woocommerce_taxonomy_archive_description - 10
             * @hooked woocommerce_product_archive_description - 10
             */
            do_action('woocommerce_archive_description');
            ?>
        </header>

        <div class="shop-content-wrapper">
            
            <!-- Shop Sidebar -->
            <?php if (is_active_sidebar('shop-sidebar')) : ?>
                <aside class="shop-sidebar">
                    <div class="shop-filters">
                        <h3 class="filter-title">
                            <span class="material-icons">tune</span>
                            <?php _e('Filter Products', 'westpace-material'); ?>
                        </h3>
                        <?php dynamic_sidebar('shop-sidebar'); ?>
                    </div>
                </aside>
            <?php endif; ?>

            <!-- Main Shop Content -->
            <div class="shop-main-content">
                
                <?php if (woocommerce_product_loop()) : ?>

                    <?php
                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action('woocommerce_before_shop_loop');
                    ?>

                    <!-- Products Grid -->
                    <div class="products-wrapper">
                        <?php woocommerce_product_loop_start(); ?>

                        <?php if (wc_get_loop_prop('is_shortcode')) : ?>
                            <?php
                            $columns = absint(wc_get_loop_prop('columns'));
                            $wrapper_classes = array(
                                'woocommerce',
                                'columns-' . $columns,
                            );
                            ?>
                            <div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
                        <?php endif; ?>

                        <?php while (have_posts()) : ?>
                            <?php
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                            ?>
                        <?php endwhile; ?>

                        <?php if (wc_get_loop_prop('is_shortcode')) : ?>
                            </div>
                        <?php endif; ?>

                        <?php woocommerce_product_loop_end(); ?>
                    </div>

                    <?php
                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                    ?>

                    <!-- Enhanced Pagination -->
                    <?php if (function_exists('westpace_pagination')) : ?>
                        <div class="shop-pagination">
                            <?php westpace_pagination(); ?>
                        </div>
                    <?php endif; ?>

                <?php else : ?>

                    <!-- No Products Found -->
                    <div class="no-products-found">
                        <div class="empty-shop-state">
                            <div class="empty-shop-icon">
                                <span class="material-icons" style="font-size: 4rem; color: var(--gray-400);">inventory_2</span>
                            </div>
                            <h2><?php _e('No products found', 'westpace-material'); ?></h2>
                            <p><?php _e('Sorry, no products match your criteria. Try adjusting your filters or search terms.', 'westpace-material'); ?></p>
                            
                            <?php if (is_search()) : ?>
                                <div class="search-suggestions">
                                    <h3><?php _e('Search Suggestions:', 'westpace-material'); ?></h3>
                                    <ul>
                                        <li><?php _e('Check your spelling', 'westpace-material'); ?></li>
                                        <li><?php _e('Try more general keywords', 'westpace-material'); ?></li>
                                        <li><?php _e('Try different keywords', 'westpace-material'); ?></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                <span class="material-icons">home</span>
                                <?php _e('Back to Home', 'westpace-material'); ?>
                            </a>
                        </div>
                    </div>

                    <?php
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action('woocommerce_no_products_found');
                    ?>

                <?php endif; ?>

            </div>
        </div>

        <!-- Recently Viewed Products -->
        <?php if (function_exists('westpace_recently_viewed_products')) : ?>
            <div class="recently-viewed-section">
                <?php westpace_recently_viewed_products(); ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>