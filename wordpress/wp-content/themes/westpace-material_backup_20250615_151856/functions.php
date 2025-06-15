<?php
if (!defined('ABSPATH')) exit;

// Force clear any caches
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
}

function westpace_setup() {
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
    add_theme_support('custom-logo', array('height' => 60, 'width' => 200, 'flex-height' => true, 'flex-width' => true));
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'westpace-material'),
        'footer'  => __('Footer Menu', 'westpace-material'),
    ));
    
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'westpace_setup');

function westpace_scripts() {
    // Use timestamp for cache busting
    $version = time();
    
    // Dequeue any conflicting styles first
    wp_dequeue_style('theme-style');
    wp_dequeue_style('style');
    
    // Enqueue our styles with cache busting
    wp_enqueue_style('westpace-style', get_stylesheet_uri(), array(), $version);
    wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $version);
    wp_enqueue_style('westpace-material', get_template_directory_uri() . '/assets/css/material-design.css', array('westpace-style'), $version);
    
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('westpace-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('westpace-material'), $version);
    }
    
    wp_enqueue_script('westpace-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), $version, true);
    
    // Add inline CSS for immediate effect
    $custom_css = "
        body { font-family: 'Roboto', sans-serif !important; background: #fafafa !important; }
        .hero-section { background: linear-gradient(135deg, #1565C0 0%, #42A5F5 50%, #00BCD4 100%) !important; color: white !important; padding: 120px 0 80px 0 !important; text-align: center !important; }
        .btn { background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%) !important; color: white !important; padding: 16px 32px !important; border-radius: 8px !important; text-decoration: none !important; display: inline-block !important; }
    ";
    wp_add_inline_style('westpace-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'westpace_scripts', 999);

// Force disable caching for theme development
function westpace_disable_caching() {
    if (!defined('WP_CACHE')) {
        define('WP_CACHE', false);
    }
    
    // Add no-cache headers
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
}
add_action('init', 'westpace_disable_caching');

// Clear object cache
function westpace_clear_caches() {
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
    if (function_exists('wp_rocket_clean_domain')) {
        wp_rocket_clean_domain();
    }
    if (function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }
}
add_action('wp_loaded', 'westpace_clear_caches');

function westpace_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s elevation-1">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'westpace_widgets_init');

// Add body class for easier targeting
function westpace_body_classes($classes) {
    $classes[] = 'westpace-material-theme';
    $classes[] = 'version-2-1-0';
    return $classes;
}
add_filter('body_class', 'westpace_body_classes');
