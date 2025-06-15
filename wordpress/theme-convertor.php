<?php
/**
 * Westpace Material Theme Converter
 * 
 * This script converts the basic apparel-ecommerce-store theme into
 * the enhanced westpace-material theme with improved styling, navigation,
 * ecommerce functionality, and Material Design principles.
 * 
 * Usage: php theme-converter.php
 * Or run via web browser if placed in WordPress directory
 */

class WestpaceMaterialConverter {
    
    private $source_theme = 'apparel-ecommerce-store';
    private $target_theme = 'westpace-material';
    private $wp_content_path;
    private $themes_path;
    
    public function __construct() {
        // Detect if running in WordPress environment
        if (defined('ABSPATH')) {
            $this->wp_content_path = WP_CONTENT_DIR;
        } else {
            // Assume script is in WordPress root or adjust path accordingly
            $this->wp_content_path = __DIR__ . '/wp-content';
        }
        $this->themes_path = $this->wp_content_path . '/themes';
    }
    
    /**
     * Main conversion process
     */
    public function convert() {
        echo "🚀 Starting Westpace Material Theme Conversion...\n";
        
        // Step 1: Backup existing theme
        $this->backupTheme();
        
        // Step 2: Create enhanced theme structure
        $this->createThemeStructure();
        
        // Step 3: Generate enhanced functions.php
        $this->createEnhancedFunctions();
        
        // Step 4: Create Material Design CSS
        $this->createMaterialCSS();
        
        // Step 5: Create enhanced JavaScript
        $this->createEnhancedJavaScript();
        
        // Step 6: Create WooCommerce templates
        $this->createWooCommerceTemplates();
        
        // Step 7: Create enhanced header
        $this->createEnhancedHeader();
        
        // Step 8: Create enhanced footer
        $this->createEnhancedFooter();
        
        // Step 9: Create enhanced navigation
        $this->createEnhancedNavigation();
        
        // Step 10: Create template files
        $this->createTemplateFiles();
        
        // Step 11: Create enhanced front page
        $this->createEnhancedFrontPage();
        
        echo "✅ Westpace Material Theme Conversion Complete!\n";
        echo "📁 Theme location: {$this->themes_path}/{$this->target_theme}\n";
    }
    
    /**
     * Backup existing theme
     */
    private function backupTheme() {
        $backup_path = $this->themes_path . "/{$this->target_theme}-backup-" . date('Y-m-d-H-i-s');
        if (is_dir($this->themes_path . "/{$this->target_theme}")) {
            echo "📦 Backing up existing theme to: $backup_path\n";
            $this->copyDirectory($this->themes_path . "/{$this->target_theme}", $backup_path);
        }
    }
    
    /**
     * Create enhanced theme directory structure
     */
    private function createThemeStructure() {
        echo "📁 Creating enhanced theme structure...\n";
        
        $directories = [
            $this->target_theme,
            $this->target_theme . '/assets',
            $this->target_theme . '/assets/css',
            $this->target_theme . '/assets/js',
            $this->target_theme . '/assets/images',
            $this->target_theme . '/inc',
            $this->target_theme . '/templates',
            $this->target_theme . '/template-parts',
            $this->target_theme . '/woocommerce',
            $this->target_theme . '/patterns',
        ];
        
        foreach ($directories as $dir) {
            $full_path = $this->themes_path . '/' . $dir;
            if (!is_dir($full_path)) {
                mkdir($full_path, 0755, true);
            }
        }
    }
    
    /**
     * Create enhanced functions.php
     */
    private function createEnhancedFunctions() {
        echo "⚙️ Creating enhanced functions.php...\n";
        
        $functions_content = '<?php
if (!defined(\'ABSPATH\')) exit;

/**
 * Westpace Material Theme Functions
 * Enhanced version with Material Design and ecommerce features
 */

function westpace_setup() {
    // Theme supports
    add_theme_support(\'automatic-feed-links\');
    add_theme_support(\'post-thumbnails\');
    add_theme_support(\'title-tag\');
    add_theme_support(\'html5\', array(
        \'comment-list\', \'comment-form\', \'search-form\', \'gallery\', \'caption\'
    ));
    
    // Custom logo with enhanced options
    add_theme_support(\'custom-logo\', array(
        \'height\' => 80, \'width\' => 250, \'flex-height\' => true, \'flex-width\' => true,
    ));
    
    // Navigation menus
    register_nav_menus(array(
        \'primary\' => __(\'Primary Menu\', \'westpace-material\'),
        \'footer\'  => __(\'Footer Menu\', \'westpace-material\'),
        \'mobile\'  => __(\'Mobile Menu\', \'westpace-material\'),
        \'categories\' => __(\'Product Categories\', \'westpace-material\'),
    ));
    
    // WooCommerce support with enhanced features
    add_theme_support(\'woocommerce\');
    add_theme_support(\'wc-product-gallery-zoom\');
    add_theme_support(\'wc-product-gallery-lightbox\');
    add_theme_support(\'wc-product-gallery-slider\');
    
    // Enhanced image sizes
    add_image_size(\'hero-banner\', 1920, 1080, true);
    add_image_size(\'product-featured\', 600, 600, true);
    add_image_size(\'product-gallery\', 400, 400, true);
    add_image_size(\'blog-featured\', 800, 450, true);
}
add_action(\'after_setup_theme\', \'westpace_setup\');

function westpace_scripts() {
    $version = wp_get_theme()->get(\'Version\');
    
    // Enhanced CSS loading
    wp_enqueue_style(\'material-icons\', \'https://fonts.googleapis.com/icon?family=Material+Icons\', array(), $version);
    wp_enqueue_style(\'google-fonts\', \'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Slab:wght@300;400;500;700&display=swap\', array(), $version);
    wp_enqueue_style(\'westpace-material\', get_template_directory_uri() . \'/assets/css/material-design.css\', array(), $version);
    wp_enqueue_style(\'westpace-style\', get_stylesheet_uri(), array(\'westpace-material\'), $version);
    
    if (class_exists(\'WooCommerce\')) {
        wp_enqueue_style(\'westpace-woocommerce\', get_template_directory_uri() . \'/assets/css/woocommerce.css\', array(\'westpace-material\'), $version);
    }
    
    // Enhanced JavaScript
    wp_enqueue_script(\'westpace-theme-js\', get_template_directory_uri() . \'/assets/js/theme.js\', array(\'jquery\'), $version, true);
    
    // Localize script for enhanced AJAX functionality
    wp_localize_script(\'westpace-theme-js\', \'westpace_ajax\', array(
        \'ajax_url\' => admin_url(\'admin-ajax.php\'),
        \'nonce\' => wp_create_nonce(\'westpace_nonce\'),
        \'cart_url\' => class_exists(\'WooCommerce\') ? wc_get_cart_url() : \'\',
        \'shop_url\' => class_exists(\'WooCommerce\') ? wc_get_page_permalink(\'shop\') : \'\',
    ));
}
add_action(\'wp_enqueue_scripts\', \'westpace_scripts\');

// Enhanced widget areas
function westpace_widgets_init() {
    register_sidebar(array(
        \'name\' => __(\'Sidebar\', \'westpace-material\'),
        \'id\' => \'sidebar-1\',
        \'before_widget\' => \'<section id="%1$s" class="widget material-card elevation-2 %2$s">\',
        \'after_widget\' => \'</section>\',
        \'before_title\' => \'<h3 class="widget-title material-text-primary">\',
        \'after_title\' => \'</h3>\',
    ));
    
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            \'name\' => sprintf(__(\'Footer Widget %d\', \'westpace-material\'), $i),
            \'id\' => "footer-widget-$i",
            \'before_widget\' => \'<div id="%1$s" class="footer-widget %2$s">\',
            \'after_widget\' => \'</div>\',
            \'before_title\' => \'<h3 class="footer-widget-title">\',
            \'after_title\' => \'</h3>\',
        ));
    }
}
add_action(\'widgets_init\', \'westpace_widgets_init\');

// Enhanced WooCommerce modifications
if (class_exists(\'WooCommerce\')) {
    // Remove default WooCommerce styling
    add_filter(\'woocommerce_enqueue_styles\', \'__return_empty_array\');
    
    // Enhanced product image thumbnails
    add_filter(\'woocommerce_get_image_size_gallery_thumbnail\', function($size) {
        return array(\'width\' => 150, \'height\' => 150, \'crop\' => 1);
    });
    
    // Enhanced cart fragments for AJAX
    add_filter(\'woocommerce_add_to_cart_fragments\', \'westpace_cart_count_fragments\');
    function westpace_cart_count_fragments($fragments) {
        $fragments[\'.cart-count\'] = \'<span class="cart-count">\' . WC()->cart->get_cart_contents_count() . \'</span>\';
        return $fragments;
    }
}

// Performance optimizations
function westpace_performance_optimizations() {
    // Remove unnecessary WordPress features
    remove_action(\'wp_head\', \'wp_generator\');
    remove_action(\'wp_head\', \'wlwmanifest_link\');
    remove_action(\'wp_head\', \'rsd_link\');
    remove_action(\'wp_head\', \'wp_shortlink_wp_head\');
    
    // Remove emoji scripts
    remove_action(\'wp_head\', \'print_emoji_detection_script\', 7);
    remove_action(\'wp_print_styles\', \'print_emoji_styles\');
}
add_action(\'init\', \'westpace_performance_optimizations\');

// Security enhancements
function westpace_security_headers() {
    if (!is_admin()) {
        header(\'X-Content-Type-Options: nosniff\');
        header(\'X-Frame-Options: SAMEORIGIN\');
        header(\'X-XSS-Protection: 1; mode=block\');
    }
}
add_action(\'send_headers\', \'westpace_security_headers\');

// Custom excerpt
function westpace_excerpt_length($length) { return 25; }
add_filter(\'excerpt_length\', \'westpace_excerpt_length\');

function westpace_excerpt_more($more) { return \'...\'; }
add_filter(\'excerpt_more\', \'westpace_excerpt_more\');

// Include additional theme files
require get_template_directory() . \'/inc/customizer.php\';
require get_template_directory() . \'/inc/template-functions.php\';
';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/functions.php", $functions_content);
    }
    
    /**
     * Create Material Design CSS
     */
    private function createMaterialCSS() {
        echo "🎨 Creating Material Design CSS...\n";
        
        $css_content = ':root {
  /* Material Design Color Palette */
  --primary-color: #1565C0;
  --primary-light: #42A5F5;
  --primary-dark: #0D47A1;
  --secondary-color: #FF6F00;
  --secondary-light: #FFB74D;
  --accent-color: #00BCD4;
  --background-color: #FAFAFA;
  --surface-color: #FFFFFF;
  --error-color: #F44336;
  --warning-color: #FF9800;
  --success-color: #4CAF50;
  --info-color: #2196F3;
  
  /* Text Colors */
  --text-primary: rgba(0, 0, 0, 0.87);
  --text-secondary: rgba(0, 0, 0, 0.60);
  --text-disabled: rgba(0, 0, 0, 0.38);
  --text-hint: rgba(0, 0, 0, 0.38);
  
  /* Shadows */
  --shadow-1: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  --shadow-2: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  --shadow-3: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
  --shadow-4: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  --shadow-5: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
  
  /* Transitions */
  --transition-fast: 0.15s cubic-bezier(0.4, 0, 0.2, 1);
  --transition-normal: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  --transition-slow: 0.45s cubic-bezier(0.4, 0, 0.2, 1);
  
  /* Spacing */
  --spacing-xs: 4px;
  --spacing-sm: 8px;
  --spacing-md: 16px;
  --spacing-lg: 24px;
  --spacing-xl: 32px;
  --spacing-xxl: 48px;
  
  /* Border Radius */
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 16px;
  --radius-xl: 24px;
  --radius-pill: 50px;
}

* {
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
  -webkit-text-size-adjust: 100%;
}

body {
  font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  margin: 0;
  padding: 0;
  background-color: var(--background-color);
  color: var(--text-primary);
  line-height: 1.6;
  overflow-x: hidden;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
  font-family: "Roboto Slab", serif;
  font-weight: 500;
  line-height: 1.2;
  margin: 0 0 var(--spacing-md) 0;
  color: var(--text-primary);
}

h1 { font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 700; }
h2 { font-size: clamp(2rem, 4vw, 2.5rem); font-weight: 600; }
h3 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 500; }
h4 { font-size: clamp(1.25rem, 2.5vw, 1.5rem); }
h5 { font-size: clamp(1.125rem, 2vw, 1.25rem); }
h6 { font-size: 1rem; }

/* Material Design Components */
.material-card {
  background: var(--surface-color);
  border-radius: var(--radius-md);
  padding: var(--spacing-lg);
  transition: all var(--transition-normal);
}

.elevation-0 { box-shadow: none; }
.elevation-1 { box-shadow: var(--shadow-1); }
.elevation-2 { box-shadow: var(--shadow-2); }
.elevation-3 { box-shadow: var(--shadow-3); }
.elevation-4 { box-shadow: var(--shadow-4); }
.elevation-5 { box-shadow: var(--shadow-5); }

.material-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: var(--spacing-md) var(--spacing-xl);
  border: none;
  border-radius: var(--radius-md);
  font-family: inherit;
  font-size: 0.875rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-decoration: none;
  cursor: pointer;
  transition: all var(--transition-normal);
  position: relative;
  overflow: hidden;
  min-width: 120px;
}

.material-button:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: currentColor;
  opacity: 0;
  transition: opacity var(--transition-fast);
}

.material-button:hover:before {
  opacity: 0.08;
}

.material-button:active:before {
  opacity: 0.16;
}

.material-button.primary {
  background: var(--primary-color);
  color: white;
  box-shadow: var(--shadow-2);
}

.material-button.primary:hover {
  background: var(--primary-dark);
  box-shadow: var(--shadow-3);
  transform: translateY(-1px);
}

.material-button.secondary {
  background: var(--secondary-color);
  color: white;
  box-shadow: var(--shadow-2);
}

.material-button.outline {
  background: transparent;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
  box-shadow: none;
}

.material-button.outline:hover {
  background: var(--primary-color);
  color: white;
}

/* Enhanced Header */
.site-header {
  background: var(--surface-color);
  box-shadow: var(--shadow-2);
  position: sticky;
  top: 0;
  z-index: 1000;
  transition: all var(--transition-normal);
}

.header-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-lg);
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 80px;
}

.site-logo {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: var(--primary-color);
  font-weight: 700;
  font-size: 1.5rem;
}

.site-logo img {
  max-height: 60px;
  width: auto;
}

/* Enhanced Navigation */
.main-navigation {
  display: flex;
  align-items: center;
  gap: var(--spacing-lg);
}

.main-navigation ul {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: var(--spacing-lg);
}

.main-navigation a {
  color: var(--text-primary);
  text-decoration: none;
  font-weight: 500;
  padding: var(--spacing-sm) var(--spacing-md);
  border-radius: var(--radius-sm);
  transition: all var(--transition-fast);
  position: relative;
}

.main-navigation a:hover,
.main-navigation a:focus {
  color: var(--primary-color);
  background: rgba(21, 101, 192, 0.08);
}

/* Mobile Navigation */
.mobile-menu-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 1.5rem;
  color: var(--text-primary);
  cursor: pointer;
  padding: var(--spacing-sm);
}

@media (max-width: 768px) {
  .mobile-menu-toggle {
    display: block;
  }
  
  .main-navigation {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--surface-color);
    box-shadow: var(--shadow-3);
    padding: var(--spacing-lg);
    transform: translateY(-100%);
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-normal);
  }
  
  .main-navigation.active {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
  }
  
  .main-navigation ul {
    flex-direction: column;
    gap: var(--spacing-sm);
  }
}

/* Enhanced Footer */
.site-footer {
  background: var(--primary-dark);
  color: white;
  padding: var(--spacing-xxl) 0 var(--spacing-lg);
  margin-top: auto;
}

.footer-widgets {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-lg);
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: var(--spacing-xl);
  margin-bottom: var(--spacing-xl);
}

.footer-widget h3 {
  color: white;
  margin-bottom: var(--spacing-md);
}

.footer-widget ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-widget li {
  margin-bottom: var(--spacing-sm);
}

.footer-widget a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  transition: color var(--transition-fast);
}

.footer-widget a:hover {
  color: white;
}

/* Utility Classes */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--spacing-lg);
}

.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.mb-0 { margin-bottom: 0; }
.mb-sm { margin-bottom: var(--spacing-sm); }
.mb-md { margin-bottom: var(--spacing-md); }
.mb-lg { margin-bottom: var(--spacing-lg); }
.mb-xl { margin-bottom: var(--spacing-xl); }

.mt-0 { margin-top: 0; }
.mt-sm { margin-top: var(--spacing-sm); }
.mt-md { margin-top: var(--spacing-md); }
.mt-lg { margin-top: var(--spacing-lg); }
.mt-xl { margin-top: var(--spacing-xl); }

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in-up {
  animation: fadeInUp 0.6s ease-out forwards;
}

/* Print Styles */
@media print {
  .site-header,
  .site-footer,
  .mobile-menu-toggle {
    display: none;
  }
  
  body {
    font-size: 12pt;
    line-height: 1.4;
  }
  
  h1, h2, h3 {
    page-break-after: avoid;
  }
}';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/assets/css/material-design.css", $css_content);
    }
    
    /**
     * Create enhanced JavaScript
     */
    private function createEnhancedJavaScript() {
        echo "⚡ Creating enhanced JavaScript...\n";
        
        $js_content = '/**
 * Westpace Material Theme JavaScript
 * Enhanced functionality with Material Design interactions
 */

(function($) {
    "use strict";
    
    // Document ready
    $(document).ready(function() {
        initMaterialDesign();
        initNavigation();
        initWooCommerce();
        initAnimations();
        initPerformance();
    });
    
    /**
     * Initialize Material Design components
     */
    function initMaterialDesign() {
        // Material ripple effect
        $(".material-button, .woocommerce .button").on("click", function(e) {
            const button = $(this);
            const ripple = $("<span class=\"ripple\"></span>");
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.css({
                width: size,
                height: size,
                left: x,
                top: y
            });
            
            button.append(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
        
        // Material elevation on hover
        $(".material-card").hover(
            function() {
                $(this).addClass("elevation-4");
            },
            function() {
                $(this).removeClass("elevation-4");
            }
        );
    }
    
    /**
     * Initialize enhanced navigation
     */
    function initNavigation() {
        // Mobile menu toggle
        $(".mobile-menu-toggle").on("click", function() {
            $(this).toggleClass("active");
            $(".main-navigation").toggleClass("active");
        });
        
        // Smooth scrolling for anchor links
        $("a[href^=\"#\"]").on("click", function(e) {
            const target = $(this.getAttribute("href"));
            if (target.length) {
                e.preventDefault();
                $("html, body").animate({
                    scrollTop: target.offset().top - 100
                }, 600, "easeInOutQuart");
            }
        });
        
        // Header scroll effect
        let lastScrollTop = 0;
        $(window).on("scroll", function() {
            const scrollTop = $(this).scrollTop();
            const header = $(".site-header");
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                header.addClass("header-hidden");
            } else {
                header.removeClass("header-hidden");
            }
            
            if (scrollTop > 50) {
                header.addClass("header-scrolled");
            } else {
                header.removeClass("header-scrolled");
            }
            
            lastScrollTop = scrollTop;
        });
    }
    
    /**
     * Initialize WooCommerce enhancements
     */
    function initWooCommerce() {
        if (typeof wc_add_to_cart_params === "undefined") return;
        
        // Enhanced add to cart with loading states
        $(document).on("click", ".ajax_add_to_cart", function(e) {
            const button = $(this);
            button.addClass("loading");
            button.find(".material-icons").text("hourglass_empty");
        });
        
        // Update cart count after AJAX
        $(document.body).on("added_to_cart", function(event, fragments, cart_hash, button) {
            button.removeClass("loading");
            button.find(".material-icons").text("check");
            
            // Show success notification
            showNotification("Product added to cart!", "success");
            
            setTimeout(() => {
                button.find(".material-icons").text("shopping_cart");
            }, 2000);
        });
        
        // Enhanced product gallery
        if ($(".woocommerce-product-gallery").length) {
            $(".woocommerce-product-gallery").addClass("material-gallery");
        }
        
        // Quantity input enhancements
        $(".quantity input[type=number]").wrap("<div class=\"quantity-wrapper material-input\"></div>");
        
        // Enhanced select dropdowns
        $("select").each(function() {
            if (!$(this).hasClass("select2-hidden-accessible")) {
                $(this).wrap("<div class=\"select-wrapper\"></div>");
            }
        });
    }
    
    /**
     * Initialize scroll animations
     */
    function initAnimations() {
        // Intersection Observer for animations
        if ("IntersectionObserver" in window) {
            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("animate-in");
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            });
            
            // Observe elements with animation classes
            document.querySelectorAll(".fade-in-up, .slide-in-left, .slide-in-right").forEach(el => {
                animationObserver.observe(el);
            });
        }
        
        // Parallax effect for hero sections
        $(".hero-section").each(function() {
            const hero = $(this);
            $(window).on("scroll", function() {
                const scrolled = $(window).scrollTop();
                const parallax = scrolled * 0.5;
                hero.css("transform", `translateY(${parallax}px)`);
            });
        });
    }
    
    /**
     * Performance optimizations
     */
    function initPerformance() {
        // Lazy load images
        if ("IntersectionObserver" in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove("lazy");
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll("img[data-src]").forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Preload critical resources
        const preloadLink = document.createElement("link");
        preloadLink.rel = "preload";
        preloadLink.as = "font";
        preloadLink.type = "font/woff2";
        preloadLink.crossOrigin = "anonymous";
        preloadLink.href = "https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2";
        document.head.appendChild(preloadLink);
    }
    
    /**
     * Show notification
     */
    function showNotification(message, type = "info") {
        const notification = $(`
            <div class="material-notification ${type}">
                <span class="material-icons">${getNotificationIcon(type)}</span>
                <span class="message">${message}</span>
                <button class="close-notification material-icons">close</button>
            </div>
        `);
        
        $("body").append(notification);
        
        setTimeout(() => {
            notification.addClass("show");
        }, 100);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
        
        // Close button
        notification.find(".close-notification").on("click", () => {
            hideNotification(notification);
        });
    }
    
    function hideNotification(notification) {
        notification.removeClass("show");
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
    
    function getNotificationIcon(type) {
        const icons = {
            success: "check_circle",
            error: "error",
            warning: "warning",
            info: "info"
        };
        return icons[type] || icons.info;
    }
    
})(jQuery);

// Add CSS for additional components
const additionalCSS = `
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-effect 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-effect {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

.header-hidden {
    transform: translateY(-100%);
}

.header-scrolled {
    box-shadow: var(--shadow-3);
}

.material-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--surface-color);
    padding: 16px 20px;
    border-radius: 8px;
    box-shadow: var(--shadow-3);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 10000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.material-notification.show {
    transform: translateX(0);
}

.material-notification.success {
    border-left: 4px solid var(--success-color);
}

.material-notification.error {
    border-left: 4px solid var(--error-color);
}

.material-notification.warning {
    border-left: 4px solid var(--warning-color);
}

.material-notification.info {
    border-left: 4px solid var(--info-color);
}

.close-notification {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary);
}

.animate-in {
    animation: fadeInUp 0.6s ease-out forwards;
}
`;

// Inject additional CSS
const style = document.createElement("style");
style.textContent = additionalCSS;
document.head.appendChild(style);';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/assets/js/theme.js", $js_content);
    }
    
    /**
     * Create WooCommerce templates
     */
    private function createWooCommerceTemplates() {
        echo "🛒 Creating enhanced WooCommerce templates...\n";
        
        // Enhanced WooCommerce CSS
        $woocommerce_css = '/**
 * Enhanced WooCommerce Styles for Westpace Material Theme
 */

/* Product Grid */
.woocommerce ul.products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-xl);
    margin: 0;
    padding: 0;
}

.woocommerce ul.products li.product {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-2);
    transition: all var(--transition-normal);
    list-style: none;
    display: flex;
    flex-direction: column;
}

.woocommerce ul.products li.product:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-4);
}

.woocommerce ul.products li.product img {
    border-radius: var(--radius-md);
    margin-bottom: var(--spacing-md);
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.woocommerce ul.products li.product .woocommerce-loop-product__title {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: var(--spacing-sm);
    color: var(--text-primary);
}

.woocommerce ul.products li.product .price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--secondary-color);
    margin-bottom: var(--spacing-md);
}

.woocommerce ul.products li.product .button {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: var(--spacing-md) var(--spacing-lg);
    border-radius: var(--radius-md);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all var(--transition-normal);
    margin-top: auto;
    cursor: pointer;
}

.woocommerce ul.products li.product .button:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-3);
}

/* Single Product */
.woocommerce div.product {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xxl);
    box-shadow: var(--shadow-2);
    margin-bottom: var(--spacing-xl);
}

.woocommerce div.product .images {
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-2);
}

.woocommerce div.product .summary .product_title {
    color: var(--primary-color);
    font-size: 2.5rem;
    margin-bottom: var(--spacing-lg);
}

.woocommerce div.product .summary .price {
    font-size: 2rem;
    color: var(--secondary-color);
    margin-bottom: var(--spacing-lg);
}

.woocommerce div.product .summary .woocommerce-product-details__short-description {
    font-size: 1.125rem;
    line-height: 1.6;
    color: var(--text-secondary);
    margin-bottom: var(--spacing-xl);
}

/* Cart */
.woocommerce-cart table.cart {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-2);
    overflow: hidden;
    border-collapse: separate;
    border-spacing: 0;
}

.woocommerce-cart table.cart th,
.woocommerce-cart table.cart td {
    padding: var(--spacing-lg);
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.woocommerce-cart table.cart thead th {
    background: var(--primary-color);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.woocommerce .cart-collaterals {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    box-shadow: var(--shadow-2);
    margin-top: var(--spacing-xl);
}

.woocommerce .cart_totals h2 {
    color: var(--primary-color);
    margin-bottom: var(--spacing-lg);
}

/* Checkout */
.woocommerce-checkout .woocommerce-checkout-review-order {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    box-shadow: var(--shadow-2);
}

.woocommerce form .form-row {
    margin-bottom: var(--spacing-lg);
}

.woocommerce form .form-row label {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: var(--spacing-sm);
    display: block;
}

.woocommerce form .form-row input,
.woocommerce form .form-row select,
.woocommerce form .form-row textarea {
    width: 100%;
    padding: var(--spacing-md);
    border: 2px solid #e0e0e0;
    border-radius: var(--radius-md);
    font-family: inherit;
    font-size: 1rem;
    transition: border-color var(--transition-fast);
}

.woocommerce form .form-row input:focus,
.woocommerce form .form-row select:focus,
.woocommerce form .form-row textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
}

/* Buttons */
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce #respond input#submit {
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    padding: var(--spacing-md) var(--spacing-xl);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all var(--transition-normal);
    box-shadow: var(--shadow-2);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
    cursor: pointer;
}

.woocommerce a.button:hover,
.woocommerce button.button:hover,
.woocommerce input.button:hover,
.woocommerce #respond input#submit:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-3);
    color: white;
}

.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt {
    background: var(--secondary-color);
}

.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover {
    background: #e65100;
}

/* Product Categories */
.woocommerce .woocommerce-result-count {
    color: var(--text-secondary);
    margin-bottom: var(--spacing-lg);
}

.woocommerce .woocommerce-ordering {
    margin-bottom: var(--spacing-lg);
}

.woocommerce .woocommerce-ordering select {
    padding: var(--spacing-md);
    border: 2px solid #e0e0e0;
    border-radius: var(--radius-md);
    background: white;
}

/* Breadcrumbs */
.woocommerce .woocommerce-breadcrumb {
    background: var(--surface-color);
    padding: var(--spacing-lg);
    border-radius: var(--radius-md);
    margin-bottom: var(--spacing-lg);
    box-shadow: var(--shadow-1);
}

.woocommerce .woocommerce-breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
}

.woocommerce .woocommerce-breadcrumb a:hover {
    text-decoration: underline;
}

/* Messages */
.woocommerce-message,
.woocommerce-error,
.woocommerce-info {
    background: var(--surface-color);
    border-radius: var(--radius-md);
    padding: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
    box-shadow: var(--shadow-2);
    border-left: 4px solid;
}

.woocommerce-message {
    border-left-color: var(--success-color);
}

.woocommerce-error {
    border-left-color: var(--error-color);
}

.woocommerce-info {
    border-left-color: var(--info-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .woocommerce ul.products {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--spacing-lg);
    }
    
    .woocommerce div.product {
        padding: var(--spacing-lg);
    }
    
    .woocommerce div.product .summary .product_title {
        font-size: 2rem;
    }
    
    .woocommerce div.product .summary .price {
        font-size: 1.5rem;
    }
}';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/assets/css/woocommerce.css", $woocommerce_css);
        
        // Create WooCommerce template files
        $woocommerce_templates = [
            'archive-product.php' => '<?php get_header(); ?>
<main class="site-main woocommerce-page">
    <div class="container">
        <div class="woocommerce-breadcrumb-wrapper">
            <?php woocommerce_breadcrumb(); ?>
        </div>
        <?php woocommerce_content(); ?>
    </div>
</main>
<?php get_footer(); ?>',
            
            'single-product.php' => '<?php get_header(); ?>
<main class="site-main woocommerce-page single-product-page">
    <div class="container">
        <div class="woocommerce-breadcrumb-wrapper">
            <?php woocommerce_breadcrumb(); ?>
        </div>
        <?php woocommerce_content(); ?>
    </div>
</main>
<?php get_footer(); ?>',
            
            'cart.php' => '<?php get_header(); ?>
<main class="site-main woocommerce-page cart-page">
    <div class="container">
        <h1 class="page-title"><?php esc_html_e("Shopping Cart", "westpace-material"); ?></h1>
        <?php woocommerce_content(); ?>
    </div>
</main>
<?php get_footer(); ?>',
            
            'checkout.php' => '<?php get_header(); ?>
<main class="site-main woocommerce-page checkout-page">
    <div class="container">
        <h1 class="page-title"><?php esc_html_e("Checkout", "westpace-material"); ?></h1>
        <?php woocommerce_content(); ?>
    </div>
</main>
<?php get_footer(); ?>'
        ];
        
        foreach ($woocommerce_templates as $filename => $content) {
            file_put_contents($this->themes_path . "/{$this->target_theme}/woocommerce/$filename", $content);
        }
    }
    
    /**
     * Create enhanced header
     */
    private function createEnhancedHeader() {
        echo "🔝 Creating enhanced header...\n";
        
        $header_content = '<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url("/")); ?>" rel="home">
                            <?php bloginfo("name"); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    "theme_location" => "primary",
                    "menu_id" => "primary-menu",
                    "container" => false,
                    "fallback_cb" => false,
                ));
                ?>
                
                <?php if (class_exists("WooCommerce")) : ?>
                <div class="header-cart">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-link material-button outline">
                        <span class="material-icons">shopping_cart</span>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                </div>
                <?php endif; ?>
            </nav>

            <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </header>

    <div id="content" class="site-content">';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/header.php", $header_content);
    }
    
    /**
     * Create enhanced footer
     */
    private function createEnhancedFooter() {
        echo "🔻 Creating enhanced footer...\n";
        
        $footer_content = '    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets-grid">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <?php if (is_active_sidebar("footer-widget-$i")) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar("footer-widget-$i"); ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="footer-info">
                        <p>&copy; <?php echo date("Y"); ?> <?php bloginfo("name"); ?>. <?php esc_html_e("All rights reserved.", "westpace-material"); ?></p>
                        <p><?php esc_html_e("Premium Garment Manufacturing Since 1998", "westpace-material"); ?></p>
                    </div>
                    
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <span class="material-icons">facebook</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <span class="material-icons">twitter</span>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <span class="material-icons">instagram</span>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <span class="material-icons">linkedin</span>
                        </a>
                    </div>
                    
                    <?php
                    wp_nav_menu(array(
                        "theme_location" => "footer",
                        "menu_id" => "footer-menu",
                        "container" => "nav",
                        "container_class" => "footer-navigation",
                        "fallback_cb" => false,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/footer.php", $footer_content);
    }
    
    /**
     * Create enhanced navigation
     */
    private function createEnhancedNavigation() {
        echo "🧭 Creating enhanced navigation...\n";
        
        // Create navigation walker for enhanced menu functionality
        $walker_content = '<?php
/**
 * Custom Navigation Walker for Material Design
 */
class Westpace_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu material-submenu elevation-2\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $args = (object) $args;
        $indent = ($depth) ? str_repeat("\t", $depth) : "";
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = "menu-item-" . $item->ID;
        
        $class_names = join(" ", apply_filters("nav_menu_css_class", array_filter($classes), $item, $args));
        $class_names = $class_names ? " class=\"" . esc_attr($class_names) . "\"" : "";
        
        $id = apply_filters("nav_menu_item_id", "menu-item-" . $item->ID, $item, $args);
        $id = $id ? " id=\"" . esc_attr($id) . "\"" : "";
        
        $output .= $indent . "<li$id$class_names>";
        
        $attributes = !empty($item->attr_title) ? " title=\"" . esc_attr($item->attr_title) . "\"" : "";
        $attributes .= !empty($item->target) ? " target=\"" . esc_attr($item->target) . "\"" : "";
        $attributes .= !empty($item->xfn) ? " rel=\"" . esc_attr($item->xfn) . "\"" : "";
        $attributes .= !empty($item->url) ? " href=\"" . esc_attr($item->url) . "\"" : "";
        
        $item_output = isset($args->before) ? $args->before : "";
        $item_output .= "<a$attributes class=\"nav-link\">";
        $item_output .= (isset($args->link_before) ? $args->link_before : "") . apply_filters("the_title", $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : "");
        
        // Add dropdown arrow for parent items
        if (in_array("menu-item-has-children", $classes)) {
            $item_output .= " <span class=\"material-icons dropdown-arrow\">keyboard_arrow_down</span>";
        }
        
        $item_output .= "</a>";
        $item_output .= isset($args->after) ? $args->after : "";
        
        $output .= apply_filters("walker_nav_menu_start_el", $item_output, $item, $depth, $args);
    }
    
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/inc/class-walker-nav-menu.php", $walker_content);
    }
    
    /**
     * Create template files
     */
    private function createTemplateFiles() {
        echo "📄 Creating template files...\n";
        
        $templates = [
            'index.php' => '<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article <?php post_class("post-card material-card elevation-2"); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail("blog-featured"); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="post-author"><?php the_author(); ?></span>
                            </div>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more material-button primary">
                                <?php esc_html_e("Read More", "westpace-material"); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e("No posts found.", "westpace-material"); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>',
            
            'page.php' => '<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class("page-content material-card elevation-2"); ?>>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="page-content-inner">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>',
            
            'single.php' => '<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class("single-post material-card elevation-2"); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail("blog-featured"); ?>
                    </div>
                <?php endif; ?>
                
                <header class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <span class="post-author"><?php the_author(); ?></span>
                        <span class="post-categories"><?php the_category(", "); ?></span>
                    </div>
                </header>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="post-footer">
                    <?php the_tags("<div class=\"post-tags\">", "", "</div>"); ?>
                </footer>
            </article>
            
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>'
        ];
        
        foreach ($templates as $filename => $content) {
            file_put_contents($this->themes_path . "/{$this->target_theme}/$filename", $content);
        }
    }
    
    /**
     * Create enhanced front page
     */
    private function createEnhancedFrontPage() {
        echo "🏠 Creating enhanced front page...\n";
        
        $frontpage_content = '<?php get_header(); ?>

<main class="site-main front-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content fade-in-up">
                <h1 class="hero-title">West Pace Apparels</h1>
                <h2 class="hero-subtitle">Premium Garment Manufacturing Since 1998</h2>
                <p class="hero-description">
                    Family-owned Fijian company specializing in school wear, workwear, and winterwear 
                    for Australian and South Pacific markets. Over 24 years of excellence in quality manufacturing.
                </p>
                <div class="hero-actions">
                    <?php if (class_exists("WooCommerce")) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>" class="material-button primary">
                        <span class="material-icons">shopping_bag</span>
                        <?php esc_html_e("View Products", "westpace-material"); ?>
                    </a>
                    <?php endif; ?>
                    <a href="/contact/" class="material-button outline">
                        <span class="material-icons">message</span>
                        <?php esc_html_e("Get Quote", "westpace-material"); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <h2 class="section-title text-center"><?php esc_html_e("What Makes Us Different", "westpace-material"); ?></h2>
            <div class="services-grid">
                <div class="service-card material-card elevation-2 fade-in-up">
                    <span class="material-icons service-icon">speed</span>
                    <h3><?php esc_html_e("Flexible Short Runs", "westpace-material"); ?></h3>
                    <p><?php esc_html_e("We accommodate both small and large quantity orders with quick turnaround times, ensuring your deadlines are always met.", "westpace-material"); ?></p>
                </div>
                <div class="service-card material-card elevation-2 fade-in-up">
                    <span class="material-icons service-icon">verified_user</span>
                    <h3><?php esc_html_e("Quality Assurance", "westpace-material"); ?></h3>
                    <p><?php esc_html_e("Comprehensive quality control systems and rigorous testing ensure reliable, consistent products that meet international standards.", "westpace-material"); ?></p>
                </div>
                <div class="service-card material-card elevation-2 fade-in-up">
                    <span class="material-icons service-icon">local_shipping</span>
                    <h3><?php esc_html_e("Fast Delivery", "westpace-material"); ?></h3>
                    <p><?php esc_html_e("Prompt service with efficient shipping to Australia, New Zealand, and South Pacific regions.", "westpace-material"); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <?php if (class_exists("WooCommerce")) : ?>
    <!-- Featured Products Section -->
    <section class="featured-products-section">
        <div class="container">
            <h2 class="section-title text-center"><?php esc_html_e("Featured Products", "westpace-material"); ?></h2>
            <?php
            echo do_shortcode("[products limit=\"8\" columns=\"4\" orderby=\"popularity\" class=\"featured-products\"]");
            ?>
            <div class="text-center mt-xl">
                <a href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>" class="material-button primary">
                    <?php esc_html_e("View All Products", "westpace-material"); ?>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2><?php esc_html_e("About West Pace Apparels", "westpace-material"); ?></h2>
                    <p><?php esc_html_e("Established in 1998, West Pace Apparels has been a trusted partner in garment manufacturing for over two decades. Our family-owned business combines traditional craftsmanship with modern technology to deliver exceptional quality products.", "westpace-material"); ?></p>
                    <p><?php esc_html_e("We specialize in school uniforms, corporate workwear, and winter apparel, serving clients across Australia, New Zealand, and the South Pacific region.", "westpace-material"); ?></p>
                    <a href="/about/" class="material-button outline">
                        <?php esc_html_e("Learn More", "westpace-material"); ?>
                    </a>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-image.jpg" alt="<?php esc_attr_e("West Pace Apparels Factory", "westpace-material"); ?>" class="material-card elevation-2">
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/front-page.php", $frontpage_content);
    }
    
    /**
     * Create style.css with theme information
     */
    private function createStyleCSS() {
        echo "💄 Creating main style.css...\n";
        
        $style_content = '/*
Theme Name: Westpace Material Design Enhanced
Description: Enhanced Material Design WordPress theme for West Pace Apparels with advanced WooCommerce integration, converted from apparel-ecommerce-store theme
Version: 2.1.0
Author: West Pace Development Team
Text Domain: westpace-material
Tags: material-design, ecommerce, woocommerce, business, manufacturing, modern, responsive, accessibility-ready
Requires at least: 5.9
Tested up to: 6.4
Requires PHP: 7.4
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enhanced version with Material Design principles, improved navigation,
advanced WooCommerce features, and optimized performance.
*/

/* Import Material Design CSS */
@import url("assets/css/material-design.css");

/* Theme-specific overrides and enhancements */
.site {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.site-content {
    flex: 1;
}

/* Enhanced Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 50%, var(--accent-color) 100%);
    color: white;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("assets/images/hero-bg.jpg") center/cover;
    opacity: 0.1;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.hero-title {
    font-size: clamp(3rem, 8vw, 5rem);
    font-weight: 900;
    margin-bottom: var(--spacing-md);
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 300;
    margin-bottom: var(--spacing-lg);
    opacity: 0.9;
}

.hero-description {
    font-size: 1.25rem;
    line-height: 1.6;
    margin-bottom: var(--spacing-xl);
    opacity: 0.8;
}

.hero-actions {
    display: flex;
    gap: var(--spacing-lg);
    justify-content: center;
    flex-wrap: wrap;
}

/* Enhanced Services Section */
.services-section {
    padding: var(--spacing-xxl) 0;
    background: white;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--spacing-xl);
    margin-top: var(--spacing-xl);
}

.service-card {
    text-align: center;
    padding: var(--spacing-xl);
    transition: transform var(--transition-normal);
}

.service-card:hover {
    transform: translateY(-8px);
}

.service-icon {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: var(--spacing-lg);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
        gap: var(--spacing-lg);
    }
    
    .header-container {
        padding: 0 var(--spacing-md);
    }
}

@media (max-width: 480px) {
    .hero-section {
        min-height: 80vh;
        padding: var(--spacing-xl) 0;
    }
    
    .material-button {
        width: 100%;
        max-width: 280px;
    }
}';
        
        file_put_contents($this->themes_path . "/{$this->target_theme}/style.css", $style_content);
    }
    
    /**
     * Utility method to copy directory
     */
    private function copyDirectory($source, $destination) {
        if (!is_dir($source)) return false;
        
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                mkdir($destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName(), 0755, true);
            } else {
                copy($item, $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
        
        return true;
    }
}

// Check if running via CLI or web
if (php_sapi_name() === "cli") {
    // Command line execution
    $converter = new WestpaceMaterialConverter();
    $converter->convert();
} elseif (isset($_GET["convert"]) && $_GET["convert"] === "1") {
    // Web execution with security check
    if (!current_user_can("manage_options")) {
        wp_die("Unauthorized access");
    }
    
    echo "<pre>";
    $converter = new WestpaceMaterialConverter();
    $converter->convert();
    echo "</pre>";
} else {
    // Show conversion interface
    if (!current_user_can("manage_options")) {
        wp_die("Unauthorized access");
    }
    
    echo "
    <div style=\"padding: 20px; font-family: Arial, sans-serif;\">
        <h1>🚀 Westpace Material Theme Converter</h1>
        <p>This tool will convert your apparel-ecommerce-store theme into an enhanced westpace-material theme with Material Design principles and advanced ecommerce features.</p>
        
        <h2>✨ What will be enhanced:</h2>
        <ul>
            <li>Material Design styling and components</li>
            <li>Enhanced navigation with mobile support</li>
            <li>Advanced WooCommerce integration</li>
            <li>Improved product pages and cart functionality</li>
            <li>Responsive design optimizations</li>
            <li>Performance and security enhancements</li>
            <li>Enhanced footer with widget areas</li>
            <li>Modern JavaScript interactions</li>
        </ul>
        
        <p><strong>⚠️ Important:</strong> This will backup your existing theme before conversion.</p>
        
        <p>
            <a href=\"?convert=1\" style=\"background: #0073aa; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;\">
                🔄 Start Conversion
            </a>
        </p>
    </div>";
}
?>
