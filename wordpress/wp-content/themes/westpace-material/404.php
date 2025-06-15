<?php
/**
 * The template for displaying 404 pages (not found)
 * Enhanced 404 page with modern design and helpful navigation
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

get_header();
?>

<main class="site-main error-404-page">
    <div class="error-404-hero">
        <div class="container">
            <div class="error-content">
                <div class="error-animation">
                    <div class="error-number">
                        <span class="error-digit">4</span>
                        <span class="error-digit">0</span>
                        <span class="error-digit">4</span>
                    </div>
                    <div class="error-icon">
                        <span class="material-icons-round">sentiment_dissatisfied</span>
                    </div>
                </div>
                
                <div class="error-text">
                    <h1 class="error-title"><?php esc_html_e('Page Not Found', 'westpace-material'); ?></h1>
                    <p class="error-description">
                        <?php esc_html_e('Sorry, the page you are looking for could not be found. It might have been moved, deleted, or the URL was typed incorrectly.', 'westpace-material'); ?>
                    </p>
                </div>
                
                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
                        <span class="material-icons-round">home</span>
                        <?php esc_html_e('Back to Home', 'westpace-material'); ?>
                    </a>
                    
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-secondary btn-lg">
                            <span class="material-icons-round">shopping_bag</span>
                            <?php esc_html_e('Shop Now', 'westpace-material'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="error-help-section">
        <div class="container">
            <div class="error-help-grid">
                <!-- Search Section -->
                <div class="error-search">
                    <h3 class="search-title"><?php esc_html_e('Search Our Site', 'westpace-material'); ?></h3>
                    <form role="search" method="get" class="search-form material-card" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-group">
                            <input type="search" 
                                   id="error-search"
                                   class="search-field" 
                                   placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'westpace-material'); ?>" 
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s" 
                                   required>
                            <button type="submit" class="search-submit btn btn-primary">
                                <span class="material-icons-round">search</span>
                                <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'westpace-material'); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Helpful Links -->
                <div class="error-suggestions">
                    <h3 class="suggestions-title"><?php esc_html_e('Helpful Links', 'westpace-material'); ?></h3>
                    <div class="suggestions-grid">
                        <?php
                        $helpful_links = array(
                            array(
                                'title' => __('About Us', 'westpace-material'),
                                'url'   => home_url('/about'),
                                'icon'  => 'info',
                                'desc'  => __('Learn about our company and mission', 'westpace-material')
                            ),
                            array(
                                'title' => __('Contact', 'westpace-material'),
                                'url'   => home_url('/contact'),
                                'icon'  => 'contact_mail',
                                'desc'  => __('Get in touch with our team', 'westpace-material')
                            ),
                            array(
                                'title' => __('Blog', 'westpace-material'),
                                'url'   => home_url('/blog'),
                                'icon'  => 'article',
                                'desc'  => __('Read our latest news and updates', 'westpace-material')
                            ),
                            array(
                                'title' => __('Support', 'westpace-material'),
                                'url'   => home_url('/support'),
                                'icon'  => 'support',
                                'desc'  => __('Find help and documentation', 'westpace-material')
                            ),
                        );
                        
                        // Add WooCommerce links if active
                        if (class_exists('WooCommerce')) {
                            $helpful_links[] = array(
                                'title' => __('Shop', 'westpace-material'),
                                'url'   => wc_get_page_permalink('shop'),
                                'icon'  => 'store',
                                'desc'  => __('Browse our products', 'westpace-material')
                            );
                            
                            $helpful_links[] = array(
                                'title' => __('My Account', 'westpace-material'),
                                'url'   => wc_get_page_permalink('myaccount'),
                                'icon'  => 'person',
                                'desc'  => __('Manage your account', 'westpace-material')
                            );
                        }
                        
                        foreach ($helpful_links as $link) :
                        ?>
                            <a href="<?php echo esc_url($link['url']); ?>" class="suggestion-card material-card elevation-1">
                                <div class="suggestion-icon">
                                    <span class="material-icons-round"><?php echo esc_html($link['icon']); ?></span>
                                </div>
                                <div class="suggestion-content">
                                    <h4 class="suggestion-title"><?php echo esc_html($link['title']); ?></h4>
                                    <p class="suggestion-desc"><?php echo esc_html($link['desc']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Breadcrumb Navigation -->
            <nav class="error-breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'westpace-material'); ?>">
                <ol class="breadcrumb-list">
                    <li class="breadcrumb-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <span class="material-icons-round">home</span>
                            <?php esc_html_e('Home', 'westpace-material'); ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php esc_html_e('404 Error', 'westpace-material'); ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</main>

<style>
/* Enhanced 404 Page Styles */
.error-404-page {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.error-404-hero {
    background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
    color: white;
    padding: var(--space-20) 0 var(--space-16);
    flex: 1;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.error-404-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.error-content {
    text-align: center;
    position: relative;
    z-index: 2;
}

.error-animation {
    margin-bottom: var(--space-8);
    position: relative;
}

.error-number {
    display: flex;
    justify-content: center;
    gap: var(--space-4);
    margin-bottom: var(--space-6);
}

.error-digit {
    font-size: 8rem;
    font-weight: var(--font-weight-black);
    line-height: 1;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    animation: digitFloat 3s ease-in-out infinite;
    opacity: 0.9;
}

.error-digit:nth-child(2) {
    animation-delay: 0.3s;
}

.error-digit:nth-child(3) {
    animation-delay: 0.6s;
}

.error-icon {
    font-size: 4rem;
    opacity: 0.7;
    animation: iconPulse 2s ease-in-out infinite;
}

.error-title {
    font-size: var(--text-4xl);
    font-weight: var(--font-weight-bold);
    margin-bottom: var(--space-6);
    color: white;
}

.error-description {
    font-size: var(--text-lg);
    max-width: 600px;
    margin: 0 auto var(--space-8);
    opacity: 0.9;
    line-height: 1.6;
}

.error-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: center;
    flex-wrap: wrap;
}

.error-help-section {
    background: var(--gray-50);
    padding: var(--space-20) 0;
}

.error-help-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: var(--space-16);
    margin-bottom: var(--space-16);
}

.search-title,
.suggestions-title {
    font-size: var(--text-2xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-6);
    color: var(--gray-900);
}

.search-form {
    padding: var(--space-6);
    border-radius: var(--radius-xl);
}

.search-input-group {
    display: flex;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}

.search-field {
    flex: 1;
    padding: var(--space-4) var(--space-6);
    border: none;
    font-size: var(--text-base);
    background: white;
    outline: none;
}

.search-submit {
    padding: var(--space-4) var(--space-6);
    border: none;
    border-radius: 0;
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.suggestions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-4);
}

.suggestion-card {
    display: flex;
    align-items: flex-start;
    gap: var(--space-4);
    padding: var(--space-6);
    border-radius: var(--radius-lg);
    text-decoration: none;
    color: inherit;
    transition: all var(--transition-normal);
    background: white;
    border: 1px solid var(--gray-200);
}

.suggestion-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: inherit;
    text-decoration: none;
}

.suggestion-icon {
    background: var(--primary-100);
    color: var(--primary-600);
    padding: var(--space-3);
    border-radius: var(--radius-lg);
    flex-shrink: 0;
}

.suggestion-title {
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-2);
    color: var(--gray-900);
}

.suggestion-desc {
    font-size: var(--text-sm);
    color: var(--gray-600);
    margin: 0;
}

.error-breadcrumb {
    margin-top: var(--space-8);
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    list-style: none;
    margin: 0;
    padding: var(--space-4) var(--space-6);
    background: white;
    border-radius: var(--radius-lg);
    border: 1px solid var(--gray-200);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: var(--text-sm);
}

.breadcrumb-item:not(:last-child)::after {
    content: '';
    width: 0;
    height: 0;
    border-left: 4px solid var(--gray-400);
    border-top: 4px solid transparent;
    border-bottom: 4px solid transparent;
    margin: 0 var(--space-3);
}

.breadcrumb-item a {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--primary-600);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--gray-600);
    font-weight: var(--font-weight-medium);
}

/* Animations */
@keyframes digitFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes iconPulse {
    0%, 100% { opacity: 0.7; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.1); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .error-digit {
        font-size: 4rem;
    }
    
    .error-title {
        font-size: var(--text-2xl);
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-help-grid {
        grid-template-columns: 1fr;
        gap: var(--space-12);
    }
    
    .suggestions-grid {
        grid-template-columns: 1fr;
    }
    
    .breadcrumb-list {
        justify-content: center;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .error-help-section {
        background: var(--gray-900);
    }
    
    .search-title,
    .suggestions-title {
        color: var(--gray-100);
    }
    
    .suggestion-card {
        background: var(--gray-800);
        border-color: var(--gray-700);
    }
    
    .suggestion-title {
        color: var(--gray-100);
    }
    
    .suggestion-desc {
        color: var(--gray-400);
    }
    
    .breadcrumb-list {
        background: var(--gray-800);
        border-color: var(--gray-700);
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
    
    // Track 404 errors for analytics
    if (typeof gtag !== "undefined") {
        gtag("event", "page_view", {
            page_title: "404 Error",
            page_location: window.location.href
        });
    }
    
    // Add interactive hover effects
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