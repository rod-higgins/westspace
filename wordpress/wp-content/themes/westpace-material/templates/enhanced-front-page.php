<?php
/**
 * Enhanced Front Page Template for Westpace Material Theme
 * Modern, sophisticated homepage with Apple-inspired design
 */

get_header();
?>

<!-- Hero Section with Parallax -->
<section class="hero-section" id="hero">
    <div class="hero-background" data-parallax="true"></div>
    <div class="hero-particles" id="hero-particles"></div>
    
    <div class="container">
        <div class="hero-content fade-in-up">
            <h1 class="hero-title">
                <?php echo esc_html(get_theme_mod('hero_title', __('West Pace Apparels', 'westpace-material'))); ?>
            </h1>
            <h2 class="hero-subtitle">
                <?php echo esc_html(get_theme_mod('hero_subtitle', __('Premium Garment Manufacturing Since 1998', 'westpace-material'))); ?>
            </h2>
            <p class="hero-description">
                <?php echo esc_html(get_theme_mod('hero_description', __('Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets. Over 24 years of excellence in quality manufacturing.', 'westpace-material'))); ?>
            </p>
            
            <div class="hero-actions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary btn-lg">
                        <span class="material-icons">shopping_bag</span>
                        <?php esc_html_e('Explore Products', 'westpace-material'); ?>
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary btn-lg">
                    <span class="material-icons">chat</span>
                    <?php esc_html_e('Get Custom Quote', 'westpace-material'); ?>
                </a>
            </div>
            
            <!-- Trust Indicators -->
            <div class="hero-trust-indicators fade-in-up" style="animation-delay: 0.3s;">
                <div class="trust-item">
                    <span class="trust-number">24+</span>
                    <span class="trust-label"><?php esc_html_e('Years Experience', 'westpace-material'); ?></span>
                </div>
                <div class="trust-item">
                    <span class="trust-number">1000+</span>
                    <span class="trust-label"><?php esc_html_e('Happy Clients', 'westpace-material'); ?></span>
                </div>
                <div class="trust-item">
                    <span class="trust-number">100%</span>
                    <span class="trust-label"><?php esc_html_e('Quality Assured', 'westpace-material'); ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <span class="material-icons">keyboard_arrow_down</span>
    </div>
</section>

<!-- Company Highlights Section -->
<section class="highlights-section section" id="highlights">
    <div class="container">
        <div class="highlights-grid">
            <div class="highlight-card card-elevated slide-in-left">
                <div class="highlight-icon">
                    <span class="material-icons">verified</span>
                </div>
                <div class="highlight-content">
                    <h3><?php esc_html_e('ISO Certified', 'westpace-material'); ?></h3>
                    <p><?php esc_html_e('International quality standards ensuring consistent excellence in every product we manufacture.', 'westpace-material'); ?></p>
                </div>
            </div>
            
            <div class="highlight-card card-elevated scale-in" style="animation-delay: 0.2s;">
                <div class="highlight-icon">
                    <span class="material-icons">eco</span>
                </div>
                <div class="highlight-content">
                    <h3><?php esc_html_e('Sustainable Practices', 'westpace-material'); ?></h3>
                    <p><?php esc_html_e('Committed to environmentally responsible manufacturing with minimal waste and eco-friendly materials.', 'westpace-material'); ?></p>
                </div>
            </div>
            
            <div class="highlight-card card-elevated slide-in-right" style="animation-delay: 0.4s;">
                <div class="highlight-icon">
                    <span class="material-icons">local_shipping</span>
                </div>
                <div class="highlight-content">
                    <h3><?php esc_html_e('Fast Delivery', 'westpace-material'); ?></h3>
                    <p><?php esc_html_e('Efficient logistics network ensuring prompt delivery across Australia, New Zealand, and Pacific regions.', 'westpace-material'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section section section-alt" id="services">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title"><?php esc_html_e('What Makes Us Different', 'westpace-material'); ?></h2>
            <p class="section-subtitle"><?php esc_html_e('We combine traditional craftsmanship with modern technology to deliver exceptional results that exceed expectations.', 'westpace-material'); ?></p>
        </div>
        
        <div class="services-grid">
            <div class="service-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="service-icon">
                    <span class="material-icons">speed</span>
                </div>
                <h3><?php esc_html_e('Flexible Manufacturing', 'westpace-material'); ?></h3>
                <p><?php esc_html_e('Accommodate both small and large quantity orders with quick turnaround times. Our flexible production line adapts to your specific requirements and deadlines.', 'westpace-material'); ?></p>
                <div class="service-features">
                    <span class="feature"><?php esc_html_e('Rush Orders Available', 'westpace-material'); ?></span>
                    <span class="feature"><?php esc_html_e('Custom Specifications', 'westpace-material'); ?></span>
                    <span class="feature"><?php esc_html_e('Scalable Production', 'westpace-material'); ?></span>
                </div>
            </div>
            
            <div class="service-card fade-in-up" style="animation-delay: 0.2s;">
                <div class="service-icon">
                    <span class="material-icons">verified_user</span>
                </div>
                <h3><?php esc_html_e('Quality Assurance', 'westpace-material'); ?></h3>
                <p><?php esc_html_e('Comprehensive quality control systems and rigorous testing ensure reliable, consistent products that meet international standards and exceed customer expectations.', 'westpace-material'); ?></p>
                <div class="service-features">
                    <span class="feature"><?php esc_html_e('Multi-Point Inspection', 'westpace-material'); ?></span>
                    <span class="feature"><?php esc_html_e('Fabric Testing', 'westpace-material'); ?></span>
                    <span class="feature"><?php esc_html_e('Durability Assurance', 'westpace-material'); ?></span>
                </div>
            </div>
            
            <div class="service-card fade-in-up" style="animation-delay: 0.3s;">
                <div class="service-icon">
                    <span class="material-icons">palette</span>
                </div>
                <h3><?php esc_html_e('Custom Design', 'westpace-material'); ?></h3>
                <p><?php esc_html_e('Expert design team works with you to create unique garments that reflect your brand identity while maintaining functionality and comfort for end users.', 'westpace-material'); ?></p>
                <div class="service-features">
                    <span class="feature"><?php esc_html_e('Brand Integration', 'westpace-material'); ?></span>
                    <span class="feature"><?php esc_html_e('Color Matching', 'westpace-material'); ?></span>
                    <span class="feature"><?php esc_html_e('Logo Placement', 'westpace-material'); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (class_exists('WooCommerce')) : ?>
<!-- Featured Products Section -->
<section class="featured-products-section section" id="products">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title"><?php esc_html_e('Featured Products', 'westpace-material'); ?></h2>
            <p class="section-subtitle"><?php esc_html_e('Discover our most popular garments trusted by schools, businesses, and organizations across the Pacific.', 'westpace-material'); ?></p>
        </div>
        
        <div class="products-showcase">
            <?php
            $featured_products = wc_get_featured_product_ids();
            if (empty($featured_products)) {
                // Fallback to recent products if no featured products
                $products_query = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => '_visibility',
                            'value' => array('catalog', 'visible'),
                            'compare' => 'IN'
                        )
                    )
                ));
            } else {
                $products_query = new WP_Query(array(
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                    'post__in' => array_slice($featured_products, 0, 6),
                    'orderby' => 'post__in'
                ));
            }
            
            if ($products_query->have_posts()) :
                echo '<div class="products-grid">';
                $delay = 0.1;
                while ($products_query->have_posts()) : $products_query->the_post();
                    global $product;
                    ?>
                    <div class="product-card fade-in-up" style="animation-delay: <?php echo esc_attr($delay); ?>s;">
                        <div class="product-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('woocommerce_thumbnail', array('class' => 'product-img')); ?>
                                <?php else : ?>
                                    <div class="product-placeholder">
                                        <span class="material-icons">image</span>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <?php if ($product->is_on_sale()) : ?>
                                <span class="sale-badge"><?php esc_html_e('Sale', 'westpace-material'); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-content">
                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="product-price">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            
                            <div class="product-actions">
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                                <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm">
                                    <?php esc_html_e('View Details', 'westpace-material'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $delay += 0.1;
                endwhile;
                echo '</div>';
                wp_reset_postdata();
            endif;
            ?>
        </div>
        
        <div class="text-center fade-in-up" style="margin-top: 3rem;">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary btn-lg">
                <span class="material-icons">storefront</span>
                <?php esc_html_e('View All Products', 'westpace-material'); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- About Section with Video -->
<section class="about-section section section-alt" id="about">
    <div class="container">
        <div class="about-content">
            <div class="about-text slide-in-left">
                <h2><?php esc_html_e('Crafting Excellence Since 1998', 'westpace-material'); ?></h2>
                
                <div class="about-stats">
                    <div class="stat-item">
                        <span class="stat-number">24+</span>
                        <span class="stat-label"><?php esc_html_e('Years of Experience', 'westpace-material'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">500K+</span>
                        <span class="stat-label"><?php esc_html_e('Garments Produced', 'westpace-material'); ?></span>
                    </div>
                </div>
                
                <p><?php esc_html_e('Established in 1998, West Pace Apparels has been a trusted partner in garment manufacturing for over two decades. Our family-owned business combines traditional craftsmanship with modern technology to deliver exceptional quality products.', 'westpace-material'); ?></p>
                
                <p><?php esc_html_e('We specialize in school uniforms, corporate workwear, and winter apparel, serving clients across Australia, New Zealand, and the South Pacific region with dedication to quality, sustainability, and customer satisfaction.', 'westpace-material'); ?></p>
                
                <div class="about-features">
                    <div class="feature-item">
                        <span class="material-icons">group</span>
                        <span><?php esc_html_e('Family-Owned Business', 'westpace-material'); ?></span>
                    </div>
                    <div class="feature-item">
                        <span class="material-icons">public</span>
                        <span><?php esc_html_e('International Reach', 'westpace-material'); ?></span>
                    </div>
                    <div class="feature-item">
                        <span class="material-icons">handshake</span>
                        <span><?php esc_html_e('Long-term Partnerships', 'westpace-material'); ?></span>
                    </div>
                </div>
                
                <div class="about-actions">
                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn btn-primary">
                        <span class="material-icons">info</span>
                        <?php esc_html_e('Learn More About Us', 'westpace-material'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary">
                        <span class="material-icons">connect_without_contact</span>
                        <?php esc_html_e('Schedule a Consultation', 'westpace-material'); ?>
                    </a>
                </div>
            </div>
            
            <div class="about-media slide-in-right">
                <div class="media-container">
                    <?php
                    $about_image = get_theme_mod('about_image', get_template_directory_uri() . '/assets/images/about-factory.jpg');
                    ?>
                    <img src="<?php echo esc_url($about_image); ?>" 
                         alt="<?php esc_attr_e('West Pace Apparels Manufacturing Facility', 'westpace-material'); ?>" 
                         class="about-image"
                         loading="lazy">
                    
                    <!-- Video Overlay Option -->
                    <?php if (get_theme_mod('about_video_url')) : ?>
                        <button class="video-play-button" data-video="<?php echo esc_url(get_theme_mod('about_video_url')); ?>">
                            <span class="material-icons">play_circle_filled</span>
                            <span class="play-text"><?php esc_html_e('Watch Our Story', 'westpace-material'); ?></span>
                        </button>
                    <?php endif; ?>
                </div>
                
                <!-- Certifications -->
                <div class="certifications">
                    <h4><?php esc_html_e('Our Certifications', 'westpace-material'); ?></h4>
                    <div class="cert-badges">
                        <div class="cert-badge">
                            <span class="material-icons">verified</span>
                            <span>ISO 9001</span>
                        </div>
                        <div class="cert-badge">
                            <span class="material-icons">eco</span>
                            <span>OEKO-TEX</span>
                        </div>
                        <div class="cert-badge">
                            <span class="material-icons">security</span>
                            <span>BSCI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section section" id="testimonials">
    <div class="container">
        <div class="section-header fade-in-up">
            <h2 class="section-title"><?php esc_html_e('What Our Clients Say', 'westpace-material'); ?></h2>
            <p class="section-subtitle"><?php esc_html_e('Trusted by schools, businesses, and organizations across the Pacific region.', 'westpace-material'); ?></p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card card-elevated fade-in-up" style="animation-delay: 0.1s;">
                <div class="testimonial-content">
                    <div class="testimonial-stars">
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                    </div>
                    <blockquote>
                        <?php esc_html_e('"West Pace Apparels has been our trusted partner for school uniforms for over 8 years. Their quality is consistently excellent, and their team always delivers on time."', 'westpace-material'); ?>
                    </blockquote>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4><?php esc_html_e('Sarah Mitchell', 'westpace-material'); ?></h4>
                        <p><?php esc_html_e('Principal, Brisbane Grammar School', 'westpace-material'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card card-elevated fade-in-up" style="animation-delay: 0.2s;">
                <div class="testimonial-content">
                    <div class="testimonial-stars">
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                    </div>
                    <blockquote>
                        <?php esc_html_e('"The custom workwear solution provided by West Pace exceeded our expectations. Professional service from design to delivery."', 'westpace-material'); ?>
                    </blockquote>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4><?php esc_html_e('James Chen', 'westpace-material'); ?></h4>
                        <p><?php esc_html_e('Operations Manager, Pacific Mining Co.', 'westpace-material'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card card-elevated fade-in-up" style="animation-delay: 0.3s;">
                <div class="testimonial-content">
                    <div class="testimonial-stars">
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                    </div>
                    <blockquote>
                        <?php esc_html_e('"Excellent communication, flexible production, and outstanding quality. West Pace is our go-to partner for all uniform needs."', 'westpace-material'); ?>
                    </blockquote>
                </div>
                <div class="testimonial-author">
                    <div class="author-info">
                        <h4><?php esc_html_e('Maria Rodriguez', 'westpace-material'); ?></h4>
                        <p><?php esc_html_e('Procurement Director, Auckland Health', 'westpace-material'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section section section-dark" id="cta">
    <div class="container">
        <div class="cta-content fade-in-up">
            <h2><?php esc_html_e('Ready to Create Something Amazing?', 'westpace-material'); ?></h2>
            <p><?php esc_html_e('Let\'s discuss your garment manufacturing needs and create a solution that perfectly fits your requirements.', 'westpace-material'); ?></p>
            
            <div class="cta-actions">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-accent btn-lg">
                    <span class="material-icons">schedule</span>
                    <?php esc_html_e('Schedule Consultation', 'westpace-material'); ?>
                </a>
                <a href="tel:+679123456" class="btn btn-secondary btn-lg">
                    <span class="material-icons">phone</span>
                    <?php esc_html_e('Call Now', 'westpace-material'); ?>
                </a>
            </div>
            
            <div class="cta-contact-info">
                <div class="contact-item">
                    <span class="material-icons">location_on</span>
                    <span><?php esc_html_e('Suva, Fiji Islands', 'westpace-material'); ?></span>
                </div>
                <div class="contact-item">
                    <span class="material-icons">schedule</span>
                    <span><?php esc_html_e('Mon-Fri: 8AM-6PM (FJT)', 'westpace-material'); ?></span>
                </div>
                <div class="contact-item">
                    <span class="material-icons">language</span>
                    <span><?php esc_html_e('Serving Australia & Pacific', 'westpace-material'); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Styles for Front Page -->
<style>
/* Hero Section Enhancements */
.hero-trust-indicators {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-top: 4rem;
    padding-top: 3rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.trust-item {
    text-align: center;
}

.trust-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    color: #FF6D00;
    margin-bottom: 0.5rem;
}

.trust-label {
    font-size: 0.875rem;
    opacity: 0.8;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Highlights Section */
.highlights-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
}

.highlights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.highlight-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    transition: all 0.3s ease;
}

.highlight-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.highlight-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #1976D2 0%, #42A5F5 100%);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.highlight-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #0F172A;
}

.highlight-content p {
    color: #64748B;
    line-height: 1.6;
    margin: 0;
}

/* Service Features */
.service-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1.5rem;
}

.feature {
    background: rgba(25, 118, 210, 0.1);
    color: #1976D2;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
}

/* About Section Stats */
.about-stats {
    display: flex;
    gap: 2rem;
    margin: 2rem 0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: #1976D2;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #64748B;
    font-weight: 500;
}

.about-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin: 2rem 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748B;
    font-weight: 500;
}

.feature-item .material-icons {
    color: #1976D2;
    font-size: 1.25rem;
}

.about-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Media Container */
.media-container {
    position: relative;
    border-radius: 2rem;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.about-image {
    width: 100%;
    height: auto;
    display: block;
}

.video-play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 1rem;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.video-play-button:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: translate(-50%, -50%) scale(1.05);
}

/* Certifications */
.certifications {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #F8FAFC;
    border-radius: 1rem;
}

.certifications h4 {
    margin-bottom: 1rem;
    color: #0F172A;
    font-size: 1rem;
    font-weight: 600;
}

.cert-badges {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.cert-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #1976D2;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Testimonials */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.testimonial-card {
    padding: 2rem;
    text-align: left;
}

.testimonial-stars {
    color: #FF6D00;
    margin-bottom: 1rem;
}

.testimonial-content blockquote {
    font-size: 1.125rem;
    line-height: 1.7;
    color: #334155;
    margin: 0 0 2rem 0;
    font-style: italic;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-info h4 {
    margin: 0 0 0.25rem 0;
    color: #0F172A;
    font-size: 1rem;
    font-weight: 600;
}

.author-info p {
    margin: 0;
    color: #64748B;
    font-size: 0.875rem;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
    color: white;
    text-align: center;
}

.cta-content h2 {
    font-size: clamp(2rem, 4vw, 3rem);
    margin-bottom: 1rem;
    color: white;
}

.cta-content p {
    font-size: 1.25rem;
    margin-bottom: 3rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 3rem;
}

.cta-contact-info {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.875rem;
}

/* Products Showcase */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.product-card {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.product-image {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

.product-placeholder {
    width: 100%;
    height: 100%;
    background: #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94A3B8;
    font-size: 3rem;
}

.sale-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #FF6D00;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-content {
    padding: 1.5rem;
}

.product-title a {
    color: #0F172A;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.125rem;
    line-height: 1.3;
}

.product-title a:hover {
    color: #1976D2;
}

.product-price {
    margin: 1rem 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #FF6D00;
}

.product-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-trust-indicators {
        flex-direction: column;
        gap: 2rem;
    }
    
    .highlights-grid {
        grid-template-columns: 1fr;
    }
    
    .highlight-card {
        flex-direction: column;
        text-align: center;
    }
    
    .about-content {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .about-stats {
        justify-content: center;
    }
    
    .cta-contact-info {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
}
</style>

<?php get_footer(); ?>