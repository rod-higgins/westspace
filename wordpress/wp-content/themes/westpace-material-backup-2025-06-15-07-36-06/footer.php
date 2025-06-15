    </div><!-- #content -->
    
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section company-info">
                    <h3>West Pace Apparels Ltd</h3>
                    <p>Family-owned Fijian company with over 24 years of experience specializing in premium garment manufacturing for international markets.</p>
                    <div class="social-links" style="margin-top: 24px;">
                        <a href="#" style="margin-right: 16px; color: var(--secondary-color);" title="LinkedIn">
                            <span class="material-icons">business</span>
                        </a>
                        <a href="#" style="margin-right: 16px; color: var(--secondary-color);" title="Email">
                            <span class="material-icons">email</span>
                        </a>
                        <a href="#" style="color: var(--secondary-color);" title="Phone">
                            <span class="material-icons">phone</span>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Our Services</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 8px;"><a href="#">School Wear</a></li>
                        <li style="margin-bottom: 8px;"><a href="#">Work Wear</a></li>
                        <li style="margin-bottom: 8px;"><a href="#">Winter Wear</a></li>
                        <li style="margin-bottom: 8px;"><a href="#">Island Wear</a></li>
                        <li><a href="#">Custom Manufacturing</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 8px;"><a href="/">Home</a></li>
                        <li style="margin-bottom: 8px;"><a href="/about/">About Us</a></li>
                        <?php if (class_exists('WooCommerce')) : ?>
                        <li style="margin-bottom: 8px;"><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Products</a></li>
                        <?php endif; ?>
                        <li style="margin-bottom: 8px;"><a href="/contact/">Contact</a></li>
                        <li><a href="/quote/">Get Quote</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <div style="margin-bottom: 16px;">
                        <strong>Address:</strong><br>
                        Suva, Fiji Islands
                    </div>
                    <div style="margin-bottom: 16px;">
                        <strong>Email:</strong><br>
                        <a href="mailto:info@westpace.com.fj">info@westpace.com.fj</a>
                    </div>
                    <div>
                        <strong>Phone:</strong><br>
                        <a href="tel:+679">+679 XXX XXXX</a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved. | 
                   <a href="/privacy-policy/" style="color: inherit;">Privacy Policy</a> | 
                   <a href="/terms/" style="color: inherit;">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
// Add smooth reveal animations on scroll
document.addEventListener('DOMContentLoaded', function() {
    // Add animate class to elements when they come into view
    const animateElements = document.querySelectorAll('.fade-in-up, .slide-in-right, .service-card, .stat-item');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    animateElements.forEach(function(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(el);
    });
});
</script>

</body>
</html>
