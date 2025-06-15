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

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add theme support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for custom header
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '000',
        'width'              => 1200,
        'height'             => 400,
        'flex-height'        => true,
        'wp-head-callback'   => 'westpace_header_style',
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for wide and full-width blocks
    add_theme_support('align-wide');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'westpace-material'),
        'footer'  => __('Footer Menu', 'westpace-material'),
        'mobile'  => __('Mobile Menu', 'westpace-material'),
    ));

    // Add image sizes
    add_image_size('westpace-featured', 800, 500, true);
    add_image_size('westpace-portfolio', 600, 400, true);
    add_image_size('westpace-thumbnail', 300, 300, true);

    // WooCommerce support
    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
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
        'type'      => 'list',
        'prev_text' => '<span class="material-icons">chevron_left</span>',
        'next_text' => '<span class="material-icons">chevron_right</span>',
    ));

    echo '</ul>';
    echo '</nav>';
}

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
        'Reply-To: ' . $email,
        'Content-Type: text/plain; charset=UTF-8'
    );

    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        wp_send_json_success(__('Message sent successfully!', 'westpace-material'));
    } else {
        wp_send_json_error(__('Failed to send message. Please try again.', 'westpace-material'));
    }
}
add_action('wp_ajax_westpace_contact_form', 'westpace_contact_form_handler');
add_action('wp_ajax_nopriv_westpace_contact_form', 'westpace_contact_form_handler');

/**
 * Color utilities
 */
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

/**
 * Check if sidebar exists and has widgets
 */
function westpace_has_sidebar() {
    return is_active_sidebar('sidebar-1') && !is_page_template('page-full-width.php');
}

/**
 * Body classes
 */
function westpace_body_classes($classes) {
    if (westpace_has_sidebar()) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) {
        $classes[] = 'woocommerce-page';
    }
    
    if (is_page_template('page-full-width.php')) {
        $classes[] = 'full-width-page';
    }
    
    return $classes;
}
add_filter('body_class', 'westpace_body_classes');

/**
 * Custom header callback
 */
function westpace_header_style() {
    $header_text_color = get_header_textcolor();

    if (!empty($header_text_color) && 'blank' !== $header_text_color) :
        ?>
        <style type="text/css">
        .site-title a,
        .site-description {
            color: #<?php echo esc_attr($header_text_color); ?>;
        }
        </style>
        <?php
    endif;
}

/**
 * Custom logo fallback
 */
function westpace_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a></h1>';
        $description = get_bloginfo('description', 'display');
        if ($description || is_customize_preview()) {
            echo '<p class="site-description">' . $description . '</p>';
        }
    }
}

/**
 * Breadcrumb function
 */
function westpace_breadcrumb() {
    if (is_front_page()) return;

    echo '<nav class="breadcrumb" aria-label="' . __('Breadcrumb', 'westpace-material') . '">';
    echo '<ol class="breadcrumb-list">';
    
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'westpace-material') . '</a></li>';

    if (is_category()) {
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
 * WooCommerce compatibility
 */
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Change number of products per page
    function westpace_woocommerce_products_per_page() {
        return get_theme_mod('woocommerce_products_per_page', 12);
    }
    add_filter('loop_shop_per_page', 'westpace_woocommerce_products_per_page', 20);
    
    // Change number of product columns
    function westpace_woocommerce_loop_columns() {
        return get_theme_mod('woocommerce_product_columns', 3);
    }
    add_filter('woocommerce_loop_add_to_cart_link', 'westpace_woocommerce_loop_add_to_cart_button', 10, 2);
    
    // Customize add to cart button
    function westpace_woocommerce_loop_add_to_cart_button($button, $product) {
        $button = sprintf(
            '<a href="%s" data-quantity="%s" class="%s btn btn-primary" %s>%s</a>',
            esc_url($product->add_to_cart_url()),
            esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
            esc_attr(isset($args['class']) ? $args['class'] : 'button'),
            isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
            esc_html($product->add_to_cart_text())
        );
        return $button;
    }
}

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
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'westpace_defer_scripts', 10, 3);

// Add preload for critical resources
function westpace_preload_critical_resources() {
    echo '<link rel="preload" href="' . WESTPACE_THEME_URI . '/assets/css/material-design.css" as="style">' . "\n";
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style">' . "\n";
}
add_action('wp_head', 'westpace_preload_critical_resources', 1);

/**
 * Custom post types (optional)
 */
function westpace_custom_post_types() {
    // Portfolio post type
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'westpace-material'),
            'singular_name' => __('Portfolio Item', 'westpace-material'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'portfolio'),
    ));

    // Testimonials post type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'westpace-material'),
            'singular_name' => __('Testimonial', 'westpace-material'),
        ),
        'public' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'testimonials'),
    ));
}
add_action('init', 'westpace_custom_post_types');

/**
 * Theme activation hook
 */
function westpace_activation_notice() {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>' . __('Westpace Material theme activated successfully! Visit the Customizer to configure your theme settings.', 'westpace-material') . '</p>';
        echo '</div>';
    });
}
register_activation_hook(__FILE__, 'westpace_activation_notice');