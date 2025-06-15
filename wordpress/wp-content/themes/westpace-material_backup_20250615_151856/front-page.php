<?php get_header(); ?>

<main class="site-main front-page">
    <!-- Hero Section with immediate visual impact -->
    <section class="hero-section" style="background: linear-gradient(135deg, #1565C0 0%, #42A5F5 50%, #00BCD4 100%); color: white; padding: 120px 0 80px 0; text-align: center; min-height: 600px; display: flex; align-items: center;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 4rem; font-weight: 900; margin-bottom: 24px; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); color: white;">West Pace Apparels</h1>
                <p class="hero-subtitle" style="font-size: 1.5rem; font-weight: 400; margin-bottom: 16px; opacity: 0.9;">Premium Garment Manufacturing Since 1998</p>
                <p class="hero-description" style="font-size: 1.125rem; margin-bottom: 48px; line-height: 1.6; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                    Family-owned Fijian company specializing in school wear, workwear, and winterwear 
                    for Australian and South Pacific markets. Over 24 years of excellence in quality manufacturing.
                </p>
                <div class="hero-actions">
                    <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-primary" style="background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%); color: white; padding: 16px 32px; margin: 8px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; text-transform: uppercase; font-weight: 500;">
                        <span class="material-icons" style="margin-right: 8px;">shopping_bag</span>
                        View Products
                    </a>
                    <?php endif; ?>
                    <a href="/contact/" class="btn btn-secondary" style="background-color: #FF6F00; color: white; padding: 16px 32px; margin: 8px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; text-transform: uppercase; font-weight: 500;">
                        <span class="material-icons" style="margin-right: 8px;">message</span>
                        Get Quote
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section section" style="padding: 80px 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            <h2 class="section-title" style="text-align: center; margin-bottom: 48px; color: #1565C0; font-size: 2.5rem; font-weight: 600;">What Makes Us Different</h2>
            <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px; margin-top: 64px;">
                <div class="service-card" style="background: white; padding: 48px 32px; border-radius: 16px; text-align: center; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); transition: all 0.3s ease;">
                    <span class="material-icons service-icon" style="font-size: 64px; color: #1565C0; display: block; margin-bottom: 24px;">speed</span>
                    <h3 style="color: #1565C0; margin-bottom: 16px; font-size: 2rem;">Flexible Short Runs</h3>
                    <p>We accommodate both small and large quantity orders with quick turnaround times, ensuring your deadlines are always met.</p>
                </div>
                <div class="service-card" style="background: white; padding: 48px 32px; border-radius: 16px; text-align: center; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); transition: all 0.3s ease;">
                    <span class="material-icons service-icon" style="font-size: 64px; color: #1565C0; display: block; margin-bottom: 24px;">verified_user</span>
                    <h3 style="color: #1565C0; margin-bottom: 16px; font-size: 2rem;">Quality Assurance</h3>
                    <p>Comprehensive quality control systems and rigorous testing ensure reliable, consistent products that meet international standards.</p>
                </div>
                <div class="service-card" style="background: white; padding: 48px 32px; border-radius: 16px; text-align: center; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); transition: all 0.3s ease;">
                    <span class="material-icons service-icon" style="font-size: 64px; color: #1565C0; display: block; margin-bottom: 24px;">local_shipping</span>
                    <h3 style="color: #1565C0; margin-bottom: 16px; font-size: 2rem;">Fast Delivery</h3>
                    <p>Prompt service with efficient shipping to Australia, New Zealand, and South Pacific regions. Your orders delivered on time, every time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section" style="padding: 80px 0; background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
            <div class="about-content" style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;">
                <div class="about-text">
                    <h2 style="color: #1565C0; margin-bottom: 24px; font-size: 2.5rem;">Over Two Decades of Excellence</h2>
                    <p style="font-size: 1.125rem; line-height: 1.7; color: rgba(0, 0, 0, 0.60); margin-bottom: 24px;">
                        West Pace was established in 1998, initially in partnership with Mr. Ranjit Solanki of 
                        Ranjit Garments (Mfg.) Limited. Now solely owned by a dedicated husband and wife team, 
                        we have proudly served the Australian market for over 20 years.
                    </p>
                    <p style="font-size: 1.125rem; line-height: 1.7; color: rgba(0, 0, 0, 0.60); margin-bottom: 24px;">
                        Boasting a fluid manufacturing facility and well-engineered processing systems, 
                        West Pace has grown to currently employ over 100 skilled staff members.
                    </p>
                    <a href="/about/" class="btn btn-primary" style="background: linear-gradient(135deg, #1565C0 0%, #42A5F5 100%); color: white; padding: 16px 32px; border-radius: 8px; text-decoration: none; display: inline-block; text-transform: uppercase; font-weight: 500;">Learn More About Us</a>
                </div>
                <div class="about-image" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                    <div style="width: 100%; height: 300px; background: linear-gradient(45deg, #1565C0, #42A5F5); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">Manufacturing Facility Image</div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
