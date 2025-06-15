<?php get_header(); ?>

<main class="site-main front-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content fade-in-up">
                <h1 class="hero-title">West Pace Apparels</h1>
                <p class="hero-subtitle">Premium Garment Manufacturing Since 1998</p>
                <p class="hero-description">
                    Family-owned Fijian company specializing in school wear, workwear, and winterwear 
                    for Australian and South Pacific markets. Over 24 years of excellence in quality manufacturing.
                </p>
                <div class="hero-actions">
                    <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary btn-large">
                        <span class="material-icons" style="margin-right: 8px;">shopping_bag</span>
                        View Products
                    </a>
                    <?php endif; ?>
                    <a href="/contact/" class="btn btn-outline btn-large">
                        <span class="material-icons" style="margin-right: 8px;">message</span>
                        Get Quote
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section section">
        <div class="container">
            <h2 class="section-title">What Makes Us Different</h2>
            <div class="services-grid">
                <div class="service-card fade-in-up">
                    <span class="material-icons service-icon">speed</span>
                    <h3>Flexible Short Runs</h3>
                    <p>We accommodate both small and large quantity orders with quick turnaround times, ensuring your deadlines are always met.</p>
                </div>
                <div class="service-card fade-in-up" style="animation-delay: 0.2s;">
                    <span class="material-icons service-icon">verified_user</span>
                    <h3>Quality Assurance</h3>
                    <p>Comprehensive quality control systems and rigorous testing ensure reliable, consistent products that meet international standards.</p>
                </div>
                <div class="service-card fade-in-up" style="animation-delay: 0.4s;">
                    <span class="material-icons service-icon">local_shipping</span>
                    <h3>Fast Delivery</h3>
                    <p>Prompt service with efficient shipping to Australia, New Zealand, and South Pacific regions. Your orders delivered on time, every time.</p>
                </div>
                <div class="service-card fade-in-up" style="animation-delay: 0.6s;">
                    <span class="material-icons service-icon">precision_manufacturing</span>
                    <h3>Full Garment Supply</h3>
                    <p>Complete garment manufacturing and CMT services with state-of-the-art equipment and skilled craftspeople.</p>
                </div>
                <div class="service-card fade-in-up" style="animation-delay: 0.8s;">
                    <span class="material-icons service-icon">eco</span>
                    <h3>Sustainable Practices</h3>
                    <p>Environmentally conscious manufacturing processes that reduce waste and promote sustainable fashion production.</p>
                </div>
                <div class="service-card fade-in-up" style="animation-delay: 1s;">
                    <span class="material-icons service-icon">support_agent</span>
                    <h3>Dedicated Support</h3>
                    <p>Personalized customer service with dedicated account managers to ensure your specific needs are met every step of the way.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Over Two Decades of Excellence</h2>
                    <p>
                        West Pace was established in 1998, initially in partnership with Mr. Ranjit Solanki of 
                        Ranjit Garments (Mfg.) Limited. Now solely owned by a dedicated husband and wife team, 
                        we have proudly served the Australian market for over 20 years.
                    </p>
                    <p>
                        Boasting a fluid manufacturing facility and well-engineered processing systems, 
                        West Pace has grown to currently employ over 100 skilled staff members. 
                        We specialize in school wear, workwear, and winterwear, while also supplying 
                        our South Pacific neighbours and domestic market with vibrant colours and striking island wear.
                    </p>
                    <a href="/about/" class="btn btn-primary">Learn More About Us</a>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/factory-modern.jpg" 
                         alt="West Pace Manufacturing Facility" 
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item fade-in-up">
                    <div class="stat-number">24+</div>
                    <div class="stat-label">Years of Experience</div>
                </div>
                <div class="stat-item fade-in-up" style="animation-delay: 0.2s;">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Skilled Staff</div>
                </div>
                <div class="stat-item fade-in-up" style="animation-delay: 0.4s;">
                    <div class="stat-number">1000s</div>
                    <div class="stat-label">Orders Delivered</div>
                </div>
                <div class="stat-item fade-in-up" style="animation-delay: 0.6s;">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Countries Served</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clients Section -->
    <section class="clients-section section">
        <div class="container">
            <h2 class="section-title">Trusted by Leading Brands</h2>
            <div class="clients-grid">
                <div class="client-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/client-ranjit.png" 
                         alt="Ranjit Garments" loading="lazy">
                </div>
                <div class="client-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/client-snagindas.png" 
                         alt="Snagindas" loading="lazy">
                </div>
                <div class="client-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/client-rups.jpg" 
                         alt="Rups" loading="lazy">
                </div>
                <div class="client-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/client-oxygen.jpg" 
                         alt="Oxygen" loading="lazy">
                </div>
                <div class="client-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/client-bobstewart.jpg" 
                         alt="Bob Stewart" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section section" style="background: var(--gradient-primary); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white; margin-bottom: 24px;">Ready to Start Your Project?</h2>
            <p style="font-size: 1.25rem; margin-bottom: 32px; opacity: 0.9;">
                Get in touch with our team for a personalized quote and discover why leading brands choose West Pace Apparels.
            </p>
            <a href="/contact/" class="btn btn-secondary btn-large">
                <span class="material-icons" style="margin-right: 8px;">rocket_launch</span>
                Start Your Project Today
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
