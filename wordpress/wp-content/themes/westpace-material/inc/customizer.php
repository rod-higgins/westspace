<?php
/**
 * Westpace Material Theme Customizer
 * 
 * @package Westpace_Material
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function westpace_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'westpace_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'westpace_customize_partial_blogdescription',
        ));
    }

    // Theme Options Panel
    $wp_customize->add_panel('westpace_theme_options', array(
        'title'       => __('Theme Options', 'westpace-material'),
        'description' => __('Customize your theme settings', 'westpace-material'),
        'priority'    => 30,
    ));

    // Colors Section
    $wp_customize->add_section('westpace_colors', array(
        'title'    => __('Colors', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 10,
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#2196F3',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => __('Primary Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#FF9800',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => __('Secondary Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'secondary_color',
    )));

    // Background Color
    $wp_customize->add_setting('background_color', array(
        'default'           => '#F8FAFC',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_color', array(
        'label'    => __('Background Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'background_color',
    )));

    // Text Color
    $wp_customize->add_setting('text_color', array(
        'default'           => '#334155',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'text_color', array(
        'label'    => __('Text Color', 'westpace-material'),
        'section'  => 'westpace_colors',
        'settings' => 'text_color',
    )));

    // Typography Section
    $wp_customize->add_section('westpace_typography', array(
        'title'    => __('Typography', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 20,
    ));

    // Body Font
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('body_font', array(
        'label'    => __('Body Font', 'westpace-material'),
        'section'  => 'westpace_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'       => 'Inter',
            'Roboto'      => 'Roboto',
            'Open Sans'   => 'Open Sans',
            'Lato'        => 'Lato',
            'Poppins'     => 'Poppins',
            'Montserrat'  => 'Montserrat',
            'Source Sans Pro' => 'Source Sans Pro',
            'System'      => 'System Default',
        ),
    ));

    // Heading Font
    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('heading_font', array(
        'label'    => __('Heading Font', 'westpace-material'),
        'section'  => 'westpace_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'       => 'Inter',
            'Roboto'      => 'Roboto',
            'Roboto Slab' => 'Roboto Slab',
            'Playfair Display' => 'Playfair Display',
            'Merriweather' => 'Merriweather',
            'Montserrat'  => 'Montserrat',
            'Poppins'     => 'Poppins',
            'System'      => 'System Default',
        ),
    ));

    // Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('base_font_size', array(
        'label'       => __('Base Font Size (px)', 'westpace-material'),
        'section'     => 'westpace_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 20,
            'step' => 1,
        ),
    ));

    // Layout Section
    $wp_customize->add_section('westpace_layout', array(
        'title'    => __('Layout', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 30,
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => __('Container Max Width (px)', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1400,
            'step' => 20,
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'label'   => __('Sidebar Position', 'westpace-material'),
        'section' => 'westpace_layout',
        'type'    => 'select',
        'choices' => array(
            'left'  => __('Left', 'westpace-material'),
            'right' => __('Right', 'westpace-material'),
            'none'  => __('No Sidebar', 'westpace-material'),
        ),
    ));

    // Header Section
    $wp_customize->add_section('westpace_header', array(
        'title'    => __('Header', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 40,
    ));

    // Header Style
    $wp_customize->add_setting('header_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('header_style', array(
        'label'   => __('Header Style', 'westpace-material'),
        'section' => 'westpace_header',
        'type'    => 'select',
        'choices' => array(
            'default'     => __('Default', 'westpace-material'),
            'transparent' => __('Transparent', 'westpace-material'),
            'minimal'     => __('Minimal', 'westpace-material'),
            'centered'    => __('Centered', 'westpace-material'),
        ),
    ));

    // Sticky Header
    $wp_customize->add_setting('sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('sticky_header', array(
        'label'   => __('Sticky Header', 'westpace-material'),
        'section' => 'westpace_header',
        'type'    => 'checkbox',
    ));

    // Show Search in Header
    $wp_customize->add_setting('show_header_search', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_header_search', array(
        'label'   => __('Show Search in Header', 'westpace-material'),
        'section' => 'westpace_header',
        'type'    => 'checkbox',
    ));

    // Footer Section
    $wp_customize->add_section('westpace_footer', array(
        'title'    => __('Footer', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 50,
    ));

    // Footer Columns
    $wp_customize->add_setting('footer_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('footer_columns', array(
        'label'   => __('Footer Widget Columns', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'select',
        'choices' => array(
            1 => __('1 Column', 'westpace-material'),
            2 => __('2 Columns', 'westpace-material'),
            3 => __('3 Columns', 'westpace-material'),
            4 => __('4 Columns', 'westpace-material'),
        ),
    ));

    // Copyright Text
    $wp_customize->add_setting('copyright_text', array(
        'default'           => '© 2025 West Pace Apparels. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('copyright_text', array(
        'label'   => __('Copyright Text', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'textarea',
    ));

    // Blog Section
    $wp_customize->add_section('westpace_blog', array(
        'title'    => __('Blog', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 60,
    ));

    // Posts per page
    $wp_customize->add_setting('posts_per_page', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('posts_per_page', array(
        'label'       => __('Posts per Page', 'westpace-material'),
        'section'     => 'westpace_blog',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Show excerpts
    $wp_customize->add_setting('show_excerpts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_excerpts', array(
        'label'   => __('Show Post Excerpts', 'westpace-material'),
        'section' => 'westpace_blog',
        'type'    => 'checkbox',
    ));

    // Show breadcrumbs
    $wp_customize->add_setting('show_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_breadcrumbs', array(
        'label'   => __('Show Breadcrumbs', 'westpace-material'),
        'section' => 'westpace_blog',
        'type'    => 'checkbox',
    ));

    // Performance Section
    $wp_customize->add_section('westpace_performance', array(
        'title'    => __('Performance', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 70,
    ));

    // Enable lazy loading
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('enable_lazy_loading', array(
        'label'       => __('Enable Lazy Loading', 'westpace-material'),
        'description' => __('Improves page load speed by loading images as they come into view.', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'checkbox',
    ));

    // Minify CSS
    $wp_customize->add_setting('minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('minify_css', array(
        'label'       => __('Minify CSS', 'westpace-material'),
        'description' => __('Reduces CSS file size by removing whitespace and comments.', 'westpace-material'),
        'section'     => 'westpace_performance',
        'type'        => 'checkbox',
    ));

    // WooCommerce Section (if WooCommerce is active)
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('westpace_woocommerce', array(
            'title'    => __('WooCommerce', 'westpace-material'),
            'panel'    => 'westpace_theme_options',
            'priority' => 80,
        ));

        // Products per page
        $wp_customize->add_setting('woocommerce_products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control('woocommerce_products_per_page', array(
            'label'       => __('Products per Page', 'westpace-material'),
            'section'     => 'westpace_woocommerce',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 6,
                'max' => 24,
            ),
        ));

        // Product columns
        $wp_customize->add_setting('woocommerce_product_columns', array(
            'default'           => 3,
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control('woocommerce_product_columns', array(
            'label'   => __('Product Columns', 'westpace-material'),
            'section' => 'westpace_woocommerce',
            'type'    => 'select',
            'choices' => array(
                2 => __('2 Columns', 'westpace-material'),
                3 => __('3 Columns', 'westpace-material'),
                4 => __('4 Columns', 'westpace-material'),
            ),
        ));
    }

    // Custom CSS Section
    $wp_customize->add_section('westpace_custom_css', array(
        'title'    => __('Additional CSS', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 90,
    ));

    $wp_customize->add_setting('custom_css', array(
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('custom_css', array(
        'label'       => __('Custom CSS', 'westpace-material'),
        'description' => __('Add custom CSS code here.', 'westpace-material'),
        'section'     => 'westpace_custom_css',
        'type'        => 'textarea',
        'input_attrs' => array(
            'placeholder' => __('Enter your custom CSS here...', 'westpace-material'),
        ),
    ));
}
add_action('customize_register', 'westpace_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function westpace_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function westpace_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitize select fields
 */
function westpace_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function westpace_customize_preview_js() {
    wp_enqueue_script('westpace-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '20210101', true);
}
add_action('customize_preview_init', 'westpace_customize_preview_js');

/**
 * Enqueue customizer controls script
 */
function westpace_customize_controls_js() {
    wp_enqueue_script('westpace-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array('customize-controls'), '20210101', true);
}
add_action('customize_controls_enqueue_scripts', 'westpace_customize_controls_js');

/**
 * Output customizer CSS
 */
function westpace_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#2196F3');
    $secondary_color = get_theme_mod('secondary_color', '#FF9800');
    $background_color = get_theme_mod('background_color', '#F8FAFC');
    $text_color = get_theme_mod('text_color', '#334155');
    $body_font = get_theme_mod('body_font', 'Inter');
    $heading_font = get_theme_mod('heading_font', 'Inter');
    $base_font_size = get_theme_mod('base_font_size', 16);
    $container_width = get_theme_mod('container_width', 1200);
    $custom_css = get_theme_mod('custom_css', '');
    ?>
    <style type="text/css" id="westpace-customizer-css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --background: <?php echo esc_attr($background_color); ?>;
            --text-primary: <?php echo esc_attr($text_color); ?>;
            --base-font-size: <?php echo esc_attr($base_font_size); ?>px;
            --container-width: <?php echo esc_attr($container_width); ?>px;
        }
        
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
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--primary-color) 90%, black);
            border-color: color-mix(in srgb, var(--primary-color) 90%, black);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-secondary:hover {
            background-color: color-mix(in srgb, var(--secondary-color) 90%, black);
            border-color: color-mix(in srgb, var(--secondary-color) 90%, black);
        }
        
        a {
            color: var(--primary-color);
        }
        
        a:hover {
            color: color-mix(in srgb, var(--primary-color) 90%, black);
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .border-primary {
            border-color: var(--primary-color) !important;
        }
        
        .text-secondary {
            color: var(--secondary-color) !important;
        }
        
        .bg-secondary {
            background-color: var(--secondary-color) !important;
        }
        
        .border-secondary {
            border-color: var(--secondary-color) !important;
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
 * Add font loading for custom fonts
 */
function westpace_custom_fonts() {
    $body_font = get_theme_mod('body_font', 'Inter');
    $heading_font = get_theme_mod('heading_font', 'Inter');
    
    $fonts = array();
    
    if ($body_font !== 'System') {
        $fonts[] = $body_font . ':wght@300;400;500;600;700';
    }
    
    if ($heading_font !== 'System' && $heading_font !== $body_font) {
        $fonts[] = $heading_font . ':wght@300;400;500;600;700;800';
    }
    
    if (!empty($fonts)) {
        $font_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
        wp_enqueue_style('westpace-custom-fonts', $font_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'westpace_custom_fonts');

/**
 * Add real-time preview support for certain settings
 */
function westpace_customize_preview_js_vars() {
    if (is_customize_preview()) {
        wp_localize_script('westpace-customizer', 'westpaceCustomizer', array(
            'primaryColor'   => get_theme_mod('primary_color', '#2196F3'),
            'secondaryColor' => get_theme_mod('secondary_color', '#FF9800'),
            'textColor'      => get_theme_mod('text_color', '#334155'),
            'backgroundColor' => get_theme_mod('background_color', '#F8FAFC'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'westpace_customize_preview_js_vars');