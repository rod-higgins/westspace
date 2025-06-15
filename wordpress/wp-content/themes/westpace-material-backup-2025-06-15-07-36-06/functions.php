<?php
if (!defined('ABSPATH')) exit;

function westpace_setup() {
    // Theme supports
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'comment-list', 
        'comment-form', 
        'search-form', 
        'gallery', 
        'caption'
    ));
    add_theme_support('custom-logo', array(
        'height' => 60, 
        'width' => 200, 
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // Navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'westpace-material'),
        'footer'  => __('Footer Menu', 'westpace-material'),
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Image sizes
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('service-image', 400, 300, true);
    add_image_size('client-logo', 200, 150, true);
}
add_action('after_setup_theme', 'westpace_setup');

function westpace_scripts() {
    $version = wp_get_theme()->get('Version');
    
    // Styles
    wp_enqueue_style('westpace-style', get_stylesheet_uri(), array(), $version);
    wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), $version);
    wp_enqueue_style('westpace-material', get_template_directory_uri() . '/assets/css/material-design.css', array('westpace-style'), $version);
    
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('westpace-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('westpace-material'), $version);
    }
    
    // Scripts
    wp_enqueue_script('westpace-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), $version, true);
    
    // Localize script for AJAX
    wp_localize_script('westpace-theme-js', 'westpace_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('westpace_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'westpace_scripts');

function westpace_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s elevation-1">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'westpace-material'),
        'id'            => 'footer-widgets',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'westpace_widgets_init');

// Custom excerpt length
function westpace_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'westpace_excerpt_length');

// Custom excerpt more
function westpace_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'westpace_excerpt_more');

// Add async/defer to scripts
function westpace_script_attributes($tag, $handle, $src) {
    $async_scripts = array('westpace-theme-js');
    
    if (in_array($handle, $async_scripts)) {
        return str_replace('<script ', '<script async ', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'westpace_script_attributes', 10, 3);

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
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
}
add_action('send_headers', 'westpace_security_headers');
