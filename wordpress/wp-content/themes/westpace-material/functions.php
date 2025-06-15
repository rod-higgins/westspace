<?php
if (!defined('ABSPATH')) exit;

function westpace_setup() {
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form'));
    add_theme_support('custom-logo', array('height' => 100, 'width' => 300, 'flex-height' => true));
    
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
    wp_enqueue_style('westpace-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '1.0.0');
    wp_enqueue_style('westpace-material', get_template_directory_uri() . '/assets/css/material-design.css', array('westpace-style'), '1.0.0');
    
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('westpace-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array('westpace-material'), '1.0.0');
    }
    
    wp_enqueue_script('westpace-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'westpace_scripts');

function westpace_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'westpace_widgets_init');