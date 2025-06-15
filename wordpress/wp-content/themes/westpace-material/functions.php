<?php
if (!defined('ABSPATH')) exit;

/**
 * Westpace Material Theme Functions
 * Enhanced version with Material Design and ecommerce features
 */

function westpace_setup() {
    // Theme supports
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
    ));
    
    // Custom logo with enhanced options
    add_theme_support('custom-logo', array(
        'height' => 80, 'width' => 250, 'flex-height' => true, 'flex-width' => true,
    ));
    
    // Navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'westpace-material'),
        'footer'  => __('Footer Menu', 'westpace-material'),
        'mobile'  => __('Mobile Menu', 'westpace-material'),
        'categories' => __('Product Categories', 'westpace-material'),
    ));
    
    // WooCommerce support with enhanced features
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Enhanced image sizes
    add_image_size('hero-banner', 1920, 1080, true);
    add_image_size('product-featured', 600, 600, true);
    add_image_size('product-gallery', 400, 400, true);
    add_image_size('blog-featured', 800, 450, true);
}
add_action('after_setup_theme', 'westpace_setup');

function westpace_scripts() {
    $version = wp_get_theme()->get('Version');
    
    // Enhanced CSS loading
    wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $version);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Slab:wght@300;400;500;700&display=swap', array(), $version);
    wp_enqueue_style('westpace-material', get_template_directory_uri() . '/assets/css/material-design.css', array(), $version);
    wp_enqueue_style('westpace-style', get_stylesheet_uri(), array('westpace-material'), $version);
    
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('westpace-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('westpace-material'), $version);
    }
    
    // Enhanced JavaScript
    wp_enqueue_script('westpace-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), $version, true);
    
    // Localize script for enhanced AJAX functionality
    wp_localize_script('westpace-theme-js', 'westpace_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('westpace_nonce'),
        'cart_url' => class_exists('WooCommerce') ? wc_get_cart_url() : '',
        'shop_url' => class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '',
    ));
}
add_action('wp_enqueue_scripts', 'westpace_scripts');

// Enhanced widget areas
function westpace_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'westpace-material'),
        'id' => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget material-card elevation-2 %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title material-text-primary">',
        'after_title' => '</h3>',
    ));
    
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name' => sprintf(__('Footer Widget %d', 'westpace-material'), $i),
            'id' => "footer-widget-$i",
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="footer-widget-title">',
            'after_title' => '</h3>',
        ));
    }
}
add_action('widgets_init', 'westpace_widgets_init');

// Enhanced WooCommerce modifications
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce styling
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Enhanced product image thumbnails
    add_filter('woocommerce_get_image_size_gallery_thumbnail', function($size) {
        return array('width' => 150, 'height' => 150, 'crop' => 1);
    });
    
    // Enhanced cart fragments for AJAX
    add_filter('woocommerce_add_to_cart_fragments', 'westpace_cart_count_fragments');
    function westpace_cart_count_fragments($fragments) {
        $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
        return $fragments;
    }
}

// Performance optimizations
function westpace_performance_optimizations() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'westpace_performance_optimizations');

// Security enhancements
function westpace_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'westpace_security_headers');

// Custom excerpt
function westpace_excerpt_length($length) { return 25; }
add_filter('excerpt_length', 'westpace_excerpt_length');

function westpace_excerpt_more($more) { return '...'; }
add_filter('excerpt_more', 'westpace_excerpt_more');

// Include additional theme files
$inc_files = [
    'customizer.php',
    'template-functions.php',
    'class-walker-nav-menu.php'
];

foreach ($inc_files as $file) {
    $file_path = get_template_directory() . '/inc/' . $file;
    if (file_exists($file_path)) {
        require $file_path;
    }
}
