<?php
/**
 * Enhanced 404 Error Page for Westpace Material Theme
 * Modern, helpful 404 page with search and navigation suggestions
 */

get_header();
?>

<div class="error-404-container">
    <!-- 404 Hero Section -->
    <section class="error-404-hero">
        <div class="container">
            <div class="error-404-content">
                <!-- Animated 404 Illustration -->
                <div class="error-illustration fade-in-up">
                    <div class="error-number">
                        <span class="error-digit">4</span>
                        <span class="error-digit">0</span>
                        <span class="error-digit">4</span>
                    </div>
                    <div class="error-icon">
                        <span class="material-icons">sentiment_dissatisfied</span>
                    </div>
                </div>
                
                <!-- Error Message -->
                <div class="error-message fade-in-up" style="animation-delay: 0.2s;">
                    <h1 class="error-title"><?php esc_html_e('Oops! Page Not Found', 'westpace-material'); ?></h1>
                    <p class="error-description">
                        <?php esc_html_e('The page you\'re looking for seems to have wandered off. Don\'t worry, even the best explorers sometimes take a wrong turn!', 'westpace-material'); ?>
                    </p>
                </div>
                
                <!-- Search Form -->
                <div class="error-search fade-in-up" style="animation-delay: 0.4s;">
                    <h2 class="search-title"><?php esc_html_e('Let\'s help you find what you\'re looking for:', 'westpace-material'); ?></h2>
                    <form role="search" method="get" class="error-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-group">
                            <label for="error-search" class="sr-only"><?php esc_html_e('Search', 'westpace-material'); ?></label>
                            <input type="search" 
                                   id="error-search"
                                   class="search-input" 
                                   placeholder="<?php esc_attr_e('Search our website...', 'westpace-material'); ?>" 
                                   name="s"
                                   autocomplete="off"
                                   autofocus>
                            <button type="submit" class="search-button btn btn-primary">
                                <span class="material-icons">search</span>
                                <span class="sr-only"><?php esc_html_e('Search', 'westpace-material'); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Quick Actions -->
                <div class="error-actions fade-in-up" style="animation-delay: 0.6s;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
                        <span class="material-icons">home</span>
                        <?php esc_html_e('Back to Homepage', 'westpace-material'); ?>
                    </a>
                    
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-secondary btn-lg">
                            <span class="material-icons">store</span>
                            <?php esc_html_e('Browse Products', 'westpace-material'); ?>
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-accent btn-lg">
                        <span class="material-icons">support_agent</span>
                        <?php esc_html_e('Contact Support', 'westpace-material'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Helpful Suggestions Section -->
    <section class="error-suggestions">
        <div class="container">
            <div class="suggestions-grid">
                <!-- Popular Pages -->
                <div class="suggestion-card fade-in-up" style="animation-delay: 0.8s;">
                    <div class="suggestion-header">
                        <span class="material-icons suggestion-icon">trending_up</span>
                        <h3 class="suggestion-title"><?php esc_html_e('Popular Pages', 'westpace-material'); ?></h3>
                    </div>
                    <div class="suggestion-content">
                        <ul class="suggestion-list">
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About Us', 'westpace-material'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/services')); ?>"><?php esc_html_e('Our Services', 'westpace-material'); ?></a></li>
                            <?php if (class_exists('WooCommerce')) : ?>
                                <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php esc_html_e('Shop', 'westpace-material'); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>"><?php esc_html_e('Blog', 'westpace-material'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'westpace-material'); ?></a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Recent Posts -->
                <?php
                $recent_posts = get_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                
                if ($recent_posts) :
                ?>
                    <div class="suggestion-card fade-in-up" style="animation-delay: 1s;">
                        <div class="suggestion-header">
                            <span class="material-icons suggestion-icon">article</span>
                            <h3 class="suggestion-title"><?php esc_html_e('Recent Articles', 'westpace-material'); ?></h3>
                        </div>
                        <div class="suggestion-content">
                            <ul class="suggestion-list">
                                <?php foreach ($recent_posts as $post) : ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                                            <?php echo esc_html($post->post_title); ?>
                                        </a>
                                        <small class="post-date"><?php echo get_the_date('M j, Y', $post->ID); ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
                
                <!-- Contact Information -->
                <div class="suggestion-card fade-in-up" style="animation-delay: 1.2s;">
                    <div class="suggestion-header">
                        <span class="material-icons suggestion-icon">contact_support</span>
                        <h3 class="suggestion-title"><?php esc_html_e('Need Help?', 'westpace-material'); ?></h3>
                    </div>
                    <div class="suggestion-content">
                        <p><?php esc_html_e('Our team is here to assist you with any questions or concerns.', 'westpace-material'); ?></p>
                        <div class="contact-methods">
                            <div class="contact-item">
                                <span class="material-icons">phone</span>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('company_phone_raw', '+679123456')); ?>">
                                    <?php echo esc_html(get_theme_mod('company_phone', '+679 123 456')); ?>
                                </a>
                            </div>
                            <div class="contact-item">
                                <span class="material-icons">email</span>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('company_email', 'info@westpace.com')); ?>">
                                    <?php echo esc_html(get_theme_mod('company_email', 'info@westpace.com')); ?>
                                </a>
                            </div>
                            <div class="contact-item">
                                <span class="material-icons">schedule</span>
                                <span><?php echo esc_html(get_theme_mod('business_hours', 'Mon-Fri: 8AM-6PM (FJT)')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Breadcrumb Trail Suggestion -->
    <section class="error-breadcrumb-section">
        <div class="container">
            <div class="breadcrumb-suggestion fade-in-up">
                <h3><?php esc_html_e('You might want to start from:', 'westpace-material'); ?></h3>
                <nav class="breadcrumb-nav" aria-label="<?php esc_attr_e('Suggested navigation', 'westpace-material'); ?>">
                    <ol class="breadcrumb-list">
                        <li class="breadcrumb-item">
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <span class="material-icons">home</span>
                                <?php esc_html_e('Home', 'westpace-material'); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="material-icons">arrow_forward</span>
                            <span><?php esc_html_e('Explore our main sections', 'westpace-material'); ?></span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Enhanced 404 Styles -->
<style>
/* 404 Page Styles */
.error-404-container {
    min-height: calc(100vh - 160px);
    display: flex;
    flex-direction: column;
}

/* Hero Section */
.error-404-hero {
    background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
    padding: 6rem 0 4rem;
    margin-top: 80px;
    text-align: center;
    flex: 1;
    display: flex;
    align-items: center;
}

.error-404-content {
    max-width: 800px;
    margin: 0 auto;
}

/* Error Illustration */
.error-illustration {
    margin-bottom: 3rem;
    position: relative;
}

.error-number {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.error-digit {
    font-size: clamp(4rem, 15vw, 8rem);
    font-weight: 900;
    background: linear-gradient(135deg, #1976D2 0%, #42A5F5 50%, #FF6D00 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    animation: float 3s ease-in-out infinite;
    position: relative;
}

.error-digit:nth-child(1) {
    animation-delay: 0s;
}

.error-digit:nth-child(2) {
    animation-delay: 0.5s;
}

.error-digit:nth-child(3) {
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.error-icon {
    font-size: 4rem;
    color: #64748B;
    opacity: 0.7;
}

/* Error Message */
.error-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.error-description {
    font-size: 1.25rem;
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Search Form */
.error-search {
    margin-bottom: 3rem;
}

.search-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1.5rem;
}

.error-search-form {
    max-width: 500px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.search-input {
    flex: 1;
    padding: 1rem 1.5rem;
    border: 2px solid #E2E8F0;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: #1976D2;
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.search-button {
    padding: 1rem;
    min-width: auto;
    border-radius: 0.75rem;
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Error Actions */
.error-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Suggestions Section */
.error-suggestions {
    background: white;
    padding: 4rem 0;
    border-top: 1px solid #E2E8F0;
}

.suggestions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.suggestion-card {
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.suggestion-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border-color: #1976D2;
}

.suggestion-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.suggestion-icon {
    background: linear-gradient(135deg, #1976D2 0%, #42A5F5 100%);
    color: white;
    padding: 0.75rem;
    border-radius: 0.75rem;
    font-size: 1.5rem;
}

.suggestion-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #0F172A;
    margin: 0;
}

.suggestion-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.suggestion-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #F1F5F9;
}

.suggestion-list li:last-child {
    border-bottom: none;
}

.suggestion-list a {
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    flex: 1;
}

.suggestion-list a:hover {
    color: #1976D2;
}

.post-date {
    color: #94A3B8;
    font-size: 0.75rem;
    margin-left: 1rem;
}

/* Contact Methods */
.contact-methods {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748B;
}

.contact-item .material-icons {
    color: #1976D2;
    font-size: 1.125rem;
}

.contact-item a {
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.contact-item a:hover {
    color: #1976D2;
}

/* Breadcrumb Suggestion */
.error-breadcrumb-section {
    background: #F8FAFC;
    padding: 3rem 0;
    text-align: center;
}

.breadcrumb-suggestion h3 {
    font-size: 1.5rem;
    color: #374151;
    margin-bottom: 1.5rem;
}

.breadcrumb-nav {
    display: inline-block;
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    gap: 1rem;
    list-style: none;
    margin: 0;
    padding: 0;
    background: white;
    padding: 1rem 2rem;
    border-radius: 3rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-item a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #1976D2;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #1565C0;
    transform: translateX(4px);
}

.breadcrumb-item span:not(.material-icons) {
    color: #64748B;
}

/* Responsive Design */
@media (max-width: 768px) {
    .error-404-hero {
        padding: 4rem 0 3rem;
    }
    
    .error-number {
        gap: 0.5rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-actions .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .search-input-group {
        flex-direction: column;
    }
    
    .search-button {
        width: 100%;
        aspect-ratio: auto;
    }
    
    .suggestions-grid {
        grid-template-columns: 1fr;
    }
    
    .breadcrumb-list {
        flex-direction: column;
        gap: 0.75rem;
        text-align: center;
    }
    
    .contact-methods {
        align-items: center;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .error-404-hero {
        padding: 3rem 0 2rem;
    }
    
    .suggestion-card {
        padding: 1.5rem;
    }
    
    .error-actions .btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .error-404-hero {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
    }
    
    .error-title {
        color: #F1F5F9;
    }
    
    .error-description {
        color: #94A3B8;
    }
    
    .search-title {
        color: #E2E8F0;
    }
    
    .suggestion-card {
        background: #1E293B;
        border-color: #334155;
    }
    
    .suggestion-title {
        color: #F1F5F9;
    }
    
    .breadcrumb-list {
        background: #1E293B;
        border: 1px solid #334155;
    }
}

/* Print styles */
@media print {
    .error-actions,
    .error-search,
    .error-suggestions {
        display: none;
    }
    
    .error-404-hero {
        background: none;
        color: black;
    }
    
    .error-title,
    .error-description {
        color: black;
    }
}
</style>

<?php
// Add enhanced functionality
wp_add_inline_script('westpace-theme-js', '
document.addEventListener("DOMContentLoaded", function() {
    // Auto-focus search input with slight delay
    setTimeout(() => {
        const searchInput = document.getElementById("error-search");
        if (searchInput) {
            searchInput.focus();
        }
    }, 1000);
    
    // Add search suggestions
    const searchInput = document.getElementById("error-search");
    if (searchInput) {
        const suggestions = [
            "products",
            "about us",
            "contact",
            "services",
            "blog",
            "support"
        ];
        
        searchInput.addEventListener("focus", function() {
            // You could implement search suggestions here
            console.log("Search focused - could show suggestions");
        });
        
        // Track 404 errors for analytics
        if (typeof gtag !== "undefined") {
            gtag("event", "page_view", {
                page_title: "404 Error",
                page_location: window.location.href
            });
        }
    }
    
    // Add some interactive elements
    const errorDigits = document.querySelectorAll(".error-digit");
    errorDigits.forEach((digit, index) => {
        digit.addEventListener("mouseenter", function() {
            this.style.transform = "translateY(-5px) scale(1.05)";
        });
        
        digit.addEventListener("mouseleave", function() {
            this.style.transform = "";
        });
    });
});
');

get_footer();
?>