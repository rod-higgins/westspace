<?php
/**
 * Single Product Page Template
 * 
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 */

defined('ABSPATH') || exit;

get_header(); ?>

<main class="site-main woocommerce-page single-product-page">
    <div class="container">
        
        <?php
        // Custom breadcrumb for product
        if (function_exists('westpace_breadcrumb')) {
            westpace_breadcrumb();
        }
        ?>

        <?php while (have_posts()) : the_post(); ?>
            
            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
                
                <?php
                /**
                 * Hook: woocommerce_before_single_product.
                 *
                 * @hooked woocommerce_output_all_notices - 10
                 */
                do_action('woocommerce_before_single_product');
                
                if (post_password_required()) {
                    echo get_the_password_form(); // PHPCS: XSS ok.
                    return;
                }
                ?>

                <div class="product-container">
                    
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

                            <div class="product-actions">
                                <div class="product-share">
                                    <h4><?php _e('Share this product', 'westpace-material'); ?></h4>
                                    <div class="share-buttons">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                                           target="_blank" 
                                           rel="noopener"
                                           class="share-button facebook">
                                            <span class="material-icons">facebook</span>
                                            <?php _e('Facebook', 'westpace-material'); ?>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                           target="_blank" 
                                           rel="noopener"
                                           class="share-button twitter">
                                            <span class="material-icons">share</span>
                                            <?php _e('Twitter', 'westpace-material'); ?>
                                        </a>
                                        <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" 
                                           class="share-button email">
                                            <span class="material-icons">email</span>
                                            <?php _e('Email', 'westpace-material'); ?>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-wishlist">
                                    <button type="button" class="wishlist-button" aria-label="<?php _e('Add to wishlist', 'westpace-material'); ?>">
                                        <span class="material-icons">favorite_border</span>
                                        <?php _e('Add to Wishlist', 'westpace-material'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details-section">
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

                <?php do_action('woocommerce_after_single_product'); ?>

            </div>

        <?php endwhile; ?>

        <?php
        // Recently viewed products
        if (function_exists('wc_get_template')) {
            echo '<div class="recently-viewed-products">';
            echo '<h3>' . __('Recently Viewed Products', 'westpace-material') . '</h3>';
            // This would need custom implementation
            echo '</div>';
        }
        ?>

    </div>
</main>

<style>
.single-product-page {
    padding: var(--spacing-6) 0;
}

.product-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-8);
    align-items: start;
    margin-bottom: var(--spacing-12);
}

@media (max-width: 768px) {
    .product-container {
        grid-template-columns: 1fr;
        gap: var(--spacing-6);
    }
}

/* Product Gallery */
.product-gallery-section {
    position: relative;
}

.woocommerce-product-gallery {
    position: relative;
}

.woocommerce-product-gallery__wrapper {
    border-radius: var(--rounded-lg);
    overflow: hidden;
    box-shadow: var(--elevation-2);
    background: white;
}

.woocommerce-product-gallery__image {
    position: relative;
    overflow: hidden;
}

.woocommerce-product-gallery__image img {
    width: 100%;
    height: auto;
    transition: transform var(--transition-normal);
}

.woocommerce-product-gallery__image:hover img {
    transform: scale(1.05);
}

.woocommerce-product-gallery .flex-control-thumbs {
    display: flex;
    gap: var(--spacing-3);
    margin-top: var(--spacing-4);
    justify-content: center;
}

.woocommerce-product-gallery .flex-control-thumbs li {
    list-style: none;
    margin: 0;
}

.woocommerce-product-gallery .flex-control-thumbs img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--rounded-md);
    cursor: pointer;
    opacity: 0.7;
    transition: opacity var(--transition-fast);
}

.woocommerce-product-gallery .flex-control-thumbs img.flex-active,
.woocommerce-product-gallery .flex-control-thumbs img:hover {
    opacity: 1;
}

/* Product Summary */
.product-summary-section {
    padding: var(--spacing-6);
    background: white;
    border-radius: var(--rounded-lg);
    box-shadow: var(--elevation-1);
}

.product_title {
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    margin-bottom: var(--spacing-4);
    color: var(--gray-900);
    line-height: var(--leading-tight);
}

.woocommerce-product-rating {
    display: flex;
    align-items: center;
    gap: var(--spacing-3);
    margin-bottom: var(--spacing-4);
}

.star-rating {
    color: var(--warning-400);
}

.woocommerce-review-link {
    color: var(--primary-600);
    text-decoration: none;
    font-size: var(--text-sm);
}

.woocommerce-review-link:hover {
    color: var(--primary-700);
}

.price {
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--primary-600);
    margin-bottom: var(--spacing-6);
    display: block;
}

.price del {
    color: var(--gray-400);
    font-weight: var(--font-weight-normal);
    margin-right: var(--spacing-3);
    font-size: var(--text-xl);
}

.woocommerce-product-details__short-description {
    font-size: var(--text-lg);
    line-height: var(--leading-relaxed);
    color: var(--gray-700);
    margin-bottom: var(--spacing-6);
}

/* Product Form */
form.cart {
    background: var(--gray-50);
    padding: var(--spacing-6);
    border-radius: var(--rounded-lg);
    margin-bottom: var(--spacing-6);
}

.quantity {
    display: flex;
    align-items: center;
    gap: var(--spacing-3);
    margin-bottom: var(--spacing-4);
}

.quantity label {
    font-weight: var(--font-weight-medium);
    color: var(--gray-700);
    margin: 0;
}

.quantity .qty {
    width: 80px;
    padding: var(--spacing-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--rounded-md);
    text-align: center;
    font-size: var(--text-base);
}

.single_add_to_cart_button {
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

.single_add_to_cart_button:hover {
    background-color: var(--primary-700);
    transform: translateY(-1px);
    box-shadow: var(--elevation-2);
}

.single_add_to_cart_button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Product Meta */
.product_meta {
    padding: var(--spacing-4) 0;
    border-top: 1px solid var(--gray-200);
    font-size: var(--text-sm);
    color: var(--gray-600);
}

.product_meta > span {
    display: block;
    margin-bottom: var(--spacing-2);
}

.product_meta a {
    color: var(--primary-600);
    text-decoration: none;
}

.product_meta a:hover {
    color: var(--primary-700);
}

/* Product Actions */
.product-actions {
    margin-top: var(--spacing-6);
    padding-top: var(--spacing-6);
    border-top: 1px solid var(--gray-200);
}

.product-share,
.product-wishlist {
    margin-bottom: var(--spacing-4);
}

.product-share h4,
.product-wishlist h4 {
    font-size: var(--text-base);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-3);
    color: var(--gray-800);
}

.share-buttons {
    display: flex;
    gap: var(--spacing-3);
    flex-wrap: wrap;
}

.share-button {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-2);
    padding: var(--spacing-2) var(--spacing-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--rounded-md);
    color: var(--gray-700);
    text-decoration: none;
    font-size: var(--text-sm);
    transition: all var(--transition-fast);
}

.share-button:hover {
    background-color: var(--gray-100);
    border-color: var(--gray-400);
    color: var(--gray-800);
}

.share-button.facebook:hover {
    background-color: #1877f2;
    border-color: #1877f2;
    color: white;
}

.share-button.twitter:hover {
    background-color: #1da1f2;
    border-color: #1da1f2;
    color: white;
}

.wishlist-button {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-2);
    padding: var(--spacing-3) var(--spacing-4);
    background: transparent;
    border: 1px solid var(--gray-300);
    border-radius: var(--rounded-md);
    color: var(--gray-700);
    font-size: var(--text-sm);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.wishlist-button:hover {
    background-color: var(--error-50);
    border-color: var(--error-300);
    color: var(--error-700);
}

.wishlist-button.added {
    background-color: var(--error-500);
    border-color: var(--error-500);
    color: white;
}

.wishlist-button.added .material-icons {
    content: 'favorite';
}

/* Product Details Section */
.product-details-section {
    margin-top: var(--spacing-12);
}

/* Product Tabs */
.woocommerce-tabs {
    background: white;
    border-radius: var(--rounded-lg);
    box-shadow: var(--elevation-1);
    overflow: hidden;
}

.woocommerce-tabs ul.tabs {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.woocommerce-tabs ul.tabs li {
    margin: 0;
    padding: 0;
    background: none;
    border: none;
}

.woocommerce-tabs ul.tabs li a {
    display: block;
    padding: var(--spacing-4) var(--spacing-6);
    color: var(--gray-600);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
    border-bottom: 3px solid transparent;
    transition: all var(--transition-fast);
}

.woocommerce-tabs ul.tabs li.active a,
.woocommerce-tabs ul.tabs li a:hover {
    color: var(--primary-600);
    border-bottom-color: var(--primary-600);
    background: white;
}

.woocommerce-tabs .panel {
    padding: var(--spacing-8);
}

.woocommerce-tabs .panel h2 {
    margin-top: 0;
    margin-bottom: var(--spacing-4);
    color: var(--gray-900);
}

/* Related Products */
.related.products,
.upsells.products {
    margin-top: var(--spacing-12);
}

.related.products h2,
.upsells.products h2 {
    text-align: center;
    margin-bottom: var(--spacing-8);
    font-size: var(--text-2xl);
    color: var(--gray-900);
}

/* Recently Viewed */
.recently-viewed-products {
    margin-top: var(--spacing-12);
    padding: var(--spacing-8);
    background: white;
    border-radius: var(--rounded-lg);
    box-shadow: var(--elevation-1);
}

.recently-viewed-products h3 {
    text-align: center;
    margin-bottom: var(--spacing-6);
    color: var(--gray-900);
}

/* Sale badge */
.onsale {
    position: absolute;
    top: var(--spacing-4);
    left: var(--spacing-4);
    background-color: var(--error-500);
    color: white;
    padding: var(--spacing-2) var(--spacing-3);
    border-radius: var(--rounded-full);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-bold);
    z-index: 10;
}

/* Loading states */
.single_add_to_cart_button.loading {
    opacity: 0.7;
    cursor: not-allowed;
}

.single_add_to_cart_button.loading::after {
    content: '';
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid currentColor;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wishlist functionality
    const wishlistButton = document.querySelector('.wishlist-button');
    if (wishlistButton) {
        wishlistButton.addEventListener('click', function() {
            this.classList.toggle('added');
            const icon = this.querySelector('.material-icons');
            const text = this.querySelector('span:last-child') || this.childNodes[this.childNodes.length - 1];
            
            if (this.classList.contains('added')) {
                icon.textContent = 'favorite';
                if (text && text.textContent) {
                    text.textContent = '<?php _e("Added to Wishlist", "westpace-material"); ?>';
                }
            } else {
                icon.textContent = 'favorite_border';
                if (text && text.textContent) {
                    text.textContent = '<?php _e("Add to Wishlist", "westpace-material"); ?>';
                }
            }
        });
    }
    
    // Quantity controls
    const quantityInput = document.querySelector('.qty');
    if (quantityInput) {
        // Add plus/minus buttons
        const quantityWrapper = quantityInput.parentElement;
        quantityWrapper.classList.add('quantity-controls');
        
        const minusBtn = document.createElement('button');
        minusBtn.type = 'button';
        minusBtn.classList.add('qty-btn', 'qty-minus');
        minusBtn.innerHTML = '<span class="material-icons">remove</span>';
        
        const plusBtn = document.createElement('button');
        plusBtn.type = 'button';
        plusBtn.classList.add('qty-btn', 'qty-plus');
        plusBtn.innerHTML = '<span class="material-icons">add</span>';
        
        quantityInput.parentNode.insertBefore(minusBtn, quantityInput);
        quantityInput.parentNode.insertBefore(plusBtn, quantityInput.nextSibling);
        
        minusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            const minValue = parseInt(quantityInput.min) || 1;
            if (currentValue > minValue) {
                quantityInput.value = currentValue - 1;
                quantityInput.dispatchEvent(new Event('change'));
            }
        });
        
        plusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.max) || 999;
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
                quantityInput.dispatchEvent(new Event('change'));
            }
        });
    }
});
</script>

<style>
.quantity-controls {
    display: flex !important;
    align-items: center;
    border: 1px solid var(--gray-300);
    border-radius: var(--rounded-md);
    overflow: hidden;
    width: fit-content;
}

.qty-btn {
    background: var(--gray-100);
    border: none;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.qty-btn:hover {
    background: var(--gray-200);
}

.qty-btn .material-icons {
    font-size: 18px;
}

.quantity-controls .qty {
    border: none;
    width: 60px;
    height: 40px;
    text-align: center;
    background: white;
}

.quantity-controls .qty:focus {
    box-shadow: none;
}
</style>

<?php get_footer(); ?>