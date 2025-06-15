<?php
/**
 * Westpace Material Design Enhanced Theme Functions
 * Modern, secure, and performance-optimized WordPress theme functions
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

    // Switch default core markup to HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for wide and full alignment
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary'    => __('Primary Menu', 'westpace-material'),
        'footer'     => __('Footer Menu', 'westpace-material'),
        'mobile'     => __('Mobile Menu', 'westpace-material'),
    ));

    // WooCommerce support
    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    // Enhanced image sizes
    add_image_size('hero-banner', 1920, 1080, true);
    add_image_size('blog-featured', 800, 450, true);
    add_image_size('blog-grid', 400, 300, true);
    add_image_size('testimonial-avatar', 100, 100, true);
}
add_action('after_setup_theme', 'westpace_setup');

/**
 * Set the content width
 */
function westpace_content_width() {
    $GLOBALS['content_width'] = apply_filters('westpace_content_width', 1200);
}
add_action('after_setup_theme', 'westpace_content_width', 0);

/**
 * Register Widget Areas
 */
function westpace_widgets_init() {
    // Main sidebar
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'westpace-material'),
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
 * Contact Form Handler
 */
function westpace_contact_form_handler() {
    if (!wp_verify_nonce($_POST['nonce'], 'westpace_nonce')) {
        wp_die(__('Security check failed', 'westpace-material'));
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(__('Please fill in all required fields.', 'westpace-material'));
    }

    if (!is_email($email)) {
        wp_send_json_error(__('Please provide a valid email address.', 'westpace-material'));
    }

    $to = get_option('admin_email');
    $email_subject = sprintf(__('Contact Form: %s', 'westpace-material'), $subject);
    $email_message = sprintf(
        __("Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s", 'westpace-material'),
        $name, $email, $subject, $message
    );

    $headers = array(
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
        'Content-Type: text/plain; charset=UTF-8'
    );

    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        wp_send_json_success(__('Thank you! Your message has been sent successfully.', 'westpace-material'));
    } else {
        wp_send_json_error(__('Sorry, there was an error sending your message. Please try again.', 'westpace-material'));
    }
}
add_action('wp_ajax_westpace_contact_form', 'westpace_contact_form_handler');
add_action('wp_ajax_nopriv_westpace_contact_form', 'westpace_contact_form_handler');

/**
 * Newsletter Handler
 */
function westpace_newsletter_handler() {
    if (!wp_verify_nonce($_POST['nonce'], 'westpace_nonce')) {
        wp_die(__('Security check failed', 'westpace-material'));
    }

    $email = sanitize_email($_POST['email']);

    if (!is_email($email)) {
        wp_send_json_error(__('Please provide a valid email address.', 'westpace-material'));
    }

    $subscribers = get_option('westpace_newsletter_subscribers', array());
    
    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('westpace_newsletter_subscribers', $subscribers);
        
        wp_mail(
            get_option('admin_email'),
            __('New Newsletter Subscription', 'westpace-material'),
            sprintf(__('New subscriber: %s', 'westpace-material'), $email)
        );
        
        wp_send_json_success(__('Thank you for subscribing to our newsletter!', 'westpace-material'));
    } else {
        wp_send_json_error(__('This email is already subscribed.', 'westpace-material'));
    }
}
add_action('wp_ajax_westpace_newsletter', 'westpace_newsletter_handler');
add_action('wp_ajax_nopriv_westpace_newsletter', 'westpace_newsletter_handler');

/**
 * Helper Functions
 */

// Get reading time
function westpace_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    
    if ($reading_time === 1) {
        return __('1 min read', 'westpace-material');
    } else {
        return sprintf(__('%d min read', 'westpace-material'), $reading_time);
    }
}

// Check if sidebar should be displayed
function westpace_has_sidebar() {
    if (is_front_page() || is_page_template('page-fullwidth.php')) {
        return false;
    }
    return is_active_sidebar('sidebar-1');
}

// Get sidebar name
function westpace_get_sidebar() {
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) {
        return 'shop-sidebar';
    }
    return 'sidebar-1';
}

// Custom pagination
function westpace_pagination() {
    $pagination = paginate_links(array(
        'type'      => 'array',
        'prev_text' => '<span class="material-icons-round">chevron_left</span> ' . __('Previous', 'westpace-material'),
        'next_text' => __('Next', 'westpace-material') . ' <span class="material-icons-round">chevron_right</span>',
    ));

    if (!$pagination) {
        return;
    }

    echo '<nav class="pagination-navigation" aria-label="' . esc_attr__('Posts Navigation', 'westpace-material') . '">';
    echo '<ul class="pagination">';
    
    foreach ($pagination as $page_link) {
        $class = 'page-item';
        if (strpos($page_link, 'current') !== false) {
            $class .= ' active';
        }
        
        echo '<li class="' . esc_attr($class) . '">';
        echo str_replace('page-numbers', 'page-link', $page_link);
        echo '</li>';
    }
    
    echo '</ul>';
    echo '</nav>';
}

// Color utilities
function westpace_hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    $length = strlen($hex);
    
    if ($length == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    
    return array(
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2))
    );
}

function westpace_darken_color($hex, $amount = 0.1) {
    $rgb = westpace_hex_to_rgb($hex);
    $rgb['r'] = max(0, $rgb['r'] - ($rgb['r'] * $amount));
    $rgb['g'] = max(0, $rgb['g'] - ($rgb['g'] * $amount));
    $rgb['b'] = max(0, $rgb['b'] - ($rgb['b'] * $amount));
    
    return sprintf('#%02x%02x%02x', $rgb['r'], $rgb['g'], $rgb['b']);
}

function westpace_lighten_color($hex, $amount = 0.1) {
    $rgb = westpace_hex_to_rgb($hex);
    $rgb['r'] = min(255, $rgb['r'] + ((255 - $rgb['r']) * $amount));
    $rgb['g'] = min(255, $rgb['g'] + ((255 - $rgb['g']) * $amount));
    $rgb['b'] = min(255, $rgb['b'] + ((255 - $rgb['b']) * $amount));
    
    return sprintf('#%02x%02x%02x', $rgb['r'], $rgb['g'], $rgb['b']);
}

// Body classes
function westpace_body_classes($classes) {
    if (westpace_has_sidebar()) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) {
        $classes[] = 'woocommerce-page';
    }
    
    return $classes;
}
add_filter('body_class', 'westpace_body_classes');

/**
 * Include required files
 */
$include_files = array(
    '/inc/customizer.php',
    '/inc/template-functions.php',
);

foreach ($include_files as $file) {
    $file_path = WESTPACE_THEME_DIR . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}