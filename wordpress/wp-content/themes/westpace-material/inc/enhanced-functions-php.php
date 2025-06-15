<?php
/**
 * Enhanced Westpace Material Theme Functions
 * Modern, secure, and performance-optimized WordPress theme functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme version for cache busting
define('WESTPACE_VERSION', '3.0.0');
define('WESTPACE_THEME_DIR', get_template_directory());
define('WESTPACE_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function westpace_setup() {
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

    // Add support for block editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary Blue', 'westpace-material'),
            'slug'  => 'primary-blue',
            'color' => '#1976D2',
        ),
        array(
            'name'  => __('Secondary Orange', 'westpace-material'),
            'slug'  => 'secondary-orange',
            'color' => '#FF6D00',
        ),
        array(
            'name'  => __('Neutral Gray', 'westpace-material'),
            'slug'  => 'neutral-gray',
            'color' => '#64748B',
        ),
        array(
            'name'  => __('Success Green', 'westpace-material'),
            'slug'  => 'success-green',
            'color' => '#10B981',
        ),
        array(
            'name'  => __('Error Red', 'westpace-material'),
            'slug'  => 'error-red',
            'color' => '#EF4444',
        ),
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary'    => __('Primary Menu', 'westpace-material'),
        'footer'     => __('Footer Menu', 'westpace-material'),
        'mobile'     => __('Mobile Menu', 'westpace-material'),
        'categories' => __('Product Categories', 'westpace-material'),
    ));

    // Enhanced image sizes
    add_image_size('hero-banner', 1920, 1080, true);
    add_image_size('hero-banner-mobile', 768, 1024, true);
    add_image_size('product-featured', 600, 600, true);
    add_image_size('product-gallery', 400, 400, true);
    add_image_size('product-thumbnail', 150, 150, true);
    add_image_size('blog-featured', 800, 450, true);
    add_image_size('blog-grid', 400, 300, true);
    add_image_size('testimonial-avatar', 80, 80, true);

    // Set content width for better responsive images
    $GLOBALS['content_width'] = 1200;

    // WooCommerce support with enhanced features
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 4,
            'min_rows'        => 2,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 6,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Load theme textdomain for internationalization
    load_theme_textdomain('westpace-material', WESTPACE_THEME_DIR . '/languages');
}
add_action('after_setup_theme', 'westpace_setup');

/**
 * Enhanced Script and Style Enqueuing
 */
function westpace_scripts() {
    // Remove WordPress version from scripts and styles
    remove_action('wp_head', 'wp_generator');

    // Main theme stylesheet
    wp_enqueue_style(
        'westpace-material-style',
        get_stylesheet_uri(),
        array(),
        WESTPACE_VERSION
    );

    // Font Awesome for social icons
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );

    // WooCommerce styles (only if WooCommerce is active)
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'westpace-woocommerce',
            WESTPACE_THEME_URI . '/assets/css/woocommerce.css',
            array('westpace-material-style'),
            WESTPACE_VERSION
        );
    }

    // Main theme JavaScript
    wp_enqueue_script(
        'westpace-theme-js',
        WESTPACE_THEME_URI . '/assets/js/theme.js',
        array('jquery'),
        WESTPACE_VERSION,
        true
    );

    // Localize script for AJAX and theme data
    wp_localize_script('westpace-theme-js', 'westpaceData', array(
        'ajaxUrl'       => admin_url('admin-ajax.php'),
        'nonce'         => wp_create_nonce('westpace_nonce'),
        'homeUrl'       => home_url('/'),
        'themeUri'      => WESTPACE_THEME_URI,
        'isWooActive'   => class_exists('WooCommerce'),
        'cartUrl'       => class_exists('WooCommerce') ? wc_get_cart_url() : '',
        'shopUrl'       => class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '',
        'strings'       => array(
            'loading'           => __('Loading...', 'westpace-material'),
            'addedToCart'       => __('Product added to cart!', 'westpace-material'),
            'cartError'         => __('Error adding product to cart.', 'westpace-material'),
            'newsletterSuccess' => __('Thank you for subscribing!', 'westpace-material'),
            'newsletterError'   => __('Subscription failed. Please try again.', 'westpace-material'),
        ),
    ));

    // Comments script for threaded comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Conditional scripts for specific pages
    if (is_page_template('page-contact.php') || is_page('contact')) {
        wp_enqueue_script(
            'westpace-contact',
            WESTPACE_THEME_URI . '/assets/js/contact.js',
            array('jquery', 'westpace-theme-js'),
            WESTPACE_VERSION,
            true
        );
    }

    // Performance optimization: preload critical resources
    add_action('wp_head', 'westpace_preload_resources', 1);
}
add_action('wp_enqueue_scripts', 'westpace_scripts');

/**
 * Preload Critical Resources
 */
function westpace_preload_resources() {
    // Preload critical fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons+Round&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    
    // Preload hero image on front page
    if (is_front_page()) {
        $hero_image = get_theme_mod('hero_background_image', WESTPACE_THEME_URI . '/assets/images/hero-bg.jpg');
        echo '<link rel="preload" href="' . esc_url($hero_image) . '" as="image">' . "\n";
    }
}

/**
 * Enhanced Widget Areas
 */
function westpace_widgets_init() {
    // Main sidebar
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'westpace-material'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'westpace-material'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Shop sidebar (WooCommerce)
    if (class_exists('WooCommerce')) {
        register_sidebar(array(
            'name'          => __('Shop Sidebar', 'westpace-material'),
            'id'            => 'sidebar-shop',
            'description'   => __('Widgets for the shop sidebar.', 'westpace-material'),
            'before_widget' => '<section id="%1$s" class="widget shop-widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }

    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget Area %d', 'westpace-material'), $i),
            'id'            => "footer-widget-$i",
            'description'   => sprintf(__('Widgets for footer column %d.', 'westpace-material'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
    }

    // Homepage widget areas
    register_sidebar(array(
        'name'          => __('Homepage Hero', 'westpace-material'),
        'id'            => 'homepage-hero',
        'description'   => __('Widgets for the homepage hero section.', 'westpace-material'),
        'before_widget' => '<div id="%1$s" class="hero-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="hero-widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Homepage Services', 'westpace-material'),
        'id'            => 'homepage-services',
        'description'   => __('Widgets for the homepage services section.', 'westpace-material'),
        'before_widget' => '<div id="%1$s" class="service-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="service-widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'westpace_widgets_init');

/**
 * Enhanced WooCommerce Modifications
 */
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce styling
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');

    // Modify WooCommerce image sizes
    function westpace_woocommerce_image_dimensions() {
        global $pagenow;
        
        if (!isset($_GET['activated']) || $pagenow != 'themes.php') {
            return;
        }
        
        // Update image sizes
        update_option('woocommerce_thumbnail_image_width', 300);
        update_option('woocommerce_single_image_width', 600);
        update_option('woocommerce_thumbnail_cropping', '1:1');
    }
    add_action('after_switch_theme', 'westpace_woocommerce_image_dimensions', 1);

    // Enhanced cart fragments for AJAX
    function westpace_cart_count_fragments($fragments) {
        $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        $fragments['.cart-count'] = '<span class="cart-count">' . $count . '</span>';
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'westpace_cart_count_fragments');

    // Add loading state to add to cart buttons
    function westpace_add_to_cart_script() {
        if (is_shop() || is_product_category() || is_product_tag()) {
            ?>
            <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(document).on('click', '.ajax_add_to_cart', function() {
                    var $button = $(this);
                    $button.addClass('loading').attr('disabled', 'disabled');
                });
                
                $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
                    $button.removeClass('loading').removeAttr('disabled');
                });
            });
            </script>
            <?php
        }
    }
    add_action('wp_footer', 'westpace_add_to_cart_script');

    // Modify WooCommerce pagination
    function westpace_woocommerce_pagination_args($args) {
        $args['prev_text'] = '<span class="material-icons">chevron_left</span>';
        $args['next_text'] = '<span class="material-icons">chevron_right</span>';
        return $args;
    }
    add_filter('woocommerce_pagination_args', 'westpace_woocommerce_pagination_args');

    // Add product schema markup
    function westpace_product_schema() {
        if (is_product()) {
            global $product;
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'Product',
                'name' => $product->get_name(),
                'description' => wp_strip_all_tags($product->get_short_description()),
                'sku' => $product->get_sku(),
                'offers' => array(
                    '@type' => 'Offer',
                    'price' => $product->get_price(),
                    'priceCurrency' => get_woocommerce_currency(),
                    'availability' => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ),
            );
            
            if ($product->get_image_id()) {
                $image_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
                $schema['image'] = $image_url;
            }
            
            echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
        }
    }
    add_action('wp_head', 'westpace_product_schema');
}

/**
 * Performance Optimizations
 */
function westpace_performance_optimizations() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    
    // Remove emoji scripts and styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // Disable embeds
    add_filter('embed_oembed_discover', '__return_false');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Remove jQuery migrate
    function westpace_remove_jquery_migrate($scripts) {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, array('jquery-migrate'));
            }
        }
    }
    add_action('wp_default_scripts', 'westpace_remove_jquery_migrate');
}
add_action('init', 'westpace_performance_optimizations');

/**
 * Security Enhancements
 */
function westpace_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'westpace_security_headers');

// Remove WordPress version from RSS feeds
function westpace_remove_version() {
    return '';
}
add_filter('the_generator', 'westpace_remove_version');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove unnecessary meta tags
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * SEO Enhancements
 */
function westpace_seo_enhancements() {
    // Add structured data for organization
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url(),
            'logo' => wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full'),
            'contactPoint' => array(
                '@type' => 'ContactPoint',
                'telephone' => get_theme_mod('footer_phone', '+679123456'),
                'contactType' => 'customer service',
            ),
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'westpace_seo_enhancements');

// Enhanced title tag
function westpace_document_title_parts($title) {
    if (is_home() && !is_front_page()) {
        $title['title'] = __('Blog', 'westpace-material');
    }
    
    if (is_404()) {
        $title['title'] = __('Page Not Found', 'westpace-material');
    }
    
    return $title;
}
add_filter('document_title_parts', 'westpace_document_title_parts');

/**
 * Custom Post Types and Fields
 */
function westpace_custom_post_types() {
    // Testimonials post type
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('Testimonials', 'westpace-material'),
            'singular_name' => __('Testimonial', 'westpace-material'),
            'add_new' => __('Add New Testimonial', 'westpace-material'),
            'add_new_item' => __('Add New Testimonial', 'westpace-material'),
            'edit_item' => __('Edit Testimonial', 'westpace-material'),
            'new_item' => __('New Testimonial', 'westpace-material'),
            'view_item' => __('View Testimonial', 'westpace-material'),
            'search_items' => __('Search Testimonials', 'westpace-material'),
            'not_found' => __('No testimonials found', 'westpace-material'),
            'not_found_in_trash' => __('No testimonials found in trash', 'westpace-material'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'testimonials'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-format-quote',
        'show_in_rest' => true,
    ));

    // Team members post type
    register_post_type('team_member', array(
        'labels' => array(
            'name' => __('Team Members', 'westpace-material'),
            'singular_name' => __('Team Member', 'westpace-material'),
            'add_new' => __('Add New Team Member', 'westpace-material'),
            'add_new_item' => __('Add New Team Member', 'westpace-material'),
            'edit_item' => __('Edit Team Member', 'westpace-material'),
            'new_item' => __('New Team Member', 'westpace-material'),
            'view_item' => __('View Team Member', 'westpace-material'),
            'search_items' => __('Search Team Members', 'westpace-material'),
            'not_found' => __('No team members found', 'westpace-material'),
            'not_found_in_trash' => __('No team members found in trash', 'westpace-material'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'team'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-groups',
        'show_in_rest' => true,
    ));
}
add_action('init', 'westpace_custom_post_types');

/**
 * Custom Excerpt Functions
 */
function westpace_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'westpace_excerpt_length', 999);

function westpace_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'westpace_excerpt_more');

// Custom excerpt function with length parameter
function westpace_custom_excerpt($length = 30, $post_id = null) {
    $post = get_post($post_id);
    if (!$post) {
        return '';
    }
    
    $excerpt = $post->post_excerpt;
    if (empty($excerpt)) {
        $excerpt = $post->post_content;
    }
    
    $excerpt = wp_strip_all_tags($excerpt);
    $words = explode(' ', $excerpt);
    
    if (count($words) > $length) {
        $words = array_slice($words, 0, $length);
        $excerpt = implode(' ', $words) . '...';
    }
    
    return $excerpt;
}

/**
 * AJAX Handlers
 */
function westpace_newsletter_signup() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'westpace_nonce')) {
        wp_die(__('Security check failed.', 'westpace-material'));
    }
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error(__('Invalid email address.', 'westpace-material'));
    }
    
    // Here you would integrate with your newsletter service
    // For now, we'll just simulate success
    
    wp_send_json_success(__('Thank you for subscribing!', 'westpace-material'));
}
add_action('wp_ajax_newsletter_signup', 'westpace_newsletter_signup');
add_action('wp_ajax_nopriv_newsletter_signup', 'westpace_newsletter_signup');

/**
 * Contact Form Handler
 */
function westpace_contact_form_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'westpace_nonce')) {
        wp_die(__('Security check failed.', 'westpace-material'));
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(__('Please fill in all required fields.', 'westpace-material'));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(__('Invalid email address.', 'westpace-material'));
    }
    
    // Send email
    $to = get_option('admin_email');
    $email_subject = sprintf(__('[%s] Contact Form: %s', 'westpace-material'), get_bloginfo('name'), $subject);
    $email_message = sprintf(
        __("Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s", 'westpace-material'),
        $name,
        $email,
        $subject,
        $message
    );
    $headers = array('Content-Type: text/plain; charset=UTF-8', "Reply-To: $name <$email>");
    
    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        wp_send_json_success(__('Thank you for your message. We will get back to you soon!', 'westpace-material'));
    } else {
        wp_send_json_error(__('Sorry, there was an error sending your message. Please try again.', 'westpace-material'));
    }
}
add_action('wp_ajax_contact_form', 'westpace_contact_form_handler');
add_action('wp_ajax_nopriv_contact_form', 'westpace_contact_form_handler');

/**
 * Image Optimization
 */
function westpace_optimize_images() {
    // Add WebP support detection
    add_filter('wp_generate_attachment_metadata', 'westpace_generate_webp_images', 10, 2);
    
    // Lazy load images
    add_filter('the_content', 'westpace_add_lazy_loading');
    add_filter('post_thumbnail_html', 'westpace_add_lazy_loading_to_thumbnails', 10, 5);
}
add_action('init', 'westpace_optimize_images');

function westpace_add_lazy_loading($content) {
    if (is_admin() || is_feed() || wp_is_mobile()) {
        return $content;
    }
    
    // Add loading="lazy" to images
    $content = preg_replace('/<img(.*?)>/i', '<img$1 loading="lazy">', $content);
    
    return $content;
}

function westpace_add_lazy_loading_to_thumbnails($html, $post_id, $post_thumbnail_id, $size, $attr) {
    if (strpos($html, 'loading=') === false) {
        $html = str_replace('<img', '<img loading="lazy"', $html);
    }
    return $html;
}

/**
 * Admin Enhancements
 */
function westpace_admin_enhancements() {
    // Custom admin footer text
    function westpace_admin_footer_text($footer_text) {
        return sprintf(
            __('Thank you for using %s theme by %s.', 'westpace-material'),
            '<strong>Westpace Material</strong>',
            '<a href="https://westpace.com" target="_blank">West Pace Apparels</a>'
        );
    }
    add_filter('admin_footer_text', 'westpace_admin_footer_text');
    
    // Remove WordPress version from admin footer
    function westpace_remove_admin_footer_version() {
        return '';
    }
    add_filter('update_footer', 'westpace_remove_admin_footer_version', 11);
}
add_action('admin_init', 'westpace_admin_enhancements');

/**
 * Include Additional Theme Files
 */
$include_files = array(
    'inc/customizer.php',
    'inc/template-functions.php',
    'inc/class-walker-nav-menu.php',
    'inc/admin-functions.php',
    'inc/block-patterns.php',
);

foreach ($include_files as $file) {
    $file_path = WESTPACE_THEME_DIR . '/' . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

/**
 * Theme Activation Hook
 */
function westpace_theme_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default customizer values
    $defaults = array(
        'hero_title' => __('West Pace Apparels', 'westpace-material'),
        'hero_subtitle' => __('Premium Garment Manufacturing Since 1998', 'westpace-material'),
        'hero_description' => __('Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets.', 'westpace-material'),
        'footer_description' => __('Premium garment manufacturing with over 24 years of excellence. Serving Australia, New Zealand, and the South Pacific.', 'westpace-material'),
        'footer_phone' => '+679123456',
        'footer_phone_display' => '+679 123 456',
        'footer_email' => 'info@westpace.com',
        'footer_address' => 'Suva, Fiji Islands',
    );
    
    foreach ($defaults as $key => $value) {
        if (!get_theme_mod($key)) {
            set_theme_mod($key, $value);
        }
    }
}
add_action('after_switch_theme', 'westpace_theme_activation');

/**
 * Theme Deactivation Hook
 */
function westpace_theme_deactivation() {
    // Clean up any theme-specific options or temporary data
    delete_transient('westpace_product_categories');
    delete_transient('westpace_featured_products');
}
add_action('switch_theme', 'westpace_theme_deactivation');

/**
 * Conditional Loading for Better Performance
 */
function westpace_conditional_scripts() {
    // Only load contact form scripts on contact page
    if (is_page_template('page-contact.php') || is_page('contact')) {
        wp_enqueue_script('westpace-contact-form');
    }
    
    // Only load WooCommerce scripts on shop pages
    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
        wp_enqueue_script('westpace-woocommerce-enhanced');
    }
}
add_action('wp_enqueue_scripts', 'westpace_conditional_scripts', 20);

// Initialize theme
add_action('init', function() {
    // Add any initialization code here
    do_action('westpace_theme_init');
});