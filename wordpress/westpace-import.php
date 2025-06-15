i<?php
/**
 * Simple West Pace Content Import Script
 * Fixed version with proper WordPress function usage
 */

// WordPress bootstrap
if (!defined('ABSPATH')) {
    require_once('./wp-config.php');
}

// Load admin functions
require_once(ABSPATH . 'wp-admin/includes/admin.php');

// Security check
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    if (!is_user_logged_in()) {
        wp_redirect(wp_login_url($_SERVER['REQUEST_URI']));
        exit;
    } else {
        wp_die('Access denied. Administrator privileges required.');
    }
}

class SimpleWestPaceImporter {
    private $log = array();
    
    public function import() {
        $this->log('Starting West Pace content import...');
        
        try {
            $this->create_homepage();
            $this->create_about_page();
            $this->create_services_page();
            $this->create_contact_page();
            $this->create_testimonials();
            $this->setup_basic_menu();
            $this->configure_site_settings();
            
            $this->log('Import completed successfully!');
        } catch (Exception $e) {
            $this->log('Error: ' . $e->getMessage());
        }
        
        return $this->log;
    }
    
    private function create_homepage() {
        $content = '<!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="has-text-align-center">Welcome to West Pace Apparels</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Family-owned Fijian Company with over 24 years of experience specializing in school wear, workwear, winterwear for the Australian market. We also supply our South Pacific neighbours and the domestic market with vibrant colours and striking island wear.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="has-text-align-center">What We Offer</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>Flexible Short Runs</li>
<li>Quality Control and Assurance Systems</li>
<li>Fast Delivery</li>
<li>Prompt Service</li>
<li>Full Garment Supply and CMT</li>
<li>Reliable Quality</li>
</ul>
<!-- /wp:list -->';

        $homepage_id = $this->create_or_update_page('Home', $content);
        
        // Set as front page
        update_option('show_on_front', 'page');
        update_option('page_on_front', $homepage_id);
        
        $this->log('Homepage created and set as front page');
        return $homepage_id;
    }
    
    private function create_about_page() {
        $content = '<!-- wp:heading {"level":2} -->
<h2>Who We Are</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>West Pace was established in 1998 initially in partnership with Mr. Ranjit Solanki of Ranjit Garments(Mfg.) Limited. Now it\'s solely owned by a husband and wife team, it has served the Australian market for over 20 years.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Boasting a fluid manufacturing facility and well-engineered processing systems, Westpace has grown to currently employ over 100 staff.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Our Experience</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>24+ years in garment manufacturing</li>
<li>100+ skilled staff members</li>
<li>20+ years serving Australian market</li>
<li>500+ product lines available</li>
</ul>
<!-- /wp:list -->';

        $about_id = $this->create_or_update_page('About Us', $content);
        $this->log('About Us page created');
        return $about_id;
    }
    
    private function create_services_page() {
        $content = '<!-- wp:heading {"level":2} -->
<h2>Our Manufacturing Services</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We have the capacity to produce both small and large quantities of production line orders clothing. This includes anything from a basic pair of trousers to modern takes on vests and shirts.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>School Wear</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Comprehensive range of school uniforms and educational institution apparel.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Work Wear</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Durable and professional workwear for various industries.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Winter Wear</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Quality winter clothing designed for Australian market conditions.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Island Wear</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Vibrant and striking island wear for South Pacific markets.</p>
<!-- /wp:paragraph -->';

        $services_id = $this->create_or_update_page('Services', $content);
        $this->log('Services page created');
        return $services_id;
    }
    
    private function create_contact_page() {
        $content = '<!-- wp:heading {"level":2} -->
<h2>Get in Touch</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ready to discuss your garment manufacturing needs? Contact West Pace Apparels today for a consultation.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Request a Quote</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>For bulk orders and custom manufacturing requirements, please provide details about your project requirements including quantities, specifications, and delivery timelines.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>Contact Information</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>West Pace Apparels Ltd</strong><br>
Family-owned garment manufacturing company<br>
Specializing in school wear, workwear, and winterwear</p>
<!-- /wp:paragraph -->';

        $contact_id = $this->create_or_update_page('Contact', $content);
        $this->log('Contact page created');
        return $contact_id;
    }
    
    private function create_testimonials() {
        $testimonials = array(
            array(
                'title' => 'Testimonial from Ranjit Garments',
                'content' => '<!-- wp:quote -->
<blockquote class="wp-block-quote">
<p>Ranjit Garments Mfg Pte Ltd has a very mutually positive business relationship with Westpace Apparels for more than 20 years. We have relied on Westpace Apparels to supply us a number of types of products over these years. We have always found them to be a reliable supplier who delivers on time and within the right quality.</p>
<cite>— Ranjit Garments Mfg Pte Ltd</cite>
</blockquote>
<!-- /wp:quote -->'
            ),
            array(
                'title' => 'Testimonial from Bob Stewart',
                'content' => '<!-- wp:quote -->
<blockquote class="wp-block-quote">
<p>Bob Stewart have enjoyed a great working relationship with Westpace Apparels for over 15 years. The team at Westpace Apparel are always precise & reliable and a pleasure to work with. They are our preferred supplier of our speciality schoolwear tracksuit garments and we are very happy with the quality of their supply.</p>
<cite>— Bob Stewart</cite>
</blockquote>
<!-- /wp:quote -->'
            )
        );
        
        // Create testimonials category
        $category_id = $this->get_or_create_category('Testimonials');
        
        foreach ($testimonials as $testimonial) {
            $post_id = wp_insert_post(array(
                'post_title' => $testimonial['title'],
                'post_content' => $testimonial['content'],
                'post_status' => 'publish',
                'post_type' => 'post',
                'post_category' => array($category_id)
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                $this->log('Created testimonial: ' . $testimonial['title']);
            }
        }
    }
    
    private function setup_basic_menu() {
        // Create primary menu
        $menu_name = 'Primary Menu';
        $menu_id = wp_create_nav_menu($menu_name);
        
        if (is_wp_error($menu_id)) {
            $this->log('Error creating menu: ' . $menu_id->get_error_message());
            return;
        }
        
        // Add menu items
        $pages = array(
            'Home' => home_url('/'),
            'About Us' => '',
            'Services' => '',
            'Contact' => ''
        );
        
        foreach ($pages as $page_title => $custom_url) {
            if ($custom_url) {
                // Custom URL
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $page_title,
                    'menu-item-url' => $custom_url,
                    'menu-item-status' => 'publish'
                ));
            } else {
                // Page link
                $page = get_page_by_title($page_title);
                if ($page) {
                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' => $page_title,
                        'menu-item-object-id' => $page->ID,
                        'menu-item-object' => 'page',
                        'menu-item-type' => 'post_type',
                        'menu-item-status' => 'publish'
                    ));
                }
            }
        }
        
        // Add Products link if WooCommerce is active
        if (class_exists('WooCommerce')) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Products',
                'menu-item-url' => home_url('/shop/'),
                'menu-item-status' => 'publish'
            ));
        }
        
        // Assign menu to primary location
        $locations = get_theme_mod('nav_menu_locations', array());
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        
        $this->log('Primary menu created and assigned');
    }
    
    private function configure_site_settings() {
        // Set site title and tagline
        update_option('blogname', 'West Pace Apparels Ltd');
        update_option('blogdescription', 'Premium Garment Manufacturing Since 1998');
        
        // Set permalink structure
        update_option('permalink_structure', '/%postname%/');
        
        // Set timezone (Fiji)
        update_option('timezone_string', 'Pacific/Fiji');
        
        // Configure WooCommerce if active
        if (class_exists('WooCommerce')) {
            update_option('woocommerce_currency', 'AUD');
            update_option('woocommerce_default_country', 'FJ');
            update_option('woocommerce_calc_taxes', 'yes');
            
            // Create product categories
            $categories = array(
                'School Wear' => 'Uniforms and apparel for educational institutions',
                'Work Wear' => 'Professional workwear and safety clothing',
                'Winter Wear' => 'Warm clothing for cold climates',
                'Island Wear' => 'Tropical and casual Pacific island clothing'
            );
            
            foreach ($categories as $name => $description) {
                $term = wp_insert_term($name, 'product_cat', array(
                    'description' => $description
                ));
                if (!is_wp_error($term)) {
                    $this->log('Created product category: ' . $name);
                }
            }
        }
        
        $this->log('Site settings configured');
    }
    
    private function create_or_update_page($title, $content) {
        $page = get_page_by_title($title);
        
        if ($page) {
            // Update existing page
            $page_data = array(
                'ID' => $page->ID,
                'post_content' => $content
            );
            $page_id = wp_update_post($page_data);
            $this->log('Updated page: ' . $title);
        } else {
            // Create new page
            $page_data = array(
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'publish',
                'post_type' => 'page'
            );
            $page_id = wp_insert_post($page_data);
            $this->log('Created page: ' . $title);
        }
        
        return $page_id;
    }
    
    private function get_or_create_category($category_name) {
        $category = get_category_by_slug(sanitize_title($category_name));
        if (!$category) {
            $result = wp_insert_term($category_name, 'category');
            if (is_wp_error($result)) {
                $this->log('Error creating category: ' . $category_name);
                return 1; // Return default category
            }
            $this->log('Created category: ' . $category_name);
            return $result['term_id'];
        }
        return $category->term_id;
    }
    
    private function log($message) {
        $this->log[] = '[' . date('Y-m-d H:i:s') . '] ' . $message;
    }
    
    public function get_log() {
        return $this->log;
    }
}

// Web interface
?>
<!DOCTYPE html>
<html>
<head>
    <title>West Pace Content Import</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .log { background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #007cba; }
        .button { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; }
        .button:hover { background: #005a87; }
        .success { background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; border: 1px solid #c3e6cb; margin: 20px 0; }
        h1 { color: #333; margin-bottom: 10px; }
        .subtitle { color: #666; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>West Pace Content Import</h1>
        <p class="subtitle">Import content from your existing website</p>
        
        <?php if (isset($_POST['run_import'])): ?>
            <div class="log">
                <h3>Import Results:</h3>
                <ul>
                    <?php
                    $importer = new SimpleWestPaceImporter();
                    $log = $importer->import();
                    foreach ($log as $entry) {
                        echo '<li>' . htmlspecialchars($entry) . '</li>';
                    }
                    ?>
                </ul>
            </div>
            
            <div class="success">
                <h3>✅ Import Complete!</h3>
                <p><strong>Next steps:</strong></p>
                <ol>
                    <li>Review the imported content</li>
                    <li>Install WooCommerce plugin if not already installed</li>
                    <li>Start adding your product catalog</li>
                    <li>Configure payment methods and shipping</li>
                </ol>
                <p><a href="<?php echo admin_url(); ?>" class="button">Go to WordPress Admin</a></p>
            </div>
            
        <?php else: ?>
            <p>This script will import basic content structure for your West Pace website.</p>
            
            <h3>What will be imported:</h3>
            <ul>
                <li>✓ Homepage with company information</li>
                <li>✓ About Us page with company history</li>
                <li>✓ Services page detailing your offerings</li>
                <li>✓ Contact page</li>
                <li>✓ Client testimonials as blog posts</li>
                <li>✓ Navigation menu setup</li>
                <li>✓ Basic WordPress and WooCommerce configuration</li>
            </ul>
            
            <form method="post" style="margin-top: 30px;">
                <button type="submit" name="run_import" class="button">Start Import Process</button>
            </form>
        <?php endif; ?>
        
        <hr style="margin: 40px 0;">
        <p><strong>Note:</strong> This import creates basic content structure. You can customize and expand the content after import.</p>
    </div>
</body>
</html>
