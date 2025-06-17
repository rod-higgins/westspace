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

    // Custom image sizes
    add_image_size('westpace-featured', 800, 400, true);
    add_image_size('westpace-thumbnail', 300, 200, true);
    add_image_size('westpace-hero', 1200, 600, true);
    add_image_size('westpace-portfolio', 600, 600, true);
    add_image_size('westpace-gallery', 400, 300, true);

    // This theme uses wp_nav_menu() in multiple locations
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'westpace-material'),
        'footer'  => __('Footer Menu', 'westpace-material'),
        'mobile'  => __('Mobile Menu', 'westpace-material'),
        'social'  => __('Social Menu', 'westpace-material'),
    ));

    // Switch default core markup for search form, comment form, and comments
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Set up the WordPress core custom background feature
    add_theme_support('custom-background', apply_filters('westpace_custom_background_args', array(
        'default-color' => 'F8FAFC',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // Add support for full and wide align images
    add_theme_support('align-wide');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Enqueue editor styles - Fixed path to templates directory
    add_editor_style('templates/assets/css/editor-style.css');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for custom line height controls
    add_theme_support('custom-line-height');

    // Add support for custom units
    add_theme_support('custom-units');

    // Add support for custom spacing
    add_theme_support('custom-spacing');

    // Remove default WordPress block patterns
    remove_theme_support('core-block-patterns');

    // Add theme support for wp-block-styles
    add_theme_support('wp-block-styles');

    // Add support for post formats
    add_theme_support('post-formats', array(
        'aside',
        'gallery',
        'link',
        'image',
        'quote',
        'status',
        'video',
        'audio',
        'chat'
    ));
}
add_action('after_setup_theme', 'westpace_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
function westpace_content_width() {
    $GLOBALS['content_width'] = apply_filters('westpace_content_width', 1200);
}
add_action('after_setup_theme', 'westpace_content_width', 0);

/**
 * Register widget areas - COMPLETE IMPLEMENTATION
 */
function westpace_widgets_init() {
    // Primary sidebar
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your primary sidebar.', 'westpace-material'),
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

    // Homepage widgets
    register_sidebar(array(
        'name'          => __('Homepage Widgets', 'westpace-material'),
        'id'            => 'homepage-widgets',
        'description'   => __('Add widgets here to appear on the homepage.', 'westpace-material'),
        'before_widget' => '<section id="%1$s" class="homepage-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="homepage-widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'westpace_widgets_init');

/**
 * Enqueue scripts and styles - COMPLETE IMPLEMENTATION
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
    wp_localize_script('westpace-theme-js', 'westpace_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('westpace_nonce'),
        'strings' => array(
            'loading' => __('Loading...', 'westpace-material'),
            'error' => __('An error occurred. Please try again.', 'westpace-material'),
            'success' => __('Success!', 'westpace-material'),
            'newsletterError' => __('There was an error subscribing to the newsletter.', 'westpace-material'),
        )
    ));

    // Comments script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Admin bar adjustments
    if (is_admin_bar_showing()) {
        wp_add_inline_style('westpace-style', '
            .site-header.fixed { top: 32px; }
            @media screen and (max-width: 782px) {
                .site-header.fixed { top: 46px; }
            }
        ');
    }
}
add_action('wp_enqueue_scripts', 'westpace_scripts');

/**
 * Check if the current page has a sidebar
 */
function westpace_has_sidebar() {
    // WooCommerce pages
    if (class_exists('WooCommerce')) {
        if (is_woocommerce()) {
            return is_active_sidebar('shop-sidebar');
        }
    }
    
    // Default pages
    return is_active_sidebar('sidebar-1') && !is_front_page() && !is_404();
}

/**
 * Custom template tags for this theme
 */

/**
 * Display navigation to next/previous set of posts when applicable
 */
function westpace_posts_navigation() {
    $navigation = get_the_posts_navigation(array(
        'prev_text' => '<span class="material-icons">arrow_back</span>' . __('Older posts', 'westpace-material'),
        'next_text' => __('Newer posts', 'westpace-material') . '<span class="material-icons">arrow_forward</span>',
    ));

    if ($navigation) {
        echo '<nav class="posts-navigation" role="navigation">';
        echo $navigation;
        echo '</nav>';
    }
}

/**
 * Display navigation to next/previous post when applicable
 */
function westpace_post_navigation() {
    $navigation = get_the_post_navigation(array(
        'prev_text' => '<span class="nav-subtitle">' . __('Previous:', 'westpace-material') . '</span> <span class="nav-title">%title</span>',
        'next_text' => '<span class="nav-subtitle">' . __('Next:', 'westpace-material') . '</span> <span class="nav-title">%title</span>',
    ));

    if ($navigation) {
        echo '<nav class="post-navigation" role="navigation">';
        echo $navigation;
        echo '</nav>';
    }
}

/**
 * Custom excerpt length
 */
function westpace_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'westpace_excerpt_length', 999);

/**
 * Custom excerpt more - FIXED IMPLEMENTATION
 */
function westpace_excerpt_more($more) {
    if (is_admin()) {
        return $more;
    }
    return '&hellip; <a class="more-link" href="' . get_permalink() . '">' . __('Continue reading', 'westpace-material') . '</a>';
}
add_filter('excerpt_more', 'westpace_excerpt_more');

/**
 * Add breadcrumb navigation
 */
function westpace_breadcrumb() {
    if (is_home() || is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumb" aria-label="' . __('Breadcrumb', 'westpace-material') . '">';
    echo '<ol class="breadcrumb-list">';
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'westpace-material') . '</a></li>';

    if (is_category() || is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            if ($category->parent != 0) {
                $parent_cats = get_category_parents($category->parent, true, '</li><li class="breadcrumb-item">');
                echo '<li class="breadcrumb-item">' . $parent_cats;
            }
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
        }
        if (is_single()) {
            echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        }
    } elseif (is_category()) {
        $category = get_category(get_query_var('cat'));
        if ($category->parent != 0) {
            $parent_category = get_category($category->parent);
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($parent_category->term_id)) . '">' . esc_html($parent_category->name) . '</a></li>';
        }
        echo '<li class="breadcrumb-item active">' . esc_html($category->name) . '</li>';
    } elseif (is_page()) {
        $page = get_post();
        if ($page->post_parent) {
            $parent_id = $page->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page_obj = get_page($parent_id);
                $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($page_obj->ID)) . '">' . get_the_title($page_obj->ID) . '</a></li>';
                $parent_id = $page_obj->post_parent;
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
 * Newsletter subscription AJAX handler - COMPLETE IMPLEMENTATION
 */
function westpace_newsletter_subscribe() {
    check_ajax_referer('westpace_nonce', 'nonce');
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(__('Invalid email address', 'westpace-material'));
    }
    
    // Check if email already exists in subscribers
    $subscribers = get_option('westpace_newsletter_subscribers', array());
    
    if (in_array($email, $subscribers)) {
        wp_send_json_error(__('You are already subscribed to our newsletter.', 'westpace-material'));
    }
    
    // Add email to subscribers list with timestamp
    $subscribers[$email] = current_time('mysql');
    update_option('westpace_newsletter_subscribers', $subscribers);
    
    // Send confirmation email (optional)
    $subject = __('Newsletter Subscription Confirmed', 'westpace-material');
    $message = sprintf(
        __('Thank you for subscribing to the %s newsletter! You will receive updates about our latest products and news.', 'westpace-material'),
        get_bloginfo('name')
    );
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($email, $subject, $message, $headers);
    
    wp_send_json_success(__('Successfully subscribed! Check your email for confirmation.', 'westpace-material'));
}
add_action('wp_ajax_westpace_newsletter', 'westpace_newsletter_subscribe');
add_action('wp_ajax_nopriv_westpace_newsletter', 'westpace_newsletter_subscribe');

/**
 * Contact form AJAX handler
 */
function westpace_contact_form_handler() {
    check_ajax_referer('westpace_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(__('Please fill in all required fields.', 'westpace-material'));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(__('Please enter a valid email address.', 'westpace-material'));
    }
    
    // Prepare email
    $to = get_option('admin_email');
    $email_subject = sprintf(__('[%s] Contact Form: %s', 'westpace-material'), get_bloginfo('name'), $subject);
    $email_message = sprintf(
        __("Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s", 'westpace-material'),
        $name,
        $email,
        $subject,
        $message
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email
    );
    
    // Send email
    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        wp_send_json_success(__('Thank you for your message! We will get back to you soon.', 'westpace-material'));
    } else {
        wp_send_json_error(__('Sorry, there was an error sending your message. Please try again.', 'westpace-material'));
    }
}
add_action('wp_ajax_westpace_contact_form', 'westpace_contact_form_handler');
add_action('wp_ajax_nopriv_westpace_contact_form', 'westpace_contact_form_handler');

/**
 * Include required files - Updated for templates directory
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
 * Template include function - Fixed to reference templates directory
 */
function westpace_template_include($template) {
    // Check if template exists in templates directory first
    $template_name = basename($template);
    $templates_path = get_template_directory() . '/templates/' . $template_name;
    
    if (file_exists($templates_path)) {
        return $templates_path;
    }
    
    return $template;
}
add_filter('template_include', 'westpace_template_include');

/**
 * Include template functions from templates directory
 */
function westpace_include_template_functions() {
    $template_functions = get_template_directory() . '/templates/inc/template-functions.php';
    if (file_exists($template_functions)) {
        require_once $template_functions;
    }
}
add_action('after_setup_theme', 'westpace_include_template_functions');

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
    function westpace_woocommerce_loop_add_to_cart_button($button, $product, $args) {
        if (!$product) return $button;
        
        $button_classes = 'btn btn-primary btn-sm add-to-cart-btn';
        
        return sprintf(
            '<a href="%s" class="%s" %s data-product_id="%s" data-product_sku="%s">%s</a>',
            esc_url($product->add_to_cart_url()),
            esc_attr($button_classes),
            isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
            esc_attr($product->get_id()),
            esc_attr($product->get_sku()),
            esc_html($product->add_to_cart_text())
        );
    }
    add_filter('woocommerce_loop_add_to_cart_link', 'westpace_woocommerce_loop_add_to_cart_button', 10, 3);

    /**
     * Remove WooCommerce breadcrumbs (we use our own)
     */
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    /**
     * Change WooCommerce wrapper
     */
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    add_action('woocommerce_before_main_content', 'westpace_woocommerce_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'westpace_woocommerce_wrapper_end', 10);

    function westpace_woocommerce_wrapper_start() {
        echo '<main id="primary" class="site-main woocommerce-main">';
        echo '<div class="container">';
    }

    function westpace_woocommerce_wrapper_end() {
        echo '</div>';
        echo '</main>';
    }
}

/**
 * Security Enhancements
 */

// Remove WordPress version number
remove_action('wp_head', 'wp_generator');

// Remove feed links
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);

// Remove really simple discovery link
remove_action('wp_head', 'rsd_link');

// Remove wlwmanifest link
remove_action('wp_head', 'wlwmanifest_link');

// Remove shortlink
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove REST API links
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// Clean up login errors
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
 * Admin dashboard enhancements
 */
function westpace_admin_newsletter_subscribers_page() {
    add_options_page(
        __('Newsletter Subscribers', 'westpace-material'),
        __('Newsletter Subscribers', 'westpace-material'),
        'manage_options',
        'westpace-newsletter-subscribers',
        'westpace_newsletter_subscribers_page_callback'
    );
}
add_action('admin_menu', 'westpace_admin_newsletter_subscribers_page');

function westpace_newsletter_subscribers_page_callback() {
    $subscribers = get_option('westpace_newsletter_subscribers', array());
    ?>
    <div class="wrap">
        <h1><?php _e('Newsletter Subscribers', 'westpace-material'); ?></h1>
        <div class="card">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Email Address', 'westpace-material'); ?></th>
                        <th><?php _e('Subscription Date', 'westpace-material'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subscribers)): ?>
                        <tr>
                            <td colspan="2"><?php _e('No subscribers yet.', 'westpace-material'); ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $email => $date): ?>
                            <tr>
                                <td><?php echo esc_html($email); ?></td>
                                <td><?php echo esc_html($date); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

/**
 * Fixed customizer script references for templates directory
 */
function westpace_customize_controls_js() {
    wp_enqueue_script('westpace-customizer-controls', get_template_directory_uri() . '/templates/assets/js/customizer-controls.js', array('customize-controls'), '20210101', true);
}
add_action('customize_controls_enqueue_scripts', 'westpace_customize_controls_js');

function westpace_customize_preview_js() {
    wp_enqueue_script('westpace-customizer', get_template_directory_uri() . '/templates/assets/js/customizer.js', array('customize-preview'), '20210101', true);
}
add_action('customize_preview_init', 'westpace_customize_preview_js');

/**
 * Block editor color palette
 */
function westpace_editor_color_palette() {
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary', 'westpace-material'),
            'slug'  => 'primary',
            'color' => '#2196F3',
        ),
        array(
            'name'  => __('Secondary', 'westpace-material'),
            'slug'  => 'secondary',
            'color' => '#FF9800',
        ),
        array(
            'name'  => __('Dark Gray', 'westpace-material'),
            'slug'  => 'dark-gray',
            'color' => '#334155',
        ),
        array(
            'name'  => __('Light Gray', 'westpace-material'),
            'slug'  => 'light-gray',
            'color' => '#F8FAFC',
        ),
        array(
            'name'  => __('White', 'westpace-material'),
            'slug'  => 'white',
            'color' => '#FFFFFF',
        ),
        array(
            'name'  => __('Black', 'westpace-material'),
            'slug'  => 'black',
            'color' => '#000000',
        ),
    ));
}
add_action('after_setup_theme', 'westpace_editor_color_palette');

/**
 * Block editor font sizes
 */
function westpace_editor_font_sizes() {
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => __('Small', 'westpace-material'),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => __('Normal', 'westpace-material'),
            'size' => 16,
            'slug' => 'normal'
        ),
        array(
            'name' => __('Medium', 'westpace-material'),
            'size' => 18,
            'slug' => 'medium'
        ),
        array(
            'name' => __('Large', 'westpace-material'),
            'size' => 24,
            'slug' => 'large'
        ),
        array(
            'name' => __('Extra Large', 'westpace-material'),
            'size' => 32,
            'slug' => 'extra-large'
        ),
    ));
}
add_action('after_setup_theme', 'westpace_editor_font_sizes');

/**
 * Custom walker for navigation menus - Fixed reference
 */
function westpace_nav_menu_args($args) {
    if (isset($args['theme_location']) && $args['theme_location'] === 'primary') {
        $walker_file = get_template_directory() . '/inc/class-walker-nav-menu.php';
        if (file_exists($walker_file)) {
            require_once $walker_file;
            $args['walker'] = new Westpace_Walker_Nav_Menu();
        }
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'westpace_nav_menu_args');
?>