<?php
/**
 * Westpace Material Theme Customizer
 * Comprehensive customization options with modern interface
 * 
 * @package Westpace_Material
 * @version 3.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function westpace_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Remove default background image control
    $wp_customize->remove_control('background_image');

    /**
     * ========================================
     * THEME COLORS SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_colors', array(
        'title'    => __('Theme Colors', 'westpace-material'),
        'priority' => 30,
        'description' => __('Customize the color scheme of your website. Changes will be reflected immediately in the preview.', 'westpace-material'),
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
     * ========================================
     * TYPOGRAPHY SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_typography', array(
        'title'    => __('Typography', 'westpace-material'),
        'priority' => 35,
        'description' => __('Choose fonts and adjust text sizing for your website.', 'westpace-material'),
    ));

    // Heading Font
    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('heading_font', array(
        'label'    => __('Heading Font', 'westpace-material'),
        'section'  => 'westpace_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'        => 'Inter',
            'Roboto'       => 'Roboto',
            'Open Sans'    => 'Open Sans',
            'Lato'         => 'Lato',
            'Montserrat'   => 'Montserrat',
            'Poppins'      => 'Poppins',
            'System'       => 'System Font',
        ),
    ));

    // Body Font
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('body_font', array(
        'label'    => __('Body Font', 'westpace-material'),
        'section'  => 'westpace_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'        => 'Inter',
            'Roboto'       => 'Roboto',
            'Open Sans'    => 'Open Sans',
            'Lato'         => 'Lato',
            'Montserrat'   => 'Montserrat',
            'Poppins'      => 'Poppins',
            'System'       => 'System Font',
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
     * ========================================
     * LAYOUT SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_layout', array(
        'title'    => __('Layout Options', 'westpace-material'),
        'priority' => 40,
        'description' => __('Customize the layout and structure of your website.', 'westpace-material'),
    ));

    // Container Width
    $wp_customize->add_setting('container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => __('Container Width (px)', 'westpace-material'),
        'section'     => 'westpace_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 1000,
            'max'  => 1400,
            'step' => 50,
        ),
    ));

    // Header Style
    $wp_customize->add_setting('header_style', array(
        'default'           => 'fixed',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('header_style', array(
        'label'    => __('Header Style', 'westpace-material'),
        'section'  => 'westpace_layout',
        'type'     => 'select',
        'choices'  => array(
            'fixed'  => __('Fixed Header', 'westpace-material'),
            'static' => __('Static Header', 'westpace-material'),
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'westpace_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'label'    => __('Sidebar Position', 'westpace-material'),
        'section'  => 'westpace_layout',
        'type'     => 'select',
        'choices'  => array(
            'left'  => __('Left Sidebar', 'westpace-material'),
            'right' => __('Right Sidebar', 'westpace-material'),
            'none'  => __('No Sidebar', 'westpace-material'),
        ),
    ));

    /**
     * ========================================
     * HERO SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_hero', array(
        'title'    => __('Hero Section', 'westpace-material'),
        'priority' => 45,
        'description' => __('Customize the hero section on your homepage.', 'westpace-material'),
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

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'hero_background_image', array(
        'label'     => __('Hero Background Image', 'westpace-material'),
        'section'   => 'westpace_hero',
        'mime_type' => 'image',
    )));

    // Hero Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => __('Shop Now', 'westpace-material'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_text', array(
        'label'   => __('Hero Button Text', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'text',
    ));

    // Hero Button URL
    $wp_customize->add_setting('hero_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_url', array(
        'label'   => __('Hero Button URL', 'westpace-material'),
        'section' => 'westpace_hero',
        'type'    => 'url',
    ));

    /**
     * ========================================
     * FOOTER SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_footer', array(
        'title'    => __('Footer Settings', 'westpace-material'),
        'priority' => 50,
        'description' => __('Customize footer content and contact information.', 'westpace-material'),
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
        'label'   => __('Phone Number', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'text',
    ));

    // Footer Phone Display
    $wp_customize->add_setting('footer_phone_display', array(
        'default'           => '+679 123 456',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_phone_display', array(
        'label'   => __('Phone Number (Display Format)', 'westpace-material'),
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
        'label'   => __('Email Address', 'westpace-material'),
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
        'label'   => __('Address', 'westpace-material'),
        'section' => 'westpace_footer',
        'type'    => 'text',
    ));

    /**
     * ========================================
     * PERFORMANCE SECTION
     * ========================================
     */
    $wp_customize->add_section('westpace_performance', array(
        'title'    => __('Performance Options', 'westpace-material'),
        'priority' => 55,
        'description' => __('Configure performance and optimization settings.', 'westpace-material'),
    ));

    // Enable Animations
    $wp_customize->add_setting('enable_animations', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('enable_animations', array(
        'label'   => __('Enable Animations', 'westpace-material'),
        'section' => 'westpace_performance',
        'type'    => 'checkbox',
    ));

    // Lazy Load Images
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'westpace_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('enable_lazy_loading', array(
        'label'   => __('Enable Lazy Loading for Images', 'westpace-material'),
        'section' => 'westpace_performance',
        'type'    => 'checkbox',
    ));

    /**
     * ========================================
     * SELECTIVE REFRESH
     * ========================================
     */
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('hero_title', array(
            'selector'        => '.hero-title',
            'render_callback' => function() { return get_theme_mod('hero_title', __('West Pace Apparels', 'westpace-material')); },
        ));

        $wp_customize->selective_refresh->add_partial('hero_subtitle', array(
            'selector'        => '.hero-subtitle',
            'render_callback' => function() { return get_theme_mod('hero_subtitle', __('Premium Garment Manufacturing Since 1998', 'westpace-material')); },
        ));

        $wp_customize->selective_refresh->add_partial('hero_description', array(
            'selector'        => '.hero-description',
            'render_callback' => function() { return get_theme_mod('hero_description'); },
        ));

        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title',
            'render_callback' => 'westpace_customize_partial_blogname',
        ));

        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'westpace_customize_partial_blogdescription',
        ));
    }
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
 * Sanitize checkbox values
 */
function westpace_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
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
 * Helper function to darken a color
 */
function westpace_darken_color($color, $amount) {
    $color = ltrim($color, '#');
    $rgb = array_map('hexdec', str_split($color, 2));
    
    foreach ($rgb as &$value) {
        $value = max(0, min(255, $value - ($value * $amount)));
    }
    
    return '#' . implode('', array_map(function($val) {
        return str_pad(dechex($val), 2, '0', STR_PAD_LEFT);
    }, $rgb));
}

/**
 * Helper function to lighten a color
 */
function westpace_lighten_color($color, $amount) {
    $color = ltrim($color, '#');
    $rgb = array_map('hexdec', str_split($color, 2));
    
    foreach ($rgb as &$value) {
        $value = max(0, min(255, $value + (255 - $value) * $amount));
    }
    
    return '#' . implode('', array_map(function($val) {
        return str_pad(dechex($val), 2, '0', STR_PAD_LEFT);
    }, $rgb));
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
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
            font-family: <?php echo $body_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($body_font) . '", -apple-system, BlinkMacSystemFont, sans-serif'; ?>;
            font-size: var(--base-font-size);
            color: var(--text-primary);
            background-color: var(--background);
        }
        
        h1, h2, h3, h4, h5, h6,
        .hero-title,
        .section-title,
        .post-title,
        .page-title {
            font-family: <?php echo $heading_font === 'System' ? '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : '"' . esc_attr($heading_font) . '", -apple-system, BlinkMacSystemFont, sans-serif'; ?>;
        }
        
        .container {
            max-width: var(--container-width);
        }
        
        .btn-primary,
        .button,
        .wp-block-button__link {
            background-color: var(--primary-600);
            border-color: var(--primary-600);
        }
        
        .btn-primary:hover,
        .button:hover,
        .wp-block-button__link:hover {
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
        
        <?php if (!get_theme_mod('enable_animations', true)) : ?>
        * {
            animation: none !important;
            transition: none !important;
        }
        <?php endif; ?>
        
        <?php if (get_theme_mod('header_style', 'fixed') === 'static') : ?>
        .site-header {
            position: relative;
        }
        .site-content {
            padding-top: 0;
        }
        <?php endif; ?>
        
        <?php if (get_theme_mod('sidebar_position', 'right') === 'left') : ?>
        .blog-layout.has-sidebar {
            grid-template-columns: 300px 1fr;
        }
        <?php elseif (get_theme_mod('sidebar_position', 'right') === 'none') : ?>
        .blog-layout {
            grid-template-columns: 1fr;
        }
        .blog-layout .main-content {
            max-width: 800px;
            margin: 0 auto;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'westpace_customizer_css');