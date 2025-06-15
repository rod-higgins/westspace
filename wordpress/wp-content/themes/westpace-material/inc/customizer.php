<?php
/**
 * Westpace Material Design Theme Customizer
 * 
 * @package Westpace_Material
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add customizer settings
 */
function westpace_customize_register($wp_customize) {
    
    // Theme Colors Section
    $wp_customize->add_section('westpace_colors', array(
        'title'    => __('Theme Colors', 'westpace-material'),
        'priority' => 30,
    ));

    // Primary Color
    $wp_customize->add_setting('westpace_primary_color', array(
        'default'           => '#1976D2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_primary_color', array(
        'label'    => __('Primary Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('westpace_secondary_color', array(
        'default'           => '#FF6D00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_secondary_color', array(
        'label'    => __('Secondary Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_secondary_color',
    )));

    // Text Color
    $wp_customize->add_setting('westpace_text_color', array(
        'default'           => '#0F172A',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_text_color', array(
        'label'    => __('Text Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_text_color',
    )));

    // Background Color
    $wp_customize->add_setting('westpace_background_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'westpace_background_color', array(
        'label'    => __('Background Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'westpace_background_color',
    )));

    // Typography Section
    $wp_customize->add_section('westpace_typography', array(
        'title'    => __('Typography', 'westpace-material'),
        'priority' => 35,
    ));

    // Heading Font
    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'westpace_sanitize_font',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('heading_font', array(
        'type'     => 'select',
        'section'  => 'westpace_typography',
        'label'    => __('Heading Font', 'westpace-material'),
        'choices'  => westpace_get_font_choices(),
    ));

    // Body Font
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'westpace_sanitize_font',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('body_font', array(
        'type'     => 'select',
        'section'  => 'westpace_typography',
        'label'    => __('Body Font', 'westpace-material'),
        'choices'  => westpace_get_font_choices(),
    ));

    // Base Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('base_font_size', array(
        'type'        => 'range',
        'section'     => 'westpace_typography',
        'label'       => __('Base Font Size (px)', 'westpace-material'),
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Layout Section
    $wp_customize->add_section('westpace_layout', array(
        'title'    => __('Layout Options', 'westpace-material'),
        'priority' => 40,
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'type'        => 'range',
        'section'     => 'westpace_layout',
        'label'       => __('Container Max Width (px)', 'westpace-material'),
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1600,
            'step' => 40,
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'westpace_sanitize_sidebar_position',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'type'    => 'radio',
        'section' => 'westpace_layout',
        'label'   => __('Sidebar Position', 'westpace-material'),
        'choices' => array(
            'left'  => __('Left', 'westpace-material'),
            'right' => __('Right', 'westpace-material'),
            'none'  => __('No Sidebar', 'westpace-material'),
        ),
    ));

    // Header Section
    $wp_customize->add_section('westpace_header', array(
        'title'    => __('Header Options', 'westpace-material'),
        'priority' => 45,
    ));

    // Header Style
    $wp_customize->add_setting('header_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'westpace_sanitize_header_style',
    ));

    $wp_customize->add_control('header_style', array(
        'type'    => 'select',
        'section' => 'westpace_header',
        'label'   => __('Header Style', 'westpace-material'),
        'choices' => array(
            'default'     => __('Default', 'westpace-material'),
            'transparent' => __('Transparent', 'westpace-material'),
            'minimal'     => __('Minimal', 'westpace-material'),
        ),
    ));

    // Sticky Header
    $wp_customize->add_setting('sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('sticky_header', array(
        'type'    => 'checkbox',
        'section' => 'westpace_header',
        'label'   => __('Enable Sticky Header', 'westpace-material'),
    ));

    // Search in Header
    $wp_customize->add_setting('header_search', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('header_search', array(
        'type'    => 'checkbox',
        'section' => 'westpace_header',
        'label'   => __('Show Search in Header', 'westpace-material'),
    ));

    // Footer Section
    $wp_customize->add_section('westpace_footer', array(
        'title'    => __('Footer Options', 'westpace-material'),
        'priority' => 50,
    ));

    // Footer Columns
    $wp_customize->add_setting('footer_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('footer_columns', array(
        'type'    => 'select',
        'section' => 'westpace_footer',
        'label'   => __('Footer Widget Columns', 'westpace-material'),
        'choices' => array(
            1 => __('1 Column', 'westpace-material'),
            2 => __('2 Columns', 'westpace-material'),
            3 => __('3 Columns', 'westpace-material'),
            4 => __('4 Columns', 'westpace-material'),
        ),
    ));

    // Company Description
    $wp_customize->add_setting('footer_description', array(
        'default'           => __('West Pace Apparels - Premium Garment Manufacturing Since 1998', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_description', array(
        'type'    => 'textarea',
        'section' => 'westpace_footer',
        'label'   => __('Company Description', 'westpace-material'),
    ));

    // Contact Information
    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_phone', array(
        'type'    => 'tel',
        'section' => 'westpace_footer',
        'label'   => __('Phone Number', 'westpace-material'),
    ));

    $wp_customize->add_setting('footer_phone_display', array(
        'default'           => '(555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_phone_display', array(
        'type'    => 'text',
        'section' => 'westpace_footer',
        'label'   => __('Phone Display Text', 'westpace-material'),
    ));

    $wp_customize->add_setting('footer_email', array(
        'default'           => 'info@westpaceapparels.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_email', array(
        'type'    => 'email',
        'section' => 'westpace_footer',
        'label'   => __('Email Address', 'westpace-material'),
    ));

    $wp_customize->add_setting('footer_address', array(
        'default'           => '123 Fashion Street, Apparel City, AC 12345',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_address', array(
        'type'    => 'textarea',
        'section' => 'westpace_footer',
        'label'   => __('Address', 'westpace-material'),
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '&copy; 2025 West Pace Apparels. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'type'    => 'textarea',
        'section' => 'westpace_footer',
        'label'   => __('Copyright Text', 'westpace-material'),
    ));

    // WooCommerce Settings
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('westpace_woocommerce', array(
            'title'    => __('WooCommerce Options', 'westpace-material'),
            'priority' => 55,
        ));

        // Products per page
        $wp_customize->add_setting('woocommerce_products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('woocommerce_products_per_page', array(
            'type'        => 'number',
            'section'     => 'westpace_woocommerce',
            'label'       => __('Products per Page', 'westpace-material'),
            'input_attrs' => array(
                'min' => 6,
                'max' => 24,
            ),
        ));

        // Product columns
        $wp_customize->add_setting('woocommerce_product_columns', array(
            'default'           => 3,
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control('woocommerce_product_columns', array(
            'type'    => 'select',
            'section' => 'westpace_woocommerce',
            'label'   => __('Product Columns', 'westpace-material'),
            'choices' => array(
                2 => __('2 Columns', 'westpace-material'),
                3 => __('3 Columns', 'westpace-material'),
                4 => __('4 Columns', 'westpace-material'),
            ),
        ));

        // Show cart in header
        $wp_customize->add_setting('woocommerce_cart_header', array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ));

        $wp_customize->add_control('woocommerce_cart_header', array(
            'type'    => 'checkbox',
            'section' => 'westpace_woocommerce',
            'label'   => __('Show Cart Icon in Header', 'westpace-material'),
        ));
    }

    // Performance Section
    $wp_customize->add_section('westpace_performance', array(
        'title'    => __('Performance Options', 'westpace-material'),
        'priority' => 60,
    ));

    // Enable lazy loading
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('enable_lazy_loading', array(
        'type'    => 'checkbox',
        'section' => 'westpace_performance',
        'label'   => __('Enable Lazy Loading for Images', 'westpace-material'),
    ));

    // Minify CSS
    $wp_customize->add_setting('minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('minify_css', array(
        'type'    => 'checkbox',
        'section' => 'westpace_performance',
        'label'   => __('Minify CSS', 'westpace-material'),
    ));

    // GDPR Section
    $wp_customize->add_section('westpace_gdpr', array(
        'title'    => __('GDPR & Privacy', 'westpace-material'),
        'priority' => 65,
    ));

    // Cookie Notice
    $wp_customize->add_setting('enable_cookie_notice', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('enable_cookie_notice', array(
        'type'    => 'checkbox',
        'section' => 'westpace_gdpr',
        'label'   => __('Enable Cookie Notice', 'westpace-material'),
    ));

    // Cookie Notice Text
    $wp_customize->add_setting('cookie_notice_text', array(
        'default'           => __('This website uses cookies to improve your experience. By continuing to use this site, you accept our use of cookies.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('cookie_notice_text', array(
        'type'            => 'textarea',
        'section'         => 'westpace_gdpr',
        'label'           => __('Cookie Notice Text', 'westpace-material'),
        'active_callback' => 'westpace_is_cookie_notice_enabled',
    ));

    // Privacy Policy Page
    $wp_customize->add_setting('privacy_policy_page', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('privacy_policy_page', array(
        'type'    => 'dropdown-pages',
        'section' => 'westpace_gdpr',
        'label'   => __('Privacy Policy Page', 'westpace-material'),
    ));

    // Custom CSS Section (if not already present)
    if (!$wp_customize->get_section('custom_css')) {
        $wp_customize->add_section('westpace_custom_css', array(
            'title'       => __('Additional CSS', 'westpace-material'),
            'priority'    => 200,
            'description' => __('Add custom CSS here to override theme styles.', 'westpace-material'),
        ));

        $wp_customize->add_setting('westpace_custom_css', array(
            'default'           => '',
            'sanitize_callback' => 'wp_strip_all_tags',
        ));

        $wp_customize->add_control('westpace_custom_css', array(
            'type'    => 'textarea',
            'section' => 'westpace_custom_css',
            'label'   => __('Custom CSS', 'westpace-material'),
        ));
    }
}
add_action('customize_register', 'westpace_customize_register');

/**
 * Sanitization functions
 */
function westpace_sanitize_font($input) {
    $valid = westpace_get_font_choices();
    return array_key_exists($input, $valid) ? $input : 'Inter';
}

function westpace_sanitize_sidebar_position($input) {
    $valid = array('left', 'right', 'none');
    return in_array($input, $valid) ? $input : 'right';
}

function westpace_sanitize_header_style($input) {
    $valid = array('default', 'transparent', 'minimal');
    return in_array($input, $valid) ? $input : 'default';
}

/**
 * Active callback functions
 */
function westpace_is_cookie_notice_enabled() {
    return get_theme_mod('enable_cookie_notice', false);
}

/**
 * Font choices
 */
function westpace_get_font_choices() {
    return array(
        'System'        => __('System Font', 'westpace-material'),
        'Inter'         => 'Inter',
        'Roboto'        => 'Roboto',
        'Open Sans'     => 'Open Sans',
        'Lato'          => 'Lato',
        'Poppins'       => 'Poppins',
        'Montserrat'    => 'Montserrat',
        'Source Sans Pro' => 'Source Sans Pro',
        'Nunito'        => 'Nunito',
        'PT Sans'       => 'PT Sans',
        'Roboto Slab'   => 'Roboto Slab',
        'Playfair Display' => 'Playfair Display',
        'Merriweather'  => 'Merriweather',
    );
}

/**
 * Bind JS handlers to instantly live-preview changes
 */
function westpace_customize_preview_js() {
    wp_enqueue_script('westpace-customizer', WESTPACE_THEME_URI . '/assets/js/customizer.js', array('customize-preview'), WESTPACE_VERSION, true);
}
add_action('customize_preview_init', 'westpace_customize_preview_js');

/**
 * Enqueue customizer control scripts
 */
function westpace_customize_controls_js() {
    wp_enqueue_script('westpace-customizer-controls', WESTPACE_THEME_URI . '/assets/js/customizer-controls.js', array('customize-controls'), WESTPACE_VERSION, true);
}
add_action('customize_controls_enqueue_scripts', 'westpace_customize_controls_js');

/**
 * Output customizer CSS
 */
function westpace_customizer_css() {
    $primary_color = get_theme_mod('westpace_primary_color', '#1976D2');
    $secondary_color = get_theme_mod('westpace_secondary_color', '#FF6D00');
    $text_color = get_theme_mod('westpace_text_color', '#0F172A');
    $background_color = get_theme_mod('westpace_background_color', '#FFFFFF');
    $container_width = get_theme_mod('container_width', 1200);
    $base_font_size = get_theme_mod('base_font_size', 16);
    $heading_font = get_theme_mod('heading_font', 'Inter');
    $body_font = get_theme_mod('body_font', 'Inter');
    $custom_css = get_theme_mod('westpace_custom_css', '');
    
    ?>
    <style type="text/css" id="westpace-customizer-css">
        :root {
            --primary-600: <?php echo esc_attr($primary_color); ?>;
            --primary-700: <?php echo esc_attr(westpace_darken_color($primary_color, 0.1)); ?>;
            --primary-800: <?php echo esc_attr(westpace_darken_color($primary_color, 0.2)); ?>;
            --primary-500: <?php echo esc_attr(westpace_lighten_color($primary_color, 0.1)); ?>;
            --primary-400: <?php echo esc_attr(westpace_lighten_color($primary_color, 0.2)); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --text-primary: <?php echo esc_attr($text_color); ?>;
            --background: <?php echo esc_attr($background_color); ?>;
            --container-width: <?php echo esc_attr($container_width); ?>px;
            --base-font-size: <?php echo esc_attr($base_font_size); ?>px;
        }
        
        <?php if ($heading_font !== 'Inter') : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $heading_font)); ?>:wght@300;400;500;600;700;800;900&display=swap');
        <?php endif; ?>
        
        <?php if ($body_font !== 'Inter' && $body_font !== $heading_font) : ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $body_font)); ?>:wght@300;400;500;600;700&display=swap');
        <?php endif; ?>
        
        body {
            font-family: <?php echo $body_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($body_font) . '", sans-serif'; ?>;
            font-size: var(--base-font-size);
            background-color: var(--background);
            color: var(--text-primary);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: <?php echo $heading_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($heading_font) . '", sans-serif'; ?>;
        }
        
        .container {
            max-width: var(--container-width);
        }
        
        .btn-primary {
            background-color: var(--primary-600);
            border-color: var(--primary-600);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-700);
            border-color: var(--primary-700);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        a {
            color: var(--primary-600);
        }
        
        a:hover {
            color: var(--primary-700);
        }
        
        <?php if ($custom_css) : ?>
        /* Custom CSS */
        <?php echo wp_strip_all_tags($custom_css); ?>
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'westpace_customizer_css');

/**
 * Add CSS classes based on customizer settings
 */
function westpace_customizer_body_classes($classes) {
    $header_style = get_theme_mod('header_style', 'default');
    $sidebar_position = get_theme_mod('sidebar_position', 'right');
    $footer_columns = get_theme_mod('footer_columns', 4);
    
    $classes[] = 'header-' . esc_attr($header_style);
    $classes[] = 'sidebar-' . esc_attr($sidebar_position);
    $classes[] = 'footer-cols-' . esc_attr($footer_columns);
    
    if (get_theme_mod('sticky_header', true)) {
        $classes[] = 'sticky-header';
    }
    
    if (get_theme_mod('enable_lazy_loading', true)) {
        $classes[] = 'lazy-loading-enabled';
    }
    
    return $classes;
}
add_filter('body_class', 'westpace_customizer_body_classes');

/**
 * Custom CSS minification
 */
function westpace_minify_css($css) {
    if (!get_theme_mod('minify_css', false)) {
        return $css;
    }
    
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    
    // Remove whitespace
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    
    return $css;
}

/**
 * Customizer selective refresh
 */
function westpace_customize_partial_blogname() {
    bloginfo('name');
}

function westpace_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Register partials for selective refresh
 */
function westpace_customize_register_partials($wp_customize) {
    // Abort if selective refresh is not available
    if (!isset($wp_customize->selective_refresh)) {
        return;
    }

    $wp_customize->selective_refresh->add_partial('blogname', array(
        'selector'        => '.site-title a',
        'render_callback' => 'westpace_customize_partial_blogname',
    ));

    $wp_customize->selective_refresh->add_partial('blogdescription', array(
        'selector'        => '.site-description',
        'render_callback' => 'westpace_customize_partial_blogdescription',
    ));
}
add_action('customize_register', 'westpace_customize_register_partials');

/**
 * Customizer styles for the admin
 */
function westpace_customizer_styles() {
    ?>
    <style type="text/css">
        .customize-control-title {
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .customize-control-description {
            font-style: italic;
            color: #666;
            margin-bottom: 10px;
        }
        
        .customize-section-title {
            border-bottom: 2px solid #1976D2;
            padding-bottom: 5px;
            color: #1976D2;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'westpace_customizer_styles');