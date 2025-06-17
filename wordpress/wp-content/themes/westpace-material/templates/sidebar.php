<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary">
    <div class="sidebar-content">
        
        <!-- Default Widgets if no widgets are added -->
        <?php if (!dynamic_sidebar('sidebar-1')) : ?>
            
            <!-- Search Widget -->
            <section class="widget widget_search material-card elevation-2">
                <h3 class="widget-title">
                    <span class="material-icons-round">search</span>
                    <?php esc_html_e('Search', 'westpace-material'); ?>
                </h3>
                <div class="widget-content">
                    <?php get_search_form(); ?>
                </div>
            </section>

            <!-- Recent Posts Widget -->
            <section class="widget widget_recent_entries material-card elevation-2">
                <h3 class="widget-title">
                    <span class="material-icons-round">article</span>
                    <?php esc_html_e('Recent Posts', 'westpace-material'); ?>
                </h3>
                <div class="widget-content">
                    <?php
                    $recent_posts = wp_get_recent_posts(array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ));
                    
                    if ($recent_posts) :
                    ?>
                        <ul class="recent-posts-list">
                            <?php foreach ($recent_posts as $recent) : ?>
                                <li class="recent-post-item">
                                    <div class="recent-post-content">
                                        <h4 class="recent-post-title">
                                            <a href="<?php echo esc_url(get_permalink($recent['ID'])); ?>">
                                                <?php echo esc_html($recent['post_title']); ?>
                                            </a>
                                        </h4>
                                        <div class="recent-post-meta">
                                            <span class="material-icons-round">schedule</span>
                                            <?php echo get_the_date('', $recent['ID']); ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; wp_reset_query(); ?>
                </div>
            </section>

            <!-- Categories Widget -->
            <?php
            $categories = get_categories(array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 10,
                'hide_empty' => true,
            ));
            
            if (!empty($categories)) :
            ?>
                <section class="widget widget_categories material-card elevation-2">
                    <h3 class="widget-title">
                        <span class="material-icons-round">folder</span>
                        <?php esc_html_e('Categories', 'westpace-material'); ?>
                    </h3>
                    <div class="widget-content">
                        <ul class="categories-list">
                            <?php foreach ($categories as $category) : ?>
                                <li class="category-item">
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-link">
                                        <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                        <span class="category-count"><?php echo $category->count; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Tags Widget -->
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 20,
                'hide_empty' => true,
            ));
            
            if (!empty($tags)) :
            ?>
                <section class="widget widget_tag_cloud material-card elevation-2">
                    <h3 class="widget-title">
                        <span class="material-icons-round">local_offer</span>
                        <?php esc_html_e('Popular Tags', 'westpace-material'); ?>
                    </h3>
                    <div class="widget-content">
                        <div class="tag-cloud">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                   class="tag-link" 
                                   style="font-size: <?php echo min(18, max(12, 12 + ($tag->count * 2))); ?>px;">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Contact Info Widget -->
            <section class="widget widget_contact_info material-card elevation-2">
                <h3 class="widget-title">
                    <span class="material-icons-round">contact_mail</span>
                    <?php esc_html_e('Contact Info', 'westpace-material'); ?>
                </h3>
                <div class="widget-content">
                    <div class="contact-info-list">
                        
                        <?php 
                        $phone = get_theme_mod('footer_phone_display', '+679 123 456');
                        $email = get_theme_mod('footer_email', 'info@westpace.com');
                        $address = get_theme_mod('footer_address', 'Suva, Fiji Islands');
                        
                        if ($phone) :
                        ?>
                            <div class="contact-info-item">
                                <span class="contact-icon material-icons-round">phone</span>
                                <div class="contact-details">
                                    <span class="contact-label"><?php esc_html_e('Phone', 'westpace-material'); ?></span>
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>" class="contact-value">
                                        <?php echo esc_html($phone); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($email) : ?>
                            <div class="contact-info-item">
                                <span class="contact-icon material-icons-round">email</span>
                                <div class="contact-details">
                                    <span class="contact-label"><?php esc_html_e('Email', 'westpace-material'); ?></span>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-value">
                                        <?php echo esc_html($email); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($address) : ?>
                            <div class="contact-info-item">
                                <span class="contact-icon material-icons-round">location_on</span>
                                <div class="contact-details">
                                    <span class="contact-label"><?php esc_html_e('Address', 'westpace-material'); ?></span>
                                    <span class="contact-value"><?php echo esc_html($address); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="contact-info-item">
                            <span class="contact-icon material-icons-round">schedule</span>
                            <div class="contact-details">
                                <span class="contact-label"><?php esc_html_e('Business Hours', 'westpace-material'); ?></span>
                                <span class="contact-value"><?php echo esc_html(get_theme_mod('business_hours', 'Mon-Fri: 8AM-6PM (FJT)')); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-actions">
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-sm">
                            <span class="material-icons-round">message</span>
                            <?php esc_html_e('Contact Us', 'westpace-material'); ?>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Newsletter Widget -->
            <section class="widget widget_newsletter material-card elevation-2">
                <h3 class="widget-title">
                    <span class="material-icons-round">mail</span>
                    <?php esc_html_e('Newsletter', 'westpace-material'); ?>
                </h3>
                <div class="widget-content">
                    <p class="newsletter-description">
                        <?php esc_html_e('Stay updated with our latest products, news, and special offers.', 'westpace-material'); ?>
                    </p>
                    
                    <form class="newsletter-form sidebar-newsletter" data-action="westpace_newsletter">
                        <div class="newsletter-input-group">
                            <input type="email" 
                                   name="email" 
                                   placeholder="<?php esc_attr_e('Your email address', 'westpace-material'); ?>" 
                                   required
                                   class="newsletter-input">
                            <button type="submit" class="newsletter-submit btn btn-primary btn-sm">
                                <span class="material-icons-round">send</span>
                            </button>
                        </div>
                        <p class="newsletter-message"></p>
                    </form>
                </div>
            </section>

        <?php else : ?>
            <?php dynamic_sidebar('sidebar-1'); ?>
        <?php endif; ?>
        
    </div>
</aside>

<style>
/* Sidebar Styles */
.sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
}

.sidebar-content {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
}

.widget {
    background: white;
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    border: 1px solid var(--gray-200);
    transition: all var(--transition-normal);
}

.widget:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.widget-title {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
    padding-bottom: var(--space-3);
    border-bottom: 2px solid var(--gray-100);
}

.widget-title .material-icons-round {
    color: var(--primary-600);
    font-size: 1.25rem;
}

.widget-content {
    line-height: 1.6;
}

/* Search Widget */
.widget_search .search-form {
    position: relative;
}

.widget_search .search-field {
    width: 100%;
    padding: var(--space-3) var(--space-10) var(--space-3) var(--space-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-lg);
    font-size: var(--text-sm);
    transition: border-color var(--transition-fast);
}

.widget_search .search-field:focus {
    outline: none;
    border-color: var(--primary-600);
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.widget_search .search-submit {
    position: absolute;
    right: 4px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--primary-600);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    padding: var(--space-2);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color var(--transition-fast);
}

.widget_search .search-submit:hover {
    background: var(--primary-700);
}

/* Recent Posts Widget */
.recent-posts-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-post-item {
    padding: var(--space-3) 0;
    border-bottom: 1px solid var(--gray-100);
}

.recent-post-item:last-child {
    border-bottom: none;
}

.recent-post-title {
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    margin-bottom: var(--space-2);
    line-height: 1.4;
}

.recent-post-title a {
    color: var(--gray-900);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.recent-post-title a:hover {
    color: var(--primary-600);
}

.recent-post-meta {
    display: flex;
    align-items: center;
    gap: var(--space-1);
    color: var(--gray-600);
    font-size: var(--text-xs);
}

.recent-post-meta .material-icons-round {
    font-size: 0.875rem;
}

/* Categories Widget */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-item {
    margin-bottom: var(--space-1);
}

.category-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--space-2) var(--space-3);
    color: var(--gray-700);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
    font-size: var(--text-sm);
}

.category-link:hover {
    background: var(--primary-50);
    color: var(--primary-700);
    text-decoration: none;
}

.category-count {
    background: var(--gray-100);
    color: var(--gray-600);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    min-width: 20px;
    text-align: center;
}

.category-link:hover .category-count {
    background: var(--primary-100);
    color: var(--primary-700);
}

/* Tags Widget */
.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-2);
}

.tag-link {
    display: inline-block;
    padding: var(--space-1) var(--space-3);
    background: var(--gray-100);
    color: var(--gray-700);
    text-decoration: none;
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    transition: all var(--transition-fast);
    line-height: 1.4;
}

.tag-link:hover {
    background: var(--primary-600);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

/* Contact Info Widget */
.contact-info-list {
    margin-bottom: var(--space-6);
}

.contact-info-item {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    margin-bottom: var(--space-4);
}

.contact-info-item:last-child {
    margin-bottom: 0;
}

.contact-icon {
    color: var(--primary-600);
    font-size: 1.125rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.contact-details {
    flex: 1;
}

.contact-label {
    display: block;
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    color: var(--gray-600);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: var(--space-1);
}

.contact-value {
    display: block;
    font-size: var(--text-sm);
    color: var(--gray-900);
    text-decoration: none;
    transition: color var(--transition-fast);
}

a.contact-value:hover {
    color: var(--primary-600);
}

.contact-actions {
    text-align: center;
    padding-top: var(--space-4);
    border-top: 1px solid var(--gray-100);
}

/* Newsletter Widget */
.newsletter-description {
    color: var(--gray-600);
    font-size: var(--text-sm);
    line-height: 1.5;
    margin-bottom: var(--space-4);
}

.newsletter-input-group {
    display: flex;
    gap: var(--space-2);
    margin-bottom: var(--space-3);
}

.newsletter-input {
    flex: 1;
    padding: var(--space-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    font-size: var(--text-sm);
    transition: border-color var(--transition-fast);
}

.newsletter-input:focus {
    outline: none;
    border-color: var(--primary-600);
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.newsletter-submit {
    padding: var(--space-3);
    min-width: auto;
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.newsletter-message {
    font-size: var(--text-xs);
    margin: 0;
    text-align: center;
}

.newsletter-message.success {
    color: var(--success-600);
}

.newsletter-message.error {
    color: var(--error-600);
}

/* Widget Specific Responsive */
@media (max-width: 1024px) {
    .sidebar {
        position: static;
        max-height: none;
    }
    
    .sidebar-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--space-6);
    }
}

@media (max-width: 768px) {
    .sidebar-content {
        grid-template-columns: 1fr;
    }
    
    .widget {
        padding: var(--space-4);
    }
    
    .newsletter-input-group {
        flex-direction: column;
    }
    
    .newsletter-submit {
        aspect-ratio: auto;
        padding: var(--space-3) var(--space-4);
    }
}

/* Custom Scrollbar for Sidebar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: var(--radius-full);
}

.sidebar::-webkit-scrollbar-thumb {
    background: var(--gray-400);
    border-radius: var(--radius-full);
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: var(--gray-500);
}
</style>