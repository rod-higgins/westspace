<?php
/**
 * Simple West Pace Theme Generator
 * Fixed version without escaping issues
 */

class SimpleWestPaceGenerator {
    private $theme_path;
    private $log = array();
    
    public function __construct() {
        $this->theme_path = dirname(__FILE__) . '/wp-content/themes/westpace-material';
        $this->log[] = 'Starting theme generation...';
    }
    
    public function generate() {
        try {
            $this->createDirectories();
            $this->createCoreFiles();
            $this->createAssets();
            $this->createTemplates();
            $this->createWooCommerceFiles();
            $this->log[] = 'Theme generation completed successfully!';
        } catch (Exception $e) {
            $this->log[] = 'Error: ' . $e->getMessage();
        }
        return $this->log;
    }
    
    private function createDirectories() {
        $dirs = array(
            $this->theme_path,
            $this->theme_path . '/assets',
            $this->theme_path . '/assets/css',
            $this->theme_path . '/assets/js',
            $this->theme_path . '/assets/images',
            $this->theme_path . '/inc',
            $this->theme_path . '/template-parts',
            $this->theme_path . '/woocommerce'
        );
        
        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
                $this->log[] = 'Created directory: ' . basename($dir);
            }
        }
    }
    
    private function createCoreFiles() {
        // style.css
        $style_css = <<<CSS
/*
Theme Name: West Pace Material Design
Description: Material Design WordPress theme for West Pace Apparels with WooCommerce integration
Version: 1.0.0
Author: West Pace Development Team
Text Domain: westpace-material
Tags: material-design, ecommerce, woocommerce, business, manufacturing
*/

:root {
  --primary-color: #1976d2;
  --primary-light: #42a5f5;
  --primary-dark: #1565c0;
  --secondary-color: #ff9800;
  --background-color: #fafafa;
  --surface-color: #ffffff;
  --text-primary: rgba(0, 0, 0, 0.87);
  --text-secondary: rgba(0, 0, 0, 0.60);
}

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

body {
  font-family: 'Roboto', sans-serif;
  margin: 0;
  padding: 0;
  background-color: var(--background-color);
  color: var(--text-primary);
  line-height: 1.6;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 16px;
}

.elevation-1 { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
.elevation-2 { box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); }
CSS;
        
        // functions.php
        $functions_php = <<<'PHP'
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
PHP;
        
        // header.php
        $header_php = <<<'PHP'
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header elevation-2">
        <div class="container">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>
            
            <nav class="main-navigation">
                <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
            </nav>
            
            <?php if (class_exists('WooCommerce')) : ?>
            <div class="header-cart">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    <span class="material-icons">shopping_cart</span>
                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </header>
    
    <div id="content" class="site-content">
PHP;
        
        // footer.php
        $footer_php = <<<'PHP'
    </div><!-- #content -->
    
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="company-info">
                    <h3>West Pace Apparels Ltd</h3>
                    <p>Family-owned Fijian Company with over 24 years of experience specializing in school wear, workwear, and winterwear.</p>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
PHP;
        
        // Save files
        $this->saveFile('/style.css', $style_css);
        $this->saveFile('/functions.php', $functions_php);
        $this->saveFile('/header.php', $header_php);
        $this->saveFile('/footer.php', $footer_php);
    }
    
    private function createTemplates() {
        // index.php
        $index_php = <<<'PHP'
<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
PHP;
        
        // front-page.php
        $front_page_php = <<<'PHP'
<?php get_header(); ?>

<main class="site-main front-page">
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>West Pace Apparels</h1>
                <p class="hero-subtitle">Premium Garment Manufacturing Since 1998</p>
                <p>Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets.</p>
                <div class="hero-actions">
                    <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary">View Products</a>
                    <?php endif; ?>
                    <a href="/contact/" class="btn btn-secondary">Get Quote</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="services-section">
        <div class="container">
            <h2>What We Offer</h2>
            <div class="services-grid">
                <div class="service-card">
                    <span class="material-icons">speed</span>
                    <h3>Flexible Short Runs</h3>
                    <p>Accommodate both small and large quantity orders with quick turnaround times.</p>
                </div>
                <div class="service-card">
                    <span class="material-icons">verified</span>
                    <h3>Quality Control</h3>
                    <p>Comprehensive quality assurance systems ensure reliable, consistent products.</p>
                </div>
                <div class="service-card">
                    <span class="material-icons">local_shipping</span>
                    <h3>Fast Delivery</h3>
                    <p>Prompt service with efficient shipping to Australia and South Pacific regions.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
PHP;
        
        // page.php
        $page_php = <<<'PHP'
<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <article <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
PHP;
        
        // 404.php
        $error_404_php = <<<'PHP'
<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <h1>Page Not Found</h1>
        <p>The page you are looking for could not be found.</p>
    </div>
</main>
<?php get_footer(); ?>
PHP;
        
        $this->saveFile('/index.php', $index_php);
        $this->saveFile('/front-page.php', $front_page_php);
        $this->saveFile('/page.php', $page_php);
        $this->saveFile('/single.php', $page_php); // Reuse page template
        $this->saveFile('/archive.php', $index_php); // Reuse index template
        $this->saveFile('/404.php', $error_404_php);
    }
    
    private function createAssets() {
        // Material Design CSS
        $material_css = <<<CSS
/* Material Design Components */
.btn {
    display: inline-block;
    padding: 12px 24px;
    margin: 4px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.16);
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.24);
}

.site-header {
    background: white;
    padding: 16px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.site-header .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.hero-section {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    padding: 80px 0;
    text-align: center;
}

.hero-actions {
    margin-top: 32px;
}

.services-section {
    padding: 80px 0;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 48px;
}

.service-card {
    background: white;
    padding: 32px 24px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-4px);
}

.service-card .material-icons {
    font-size: 48px;
    color: var(--primary-color);
    display: block;
    margin-bottom: 16px;
}

.site-footer {
    background: var(--primary-dark);
    color: white;
    padding: 48px 0 24px 0;
    margin-top: 60px;
}

@media (max-width: 768px) {
    .site-header .container {
        flex-direction: column;
        gap: 16px;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
    }
}
CSS;
        
        // WooCommerce CSS
        $woocommerce_css = <<<CSS
/* WooCommerce Material Design Styling */
.woocommerce ul.products li.product {
    background: white;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.woocommerce ul.products li.product:hover {
    transform: translateY(-4px);
}

.woocommerce a.button,
.woocommerce button.button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 4px;
    padding: 12px 24px;
    font-weight: 500;
    text-transform: uppercase;
}

.woocommerce a.button:hover {
    background-color: var(--primary-dark);
}
CSS;
        
        // Theme JavaScript
        $theme_js = <<<JS
(function($) {
    'use strict';
    
    // Mobile menu toggle
    $('.menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('active');
    });
    
    // Smooth scrolling
    $('a[href*="#"]').on('click', function(e) {
        var target = $(this.hash);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 600);
        }
    });
    
})(jQuery);
JS;
        
        $this->saveFile('/assets/css/material-design.css', $material_css);
        $this->saveFile('/assets/css/woocommerce.css', $woocommerce_css);
        $this->saveFile('/assets/js/theme.js', $theme_js);
    }
    
    private function createWooCommerceFiles() {
        $woo_template = <<<'PHP'
<?php get_header(); ?>
<main class="site-main woocommerce-page">
    <div class="container">
        <?php woocommerce_content(); ?>
    </div>
</main>
<?php get_footer(); ?>
PHP;
        
        $this->saveFile('/woocommerce/archive-product.php', $woo_template);
        $this->saveFile('/woocommerce/single-product.php', $woo_template);
    }
    
    private function saveFile($path, $content) {
        $full_path = $this->theme_path . $path;
        $dir = dirname($full_path);
        
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents($full_path, $content);
        $this->log[] = 'Created: ' . $path;
    }
}

// Run the generator
?>
<!DOCTYPE html>
<html>
<head>
    <title>West Pace Theme Generator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .log { background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #007cba; }
        .button { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .success { color: #28a745; font-weight: bold; }
        h1 { color: #333; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>West Pace Material Design Theme Generator</h1>
        
        <?php if (isset($_POST['generate_theme'])): ?>
            <div class="log">
                <h3>Theme Generation Results:</h3>
                <?php
                $generator = new SimpleWestPaceGenerator();
                $log = $generator->generate();
                echo '<ul>';
                foreach ($log as $entry) {
                    echo '<li>' . htmlspecialchars($entry) . '</li>';
                }
                echo '</ul>';
                ?>
            </div>
            
            <div style="background: #d4edda; padding: 20px; border-radius: 5px; margin-top: 20px;">
                <h3 style="color: #155724; margin-top: 0;">✅ Success! Next Steps:</h3>
                <ol style="color: #155724;">
                    <li>Go to <strong>WordPress Admin > Appearance > Themes</strong></li>
                    <li>Activate the <strong>"West Pace Material Design"</strong> theme</li>
                    <li>Install <strong>WooCommerce</strong> plugin</li>
                    <li>Run the import script to migrate content</li>
                </ol>
            </div>
            
        <?php else: ?>
            <p>This script will create your West Pace Material Design theme automatically.</p>
            <form method="post">
                <button type="submit" name="generate_theme" class="button">Generate Theme Now</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
