<?php
/**
 * Westpace Material Design Enhanced Theme Functions
 * Modern, secure, and performance-optimized WordPress theme functions
 * With comprehensive WooCommerce integration
 * 
 * @package Westpace_Material
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme version and constants
define('WESTPACE_VERSION', '3.0.0');
define('WESTPACE_THEME_DIR', get_template_directory());
define('WESTPACE_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function westpace_setup() {
    // Make theme available for translation
    load_theme_textdomain('westpace-material', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 240,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Responsive embeds
    add_theme_support('responsive-embeds');

    // Block patterns
    add_theme_support('core-block-patterns');

    // Custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'westpace-material'),
        'footer'  => esc_html__('Footer Menu', 'westpace-material'),
        'mobile'  => esc_html__('Mobile Menu', 'westpace-material'),
    ));

    // WooCommerce support
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 4,
        ),
    ));

    // WooCommerce gallery support
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'westpace_setup');

/**
 * Set the content width in pixels
 */
function westpace_content_width() {
    $GLOBALS['content_width'] = apply_filters('westpace_content_width', 1200);
}
add_action('after_setup_theme', 'westpace_content_width', 0);

/**
 * Register widget areas
 */
function westpace_widgets_init() {
    // Main sidebar
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'westpace-material'),
        'before_widget' => '<section id="%1$s" class="widget material-card elevation-2 %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget %d', 'westpace-material'), $i),
            'id'            => "footer-widget-$i",
            'description'   => sprintf(__('Add widgets here to appear in footer column %d.', 'westpace-material'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
    }

    // Shop sidebar (if WooCommerce is active)
    if (class_exists('WooCommerce')) {
        register_sidebar(array(
            'name'          => __('Shop Sidebar', 'westpace-material'),
            'id'            => 'shop-sidebar',
            'description'   => __('Add widgets here to appear in the shop sidebar.', 'westpace-material'),
            'before_widget' => '<section id="%1$s" class="widget shop-widget material-card elevation-1 %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'westpace_widgets_init');

/**
 * Enqueue scripts and styles
 */
function westpace_scripts() {
    $version = WESTPACE_VERSION;
    
    // CSS Files
    wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons+Round&display=swap', array(), $version);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap', array(), $version);
    wp_enqueue_style('westpace-material', WESTPACE_THEME_URI . '/assets/css/material-design.css', array(), $version);
    wp_enqueue_style('westpace-style', get_stylesheet_uri(), array('westpace-material'), $version);

    // WooCommerce styles
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
        wp_enqueue_style('westpace-woocommerce', WESTPACE_THEME_URI . '/assets/css/woocommerce.css', array('westpace-material'), $version);
    }

    // JavaScript
    wp_enqueue_script('westpace-theme-js', WESTPACE_THEME_URI . '/assets/js/theme.js', array('jquery'), $version, true);

    // Localize script for AJAX
    wp_localize_script('westpace-theme-js', 'westpaceData', array(
        'ajaxUrl'     => admin_url('admin-ajax.php'),
        'nonce'       => wp_create_nonce('westpace_nonce'),
        'homeUrl'     => home_url('/'),
        'themeUri'    => WESTPACE_THEME_URI,
        'isWooActive' => class_exists('WooCommerce'),
        'strings'     => array(
            'loading'           => __('Loading...', 'westpace-material'),
            'addedToCart'       => __('Product added to cart!', 'westpace-material'),
            'cartError'         => __('Error adding product to cart.', 'westpace-material'),
            'newsletterSuccess' => __('Thank you for subscribing!', 'westpace-material'),
            'newsletterError'   => __('Subscription failed. Please try again.', 'westpace-material'),
        ),
    ));

    // Comments script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'westpace_scripts');

/**
 * Custom excerpt length
 */
function westpace_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'westpace_excerpt_length');

function westpace_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'westpace_excerpt_more');

/**
 * Custom pagination function
 */
function westpace_pagination() {
    global $wp_query;

    $total = $wp_query->max_num_pages;
    if ($total < 2) return;

    $current_page = max(1, get_query_var('paged'));
    $permalink_structure = get_option('permalink_structure');
    $format = empty($permalink_structure) ? '&page=%#%' : 'page/%#%/';

    echo '<nav class="pagination-nav" role="navigation" aria-label="' . __('Posts navigation', 'westpace-material') . '">';
    echo '<ul class="pagination">';

    echo paginate_links(array(
        'base'      => get_pagenum_link(1) . '%_%',
        'format'    => $format,
        'current'   => $current_page,
        'total'     => $total,
        'mid_size'  => 2,
        'end_size'  => 1,
        'prev_text' => '<span class="material-icons">chevron_left</span>' . __('Previous', 'westpace-material'),
        'next_text' => __('Next', 'westpace-material') . '<span class="material-icons">chevron_right</span>',
        'type'      => 'list',
    ));

    echo '</ul>';
    echo '</nav>';
}

/**
 * Custom breadcrumb function
 */
function westpace_breadcrumb() {
    if (is_front_page()) return;

    echo '<nav class="breadcrumb-nav" aria-label="' . __('Breadcrumb', 'westpace-material') . '">';
    echo '<ol class="breadcrumb">';
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'westpace-material') . '</a></li>';

    if (class_exists('WooCommerce') && is_woocommerce()) {
        if (is_shop()) {
            echo '<li class="breadcrumb-item active">' . get_the_title(wc_get_page_id('shop')) . '</li>';
        } elseif (is_product_category() || is_product_tag()) {
            $current_term = $GLOBALS['wp_query']->get_queried_object();
            if (is_product_category()) {
                echo '<li class="breadcrumb-item"><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . get_the_title(wc_get_page_id('shop')) . '</a></li>';
                if ($current_term->parent) {
                    $parent = get_term($current_term->parent, 'product_cat');
                    echo '<li class="breadcrumb-item"><a href="' . esc_url(get_term_link($parent)) . '">' . esc_html($parent->name) . '</a></li>';
                }
            }
            echo '<li class="breadcrumb-item active">' . esc_html($current_term->name) . '</li>';
        } elseif (is_product()) {
            echo '<li class="breadcrumb-item"><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . get_the_title(wc_get_page_id('shop')) . '</a></li>';
            $product_cats = wp_get_post_terms(get_the_ID(), 'product_cat');
            if ($product_cats) {
                $cat = $product_cats[0];
                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
            }
            echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        }
    } elseif (is_category()) {
        $category = get_category(get_query_var('cat'));
        if ($category->parent != 0) {
            $parent_category = get_category($category->parent);
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($parent_category->term_id)) . '">' . esc_html($parent_category->name) . '</a></li>';
        }
        echo '<li class="breadcrumb-item active">' . esc_html($category->name) . '</li>';
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
        }
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
    } elseif (is_page()) {
        $page = get_post();
        if ($page->post_parent) {
            $parent_id = $page->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                echo $crumb;
            }
        }
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active">' . __('Search Results', 'westpace-material') . '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumb-item active">' . __('404 Not Found', 'westpace-material') . '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

/**
 * Include required files
 */
$include_files = array(
    '/inc/customizer.php',
    '/inc/template-functions.php',
    '/inc/class-walker-nav-menu.php',
);

foreach ($include_files as $file) {
    $file_path = WESTPACE_THEME_DIR . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

/**
 * ==========================================
 * COMPREHENSIVE WOOCOMMERCE INTEGRATION
 * ==========================================
 */

if (class_exists('WooCommerce')) {

    /**
     * Remove default WooCommerce styles
     */
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');

    /**
     * WooCommerce Theme Support Declaration
     */
    function westpace_woocommerce_support() {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
    add_action('after_setup_theme', 'westpace_woocommerce_support');

    /**
     * Customize WooCommerce settings
     */
    
    // Change number of products per page
    function westpace_woocommerce_products_per_page() {
        return get_theme_mod('woocommerce_products_per_page', 12);
    }
    add_filter('loop_shop_per_page', 'westpace_woocommerce_products_per_page', 20);

    // Change number of product columns
    function westpace_woocommerce_loop_columns() {
        return get_theme_mod('woocommerce_product_columns', 3);
    }
    add_filter('woocommerce_loop_columns', 'westpace_woocommerce_loop_columns');

    // Change number of related products
    function westpace_related_products_args($args) {
        $args['posts_per_page'] = 4;
        $args['columns'] = 4;
        return $args;
    }
    add_filter('woocommerce_output_related_products_args', 'westpace_related_products_args');

    // Change number of upsells
    function westpace_upsell_display() {
        woocommerce_upsell_display(4, 4);
    }
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    add_action('woocommerce_after_single_product_summary', 'westpace_upsell_display', 15);

    // Change number of cross-sells
    function westpace_cross_sell_display() {
        woocommerce_cross_sell_display(4, 4);
    }
    remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
    add_action('woocommerce_cart_collaterals', 'westpace_cross_sell_display');

    /**
     * Customize add to cart button
     */
    function westpace_woocommerce_loop_add_to_cart_button($button, $product) {
        $button_text = $product->add_to_cart_text();
        $button_class = 'add-to-cart-btn btn btn-primary';
        
        if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) {
            $button_class .= ' ajax_add_to_cart';
        }

        $button = sprintf(
            '<a href="%s" data-quantity="1" class="%s" data-product_id="%s" data-product_sku="%s" aria-label="%s" rel="nofollow">
                <span class="btn-text">%s</span>
                <span class="btn-icon material-icons">add_shopping_cart</span>
            </a>',
            esc_url($product->add_to_cart_url()),
            esc_attr($button_class),
            esc_attr($product->get_id()),
            esc_attr($product->get_sku()),
            esc_attr($button_text),
            esc_html($button_text)
        );

        return $button;
    }
    add_filter('woocommerce_loop_add_to_cart_link', 'westpace_woocommerce_loop_add_to_cart_button', 10, 2);

    /**
     * Enhanced Cart Fragments for AJAX
     */
    function westpace_cart_count_fragments($fragments) {
        $fragments['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
        $fragments['.cart-total'] = '<span class="cart-total">' . WC()->cart->get_cart_subtotal() . '</span>';
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'westpace_cart_count_fragments');

    /**
     * Custom single product layout
     */
    function westpace_single_product_summary() {
        echo '<div class="product-summary-wrapper">';
    }
    add_action('woocommerce_single_product_summary', 'westpace_single_product_summary', 1);

    function westpace_single_product_summary_end() {
        echo '</div>';
    }
    add_action('woocommerce_single_product_summary', 'westpace_single_product_summary_end', 65);

    /**
     * Add custom product badges
     */
    function westpace_product_badges() {
        global $product;
        
        $badges = array();
        
        // New product badge (products newer than 30 days)
        $created = strtotime($product->get_date_created());
        if ((time() - $created) < (30 * 24 * 60 * 60)) {
            $badges[] = '<span class="product-badge badge-new">' . __('New', 'westpace-material') . '</span>';
        }
        
        // Featured product badge
        if ($product->is_featured()) {
            $badges[] = '<span class="product-badge badge-featured">' . __('Featured', 'westpace-material') . '</span>';
        }
        
        // Low stock badge
        if ($product->is_in_stock() && $product->get_stock_quantity() && $product->get_stock_quantity() <= 5) {
            $badges[] = '<span class="product-badge badge-low-stock">' . __('Low Stock', 'westpace-material') . '</span>';
        }
        
        if (!empty($badges)) {
            echo '<div class="product-badges">' . implode('', $badges) . '</div>';
        }
    }
    add_action('woocommerce_before_shop_loop_item_title', 'westpace_product_badges', 15);

    /**
     * Recently viewed products
     */
    function westpace_track_product_view() {
        if (!is_singular('product')) {
            return;
        }

        global $post;
        if (empty($_COOKIE['woocommerce_recently_viewed'])) {
            $viewed_products = array();
        } else {
            $viewed_products = (array) explode('|', $_COOKIE['woocommerce_recently_viewed']);
        }

        if (!in_array($post->ID, $viewed_products)) {
            $viewed_products[] = $post->ID;
        }

        if (count($viewed_products) > 15) {
            array_shift($viewed_products);
        }

        wc_setcookie('woocommerce_recently_viewed', implode('|', $viewed_products));
    }
    add_action('template_redirect', 'westpace_track_product_view', 20);

    function westpace_recently_viewed_products($number = 5) {
        if (empty($_COOKIE['woocommerce_recently_viewed'])) {
            return;
        }

        $viewed_products = (array) explode('|', $_COOKIE['woocommerce_recently_viewed']);
        $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));

        if (empty($viewed_products)) {
            return;
        }

        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'post__in'       => $viewed_products,
            'orderby'        => 'post__in',
        );

        $products = new WP_Query($query_args);

        if ($products->have_posts()) {
            echo '<div class="recently-viewed-products">';
            echo '<h3>' . __('Recently Viewed Products', 'westpace-material') . '</h3>';
            echo '<ul class="products columns-' . $number . '">';
            
            while ($products->have_posts()) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }
            
            echo '</ul>';
            echo '</div>';
        }

        wp_reset_postdata();
    }

    /**
     * Custom checkout fields
     */
    function westpace_checkout_fields($fields) {
        // Add phone number field
        $fields['billing']['billing_phone']['class'] = array('form-row-wide');
        $fields['billing']['billing_phone']['priority'] = 100;
        
        // Make email field wider
        $fields['billing']['billing_email']['class'] = array('form-row-wide');
        
        return $fields;
    }
    add_filter('woocommerce_checkout_fields', 'westpace_checkout_fields');

    /**
     * Add estimated delivery date
     */
    function westpace_estimated_delivery() {
        $estimated_date = date('M j, Y', strtotime('+3 days'));
        echo '<div class="estimated-delivery">';
        echo '<span class="material-icons">local_shipping</span>';
        echo '<span>' . sprintf(__('Estimated delivery: %s', 'westpace-material'), $estimated_date) . '</span>';
        echo '</div>';
    }
    add_action('woocommerce_single_product_summary', 'westpace_estimated_delivery', 25);

    /**
     * Product share buttons
     */
    function westpace_product_share() {
        global $product;
        
        $product_title = get_the_title();
        $product_url = get_permalink();
        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        
        echo '<div class="product-share">';
        echo '<h4>' . __('Share this product', 'westpace-material') . '</h4>';
        echo '<div class="share-buttons">';
        
        // Facebook
        echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($product_url) . '" target="_blank" class="share-btn facebook" aria-label="' . __('Share on Facebook', 'westpace-material') . '">';
        echo '<span class="share-icon">📘</span>';
        echo '</a>';
        
        // Twitter
        echo '<a href="https://twitter.com/intent/tweet?text=' . urlencode($product_title) . '&url=' . urlencode($product_url) . '" target="_blank" class="share-btn twitter" aria-label="' . __('Share on Twitter', 'westpace-material') . '">';
        echo '<span class="share-icon">🐦</span>';
        echo '</a>';
        
        // Pinterest
        if ($product_image) {
            echo '<a href="https://pinterest.com/pin/create/button/?url=' . urlencode($product_url) . '&media=' . urlencode($product_image[0]) . '&description=' . urlencode($product_title) . '" target="_blank" class="share-btn pinterest" aria-label="' . __('Share on Pinterest', 'westpace-material') . '">';
            echo '<span class="share-icon">📌</span>';
            echo '</a>';
        }
        
        // WhatsApp (mobile)
        echo '<a href="https://wa.me/?text=' . urlencode($product_title . ' ' . $product_url) . '" target="_blank" class="share-btn whatsapp" aria-label="' . __('Share on WhatsApp', 'westpace-material') . '">';
        echo '<span class="share-icon">💬</span>';
        echo '</a>';
        
        echo '</div>';
        echo '</div>';
    }
    add_action('woocommerce_single_product_summary', 'westpace_product_share', 55);

    /**
     * Custom mini cart
     */
    function westpace_mini_cart() {
        echo '<div class="mini-cart-wrapper">';
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="mini-cart-trigger">';
        echo '<span class="material-icons">shopping_cart</span>';
        echo '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
        echo '<span class="cart-total">' . WC()->cart->get_cart_subtotal() . '</span>';
        echo '</a>';
        echo '<div class="mini-cart-dropdown">';
        echo '<div class="widget_shopping_cart_content">';
        woocommerce_mini_cart();
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Enhanced product search with AJAX
     */
    function westpace_ajax_product_search() {
        check_ajax_referer('westpace_nonce', 'nonce');
        
        $keyword = sanitize_text_field($_POST['keyword']);
        
        if (strlen($keyword) < 3) {
            wp_die();
        }
        
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 8,
            's'              => $keyword,
            'meta_query'     => array(
                array(
                    'key'     => '_visibility',
                    'value'   => array('catalog', 'visible'),
                    'compare' => 'IN'
                )
            )
        );
        
        $products = new WP_Query($args);
        $results = array();
        
        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                global $product;
                
                $results[] = array(
                    'id'    => get_the_ID(),
                    'title' => get_the_title(),
                    'url'   => get_permalink(),
                    'price' => $product->get_price_html(),
                    'image' => wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail')[0],
                );
            }
        }
        
        wp_reset_postdata();
        wp_send_json_success($results);
    }
    add_action('wp_ajax_westpace_product_search', 'westpace_ajax_product_search');
    add_action('wp_ajax_nopriv_westpace_product_search', 'westpace_ajax_product_search');

} // End WooCommerce integration

/**
 * Security enhancements
 */
// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary meta tags
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// Hide login errors
function westpace_login_errors() {
    return __('Something is wrong!', 'westpace-material');
}
add_filter('login_errors', 'westpace_login_errors');

/**
 * Performance optimizations
 */
// Defer JavaScript loading
function westpace_defer_scripts($tag, $handle, $src) {
    if (is_admin()) return $tag;
    
    $defer_scripts = array('westpace-theme-js');
    
    if (in_array($handle, $defer_scripts)) {
        return '<script src="' . $src . '" defer></script>' . "\n";
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'westpace_defer_scripts', 10, 3);

// Optimize database queries
function westpace_optimize_queries() {
    if (!is_admin()) {
        // Remove unnecessary widgets from front-end
        remove_action('wp_head', 'wp_widget_recent_comments_style');
    }
}
add_action('init', 'westpace_optimize_queries');

// Enable Gzip compression
function westpace_enable_gzip() {
    if (!headers_sent() && !ob_get_contents() && !ini_get('zlib.output_compression')) {
        ob_start('ob_gzhandler');
    }
}
add_action('init', 'westpace_enable_gzip');

/**
 * Custom admin enhancements
 */
function westpace_admin_styles() {
    echo '<style>
        .post-type-product .wp-admin select,
        .post-type-product .wp-admin input[type="text"] {
            border-radius: 4px;
        }
        .woocommerce_page_wc-settings .wc-settings-tab-bar {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
    </style>';
}
add_action('admin_head', 'westpace_admin_styles');

/**
 * Custom login page styling
 */
function westpace_custom_login() {
    echo '<style>
        body.login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login form {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login h1 a {
            background-size: contain;
            width: 200px;
        }
    </style>';
}
add_action('login_head', 'westpace_custom_login');

/**
 * Newsletter subscription AJAX handler
 */
function westpace_newsletter_subscribe() {
    check_ajax_referer('westpace_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(__('Invalid email address', 'westpace-material'));
    }
    
    // Here you would integrate with your newsletter service
    // For now, we'll just simulate success
    
    wp_send_json_success(__('Successfully subscribed!', 'westpace-material'));
}
add_action('wp_ajax_westpace_newsletter', 'westpace_newsletter_subscribe');
add_action('wp_ajax_nopriv_westpace_newsletter', 'westpace_newsletter_subscribe');