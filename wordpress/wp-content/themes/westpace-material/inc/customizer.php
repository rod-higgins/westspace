<?php
/**
 * Westpace Material Theme Customizer
 * Enhanced WordPress Customizer with Material Design options
 * 
 * @package Westpace_Material
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function westpace_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Remove default sections we'll replace
    $wp_customize->remove_section('colors');

    /**
     * Theme Options Panel
     */
    $wp_customize->add_panel('westpace_theme_options', array(
        'title'       => __('Westpace Theme Options', 'westpace-material'),
        'description' => __('Customize your Westpace Material theme settings.', 'westpace-material'),
        'priority'    => 30,
    ));

    /**
     * Brand Colors Section
     */
    $wp_customize->add_section('westpace_colors', array(
        'title'    => __('Brand Colors', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 10,
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

    /**
     * Typography Section
     */
    $wp_customize->add_section('westpace_typography', array(
        'title'    => __('Typography', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 20,
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
            'Open Sans'   => 'Open Sans',
            'Lato'        => 'Lato',
            'Montserrat'  => 'Montserrat',
            'Poppins'     => 'Poppins',
            'Playfair Display' => 'Playfair Display',
            'System'      => 'System Default',
        ),
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
            'Montserrat'  => 'Montserrat',
            'Poppins'     => 'Poppins',
            'System'      => 'System Default',
        ),
    ));

    // Base Font Size
    $wp_customize->add_setting('base_font_size', array(
        'default'           => 16,
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

    /**
     * Layout Section
     */
    $wp_customize->add_section('westpace_layout', array(
        'title'    => __('Layout Options', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 30,
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => __('Container Max Width (px)', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 1000,
            'max'  => 1400,
            'step' => 50,
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'sanitize_text_field',
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

    /**
     * Hero Section
     */
    $wp_customize->add_section('westpace_hero', array(
        'title'    => __('Hero Section', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 40,
    ));

    // Show Hero Section
    $wp_customize->add_setting('show_hero_section', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('show_hero_section', array(
        'label'   => __('Show Hero Section', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'checkbox',
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('West Pace Apparels', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Premium Garment Manufacturing Since 1998', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'text',
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default'           => __('Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'   => __('Hero Description', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'textarea',
    ));

    // Hero CTA Text
    $wp_customize->add_setting('hero_cta_text', array(
        'default'           => __('Shop Now', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_cta_text', array(
        'label'   => __('Hero Button Text', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'text',
    ));

    // Hero CTA URL
    $wp_customize->add_setting('hero_cta_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_cta_url', array(
        'label'   => __('Hero Button URL', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'url',
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'    => __('Hero Background Image', 'westpace-material'),
        'section'  => 'westpace_hero',
        'settings' => 'hero_background_image',
    )));

    /**
     * Footer Section
     */
    $wp_customize->add_section('westpace_footer', array(
        'title'    => __('Footer Options', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 50,
    ));

    // Footer Description
    $wp_customize->add_setting('footer_description', array(
        'default'           => __('Premium garment manufacturing with over 24 years of excellence. Serving Australia, New Zealand, and the South Pacific.', 'westpace-material'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_description', array(
        'label'   => __('Footer Description', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'textarea',
    ));

    // Footer Phone
    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+679123456',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_phone', array(
        'label'   => __('Footer Phone Number', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'text',
    ));

    // Footer Email
    $wp_customize->add_setting('footer_email', array(
        'default'           => 'info@westpace.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_email', array(
        'label'   => __('Footer Email', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'email',
    ));

    // Footer Address
    $wp_customize->add_setting('footer_address', array(
        'default'           => 'Suva, Fiji Islands',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_address', array(
        'label'   => __('Footer Address', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'text',
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => sprintf(__('&copy; %s West Pace Apparels. All rights reserved.', 'westpace-material'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Copyright Text', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'textarea',
    ));

    /**
     * WooCommerce Section (if active)
     */
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section('westpace_woocommerce', array(
            'title'    => __('WooCommerce Options', 'westpace-material'),
            'panel'    => 'westpace_theme_options',
            'priority' => 60,
        ));

        // Products per page
        $wp_customize->add_setting('woocommerce_products_per_page', array(
            'default'           => 12,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('woocommerce_products_per_page', array(
            'label'   => __('Products per Page', 'westpace-material'),
            'section' => 'westpace_woocommerce',
            'type'    => 'number',
        ));

        // Product columns
        $wp_customize->add_setting('woocommerce_product_columns', array(
            'default'           => 3,
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('woocommerce_product_columns', array(
            'label'   => __('Product Columns', 'westpace-material'),
            'section' => 'westpace_woocommerce',
            'type'    => 'select',
            'choices' => array(
                2 => '2',
                3 => '3',
                4 => '4',
            ),
        ));
    }

    /**
     * Performance Section
     */
    $wp_customize->add_section('westpace_performance', array(
        'title'    => __('Performance', 'westpace-material'),
        'panel'    => 'westpace_theme_options',
        'priority' => 70,
    ));

    // Enable Lazy Loading
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('enable_lazy_loading', array(
        'label'   => __('Enable Lazy Loading', 'westpace-material'),
        'section' => 'westpace_performance',
        'type'    => 'checkbox',
    ));

    // Preload Critical Resources
    $wp_customize->add_setting('preload_critical_resources', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('preload_critical_resources', array(
        'label'   => __('Preload Critical Resources', 'westpace-material'),
        'section' => 'westpace_performance',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'westpace_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
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
    </style>
    <?php
}
add_action('wp_head', 'westpace_customizer_css');