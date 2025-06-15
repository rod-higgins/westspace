<?php
/**
 * The front page template file
 * This template displays the homepage for Westpace Material theme
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

get_header();
?>

<main id="primary" class="site-main front-page-main">
    
    <!-- Hero Section -->
    <?php westpace_get_hero_section(); ?>
    
    <!-- Company Introduction -->
    <section class="company-intro section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e('About West Pace Apparels', 'westpace-material'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Family-owned Fijian company with over 24 years of excellence in garment manufacturing', 'westpace-material'); ?>
                </p>
            </div>
            
            <div class="intro-content">
                <div class="intro-text">
                    <p class="intro-paragraph">
                        <?php esc_html_e('Since 1998, West Pace Apparels has been at the forefront of premium garment manufacturing in the South Pacific. Our commitment to quality, sustainability, and innovation has made us the trusted partner for schools, businesses, and organizations across Australia, New Zealand, and the Pacific Islands.', 'westpace-material'); ?>
                    </p>
                    
                    <div class="intro-stats">
                        <div class="stat-item">
                            <span class="stat-number">24+</span>
                            <span class="stat-label"><?php esc_html_e('Years of Excellence', 'westpace-material'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1000+</span>
                            <span class="stat-label"><?php esc_html_e('Happy Clients', 'westpace-material'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50k+</span>
                            <span class="stat-label"><?php esc_html_e('Garments Produced', 'westpace-material'); ?></span>
                        </div>
                    </div>
                    
                    <div class="intro-actions">
                        <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn btn-primary btn-lg">
                            <span><?php esc_html_e('Learn More About Us', 'westpace-material'); ?></span>
                            <span class="material-icons-round">arrow_forward</span>
                        </a>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline btn-lg">
                            <span class="material-icons-round">contact_mail</span>
                            <span><?php esc_html_e('Get In Touch', 'westpace-material'); ?></span>
                        </a>
                    </div>
                </div>
                
                <div class="intro-image">
                    <img src="<?php echo esc_url(WESTPACE_THEME_URI . '/assets/images/company-intro.jpg'); ?>" 
                         alt="<?php esc_attr_e('West Pace Apparels manufacturing facility', 'westpace-material'); ?>"
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e('Our Services', 'westpace-material'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Comprehensive garment manufacturing solutions tailored to your needs', 'westpace-material'); ?>
                </p>
            </div>
            
            <div class="services-grid">
                <?php
                $services = array(
                    array(
                        'icon' => 'school',
                        'title' => __('School Uniforms', 'westpace-material'),
                        'description' => __('High-quality, durable school uniforms designed for comfort and longevity. From primary to secondary schools across the Pacific.', 'westpace-material'),
                        'features' => array(
                            __('Custom designs and colors', 'westpace-material'),
                            __('Durable, comfortable fabrics', 'westpace-material'),
                            __('Bulk order discounts', 'westpace-material')
                        )
                    ),
                    array(
                        'icon' => 'engineering',
                        'title' => __('Work Wear', 'westpace-material'),
                        'description' => __('Professional workwear and corporate uniforms that combine safety, comfort, and style for various industries.', 'westpace-material'),
                        'features' => array(
                            __('Safety-compliant materials', 'westpace-material'),
                            __('Corporate branding options', 'westpace-material'),
                            __('Hi-vis and protective wear', 'westpace-material')
                        )
                    ),
                    array(
                        'icon' => 'ac_unit',
                        'title' => __('Winter Wear', 'westpace-material'),
                        'description' => __('Specialized winter clothing designed for colder climates, perfect for New Zealand and southern Australian markets.', 'westpace-material'),
                        'features' => array(
                            __('Thermal insulation', 'westpace-material'),
                            __('Water-resistant options', 'westpace-material'),
                            __('Breathable materials', 'westpace-material')
                        )
                    ),
                    array(
                        'icon' => 'palette',
                        'title' => __('Custom Apparel', 'westpace-material'),
                        'description' => __('Bespoke garment solutions with custom designs, embroidery, and printing to meet your specific requirements.', 'westpace-material'),
                        'features' => array(
                            __('Custom design service', 'westpace-material'),
                            __('Embroidery and printing', 'westpace-material'),
                            __('Small to large orders', 'westpace-material')
                        )
                    )
                );
                
                foreach ($services as $service) :
                ?>
                    <div class="service-card material-card elevation-2">
                        <div class="service-icon">
                            <span class="material-icons-round"><?php echo esc_html($service['icon']); ?></span>
                        </div>
                        <div class="service-content">
                            <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                            <p class="service-description"><?php echo esc_html($service['description']); ?></p>
                            <ul class="service-features">
                                <?php foreach ($service['features'] as $feature) : ?>
                                    <li>
                                        <span class="material-icons-round">check_circle</span>
                                        <?php echo esc_html($feature); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="services-cta">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary btn-xl">
                        <span class="material-icons-round">store</span>
                        <span><?php esc_html_e('Browse Our Products', 'westpace-material'); ?></span>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/services')); ?>" class="btn btn-primary btn-xl">
                        <span class="material-icons-round">arrow_forward</span>
                        <span><?php esc_html_e('View All Services', 'westpace-material'); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Featured Products (if WooCommerce is active) -->
    <?php if (class_exists('WooCommerce')) : ?>
        <?php westpace_featured_products(4); ?>
    <?php endif; ?>
    
    <!-- Testimonials Section -->
    <section class="testimonials-section section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e('What Our Clients Say', 'westpace-material'); ?></h2>
                <p class="section-description">
                    <?php esc_html_e('Trusted by schools, businesses, and organizations across the Pacific', 'westpace-material'); ?>
                </p>
            </div>
            
            <div class="testimonials-grid">
                <?php
                $testimonials = array(
                    array(
                        'name' => 'Sarah Mitchell',
                        'position' => 'Principal, Auckland Primary School',
                        'content' => 'West Pace Apparels has been our uniform supplier for over 5 years. The quality is exceptional and the service is always professional.',
                        'rating' => 5
                    ),
                    array(
                        'name' => 'Mark Thompson',
                        'position' => 'Operations Manager, BuildCorp NZ',
                        'content' => 'Their workwear solutions have significantly improved our team\'s comfort and safety. Highly recommended for any business.',
                        'rating' => 5
                    ),
                    array(
                        'name' => 'Lisa Chen',
                        'position' => 'Purchasing Director, Melbourne Schools',
                        'content' => 'Reliable, affordable, and high-quality. West Pace consistently delivers on their promises with excellent customer service.',
                        'rating' => 5
                    )
                );
                
                foreach ($testimonials as $testimonial) :
                ?>
                    <div class="testimonial-card material-card elevation-1">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="material-icons-round star <?php echo $i <= $testimonial['rating'] ? 'filled' : ''; ?>">star</span>
                                <?php endfor; ?>
                            </div>
                            <blockquote class="testimonial-text">
                                "<?php echo esc_html($testimonial['content']); ?>"
                            </blockquote>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-info">
                                <cite class="author-name"><?php echo esc_html($testimonial['name']); ?></cite>
                                <span class="author-position"><?php echo esc_html($testimonial['position']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Recent Blog Posts -->
    <?php
    $recent_posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        )
    ));
    
    if ($recent_posts->have_posts()) :
    ?>
        <section class="blog-section section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title"><?php esc_html_e('Latest News & Updates', 'westpace-material'); ?></h2>
                    <p class="section-description">
                        <?php esc_html_e('Stay informed about our latest developments, industry news, and company updates', 'westpace-material'); ?>
                    </p>
                </div>
                
                <div class="blog-posts-grid">
                    <?php
                    while ($recent_posts->have_posts()) :
                        $recent_posts->the_post();
                        ?>
                        <article class="blog-post-card material-card elevation-2">
                            <div class="blog-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('blog-featured'); ?>
                                </a>
                                <div class="blog-post-meta">
                                    <span class="post-date">
                                        <span class="material-icons-round">schedule</span>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="blog-post-content">
                                <?php if (has_category()) : ?>
                                    <div class="blog-post-category">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h3 class="blog-post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <p class="blog-post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                
                                <a href="<?php the_permalink(); ?>" class="blog-post-link">
                                    <?php esc_html_e('Read More', 'westpace-material'); ?>
                                    <span class="material-icons-round">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                
                <div class="blog-cta">
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline btn-lg">
                        <span><?php esc_html_e('View All Posts', 'westpace-material'); ?></span>
                        <span class="material-icons-round">arrow_forward</span>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Contact CTA Section -->
    <section class="contact-cta-section section">
        <div class="container">
            <div class="cta-content">
                <div class="cta-text">
                    <h2 class="cta-title"><?php esc_html_e('Ready to Get Started?', 'westpace-material'); ?></h2>
                    <p class="cta-description">
                        <?php esc_html_e('Contact us today to discuss your garment manufacturing needs. Our team is ready to provide you with a custom solution that meets your requirements and budget.', 'westpace-material'); ?>
                    </p>
                    
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="material-icons-round">phone</span>
                            <span><?php echo esc_html(get_theme_mod('footer_phone_display', '+679 123 456')); ?></span>
                        </div>
                        <div class="contact-item">
                            <span class="material-icons-round">email</span>
                            <span><?php echo esc_html(get_theme_mod('footer_email', 'info@westpace.com')); ?></span>
                        </div>
                        <div class="contact-item">
                            <span class="material-icons-round">location_on</span>
                            <span><?php echo esc_html(get_theme_mod('footer_address', 'Suva, Fiji Islands')); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="cta-actions">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-xl">
                        <span class="material-icons-round">contact_mail</span>
                        <span><?php esc_html_e('Contact Us Today', 'westpace-material'); ?></span>
                    </a>
                    
                    <a href="tel:<?php echo esc_attr(get_theme_mod('footer_phone', '+679123456')); ?>" class="btn btn-outline btn-xl">
                        <span class="material-icons-round">phone</span>
                        <span><?php esc_html_e('Call Now', 'westpace-material'); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
/* Front Page Styles */
.front-page-main {
    overflow-x: hidden;
}

.section {
    padding: var(--space-20) 0;
    position: relative;
}

.section:nth-child(even) {
    background: var(--gray-50);
}

.section-header {
    text-align: center;
    margin-bottom: var(--space-16);
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.section-title {
    font-size: var(--text-4xl);
    font-weight: var(--font-weight-bold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
    line-height: 1.2;
}

.section-description {
    font-size: var(--text-xl);
    color: var(--gray-600);
    line-height: 1.6;
}

/* Company Introduction */
.intro-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-12);
    align-items: center;
}

.intro-paragraph {
    font-size: var(--text-lg);
    line-height: 1.8;
    color: var(--gray-700);
    margin-bottom: var(--space-8);
}

.intro-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

.stat-item {
    text-align: center;
    padding: var(--space-4);
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.stat-number {
    display: block;
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-black);
    color: var(--primary-600);
    line-height: 1;
}

.stat-label {
    font-size: var(--text-sm);
    color: var(--gray-600);
    font-weight: var(--font-weight-medium);
}

.intro-actions {
    display: flex;
    gap: var(--space-4);
    flex-wrap: wrap;
}

.intro-image img {
    width: 100%;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

/* Services Section */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-8);
    margin-bottom: var(--space-12);
}

.service-card {
    padding: var(--space-8);
    background: white;
    border-radius: var(--radius-xl);
    text-align: center;
    transition: all var(--transition-normal);
    border: 1px solid var(--gray-200);
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.service-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: var(--primary-100);
    color: var(--primary-600);
    border-radius: var(--radius-full);
    margin-bottom: var(--space-6);
    font-size: 2.5rem;
}

.service-title {
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.service-description {
    color: var(--gray-600);
    line-height: 1.6;
    margin-bottom: var(--space-6);
}

.service-features {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: left;
}

.service-features li {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-bottom: var(--space-3);
    color: var(--gray-700);
    font-size: var(--text-sm);
}

.service-features .material-icons-round {
    color: var(--primary-600);
    font-size: 1.25rem;
}

.services-cta {
    text-align: center;
}

/* Testimonials */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: var(--space-8);
}

.testimonial-card {
    padding: var(--space-8);
    background: white;
    border-radius: var(--radius-xl);
    border: 1px solid var(--gray-200);
}

.testimonial-rating {
    margin-bottom: var(--space-4);
}

.testimonial-rating .star {
    color: var(--gray-300);
    font-size: 1.25rem;
}

.testimonial-rating .star.filled {
    color: #FFD700;
}

.testimonial-text {
    font-size: var(--text-lg);
    font-style: italic;
    color: var(--gray-700);
    line-height: 1.6;
    margin-bottom: var(--space-6);
    border: none;
    padding: 0;
}

.author-name {
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    display: block;
    margin-bottom: var(--space-1);
}

.author-position {
    color: var(--gray-600);
    font-size: var(--text-sm);
}

/* Blog Section */
.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: var(--space-8);
    margin-bottom: var(--space-12);
}

.blog-post-card {
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: all var(--transition-normal);
    border: 1px solid var(--gray-200);
}

.blog-post-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.blog-post-thumbnail {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
}

.blog-post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.blog-post-card:hover .blog-post-thumbnail img {
    transform: scale(1.05);
}

.blog-post-meta {
    position: absolute;
    top: var(--space-4);
    right: var(--space-4);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-md);
    font-size: var(--text-sm);
}

.blog-post-meta .material-icons-round {
    font-size: 1rem;
    margin-right: var(--space-1);
}

.blog-post-content {
    padding: var(--space-6);
}

.blog-post-category a {
    display: inline-block;
    background: var(--primary-100);
    color: var(--primary-700);
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    text-decoration: none;
    margin-bottom: var(--space-3);
}

.blog-post-title {
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-3);
    line-height: 1.4;
}

.blog-post-title a {
    color: var(--gray-900);
    text-decoration: none;
}

.blog-post-title a:hover {
    color: var(--primary-600);
}

.blog-post-excerpt {
    color: var(--gray-600);
    line-height: 1.6;
    margin-bottom: var(--space-4);
}

.blog-post-link {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--primary-600);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
    transition: all var(--transition-fast);
}

.blog-post-link:hover {
    color: var(--primary-700);
    text-decoration: none;
}

.blog-cta {
    text-align: center;
}

/* Contact CTA */
.contact-cta-section {
    background: var(--primary-600);
    color: white;
}

.cta-content {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: var(--space-12);
    align-items: center;
}

.cta-title {
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    color: white;
    margin-bottom: var(--space-4);
}

.cta-description {
    font-size: var(--text-lg);
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    margin-bottom: var(--space-6);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
}

.contact-item {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    color: rgba(255, 255, 255, 0.9);
}

.cta-actions {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .intro-content {
        grid-template-columns: 1fr;
        gap: var(--space-8);
    }
    
    .intro-stats {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .cta-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .section {
        padding: var(--space-16) 0;
    }
    
    .section-title {
        font-size: var(--text-2xl);
    }
    
    .intro-stats {
        grid-template-columns: 1fr;
    }
    
    .intro-actions {
        justify-content: center;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .blog-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .contact-info {
        align-items: center;
    }
}
</style>

<?php
get_footer();
?>