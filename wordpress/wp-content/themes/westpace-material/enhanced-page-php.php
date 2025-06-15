<?php
/**
 * Enhanced Page Template for Westpace Material Theme
 * Modern, flexible page layout with advanced content formatting
 */

get_header();
?>

<div class="page-container">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Header Section -->
        <header class="page-header-section">
            <div class="container">
                <div class="page-header-content">
                    <!-- Breadcrumbs -->
                    <nav class="breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumb Navigation', 'westpace-material'); ?>">
                        <ol class="breadcrumb-list">
                            <li class="breadcrumb-item">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <span class="material-icons">home</span>
                                    <?php esc_html_e('Home', 'westpace-material'); ?>
                                </a>
                            </li>
                            
                            <?php
                            // Add parent pages to breadcrumb
                            $ancestors = get_post_ancestors(get_the_ID());
                            if ($ancestors) {
                                $ancestors = array_reverse($ancestors);
                                foreach ($ancestors as $ancestor) :
                            ?>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo esc_url(get_permalink($ancestor)); ?>">
                                        <?php echo esc_html(get_the_title($ancestor)); ?>
                                    </a>
                                </li>
                            <?php endforeach; 
                            } ?>
                            
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php the_title(); ?>
                            </li>
                        </ol>
                    </nav>

                    <!-- Page Title -->
                    <h1 class="page-title fade-in-up"><?php the_title(); ?></h1>
                    
                    <!-- Page Excerpt/Description -->
                    <?php if (has_excerpt()) : ?>
                        <div class="page-excerpt fade-in-up" style="animation-delay: 0.2s;">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Page Meta (Last Updated, etc.) -->
                    <div class="page-meta fade-in-up" style="animation-delay: 0.3s;">
                        <div class="meta-item">
                            <span class="material-icons">update</span>
                            <span><?php esc_html_e('Last updated:', 'westpace-material'); ?></span>
                            <time datetime="<?php echo get_the_modified_date('c'); ?>">
                                <?php echo get_the_modified_date(); ?>
                            </time>
                        </div>
                        
                        <?php if (get_the_author_meta('display_name')) : ?>
                            <div class="meta-item">
                                <span class="material-icons">person</span>
                                <span><?php esc_html_e('By:', 'westpace-material'); ?></span>
                                <span><?php the_author(); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $reading_time = westpace_reading_time();
                        if ($reading_time > 1) :
                        ?>
                            <div class="meta-item">
                                <span class="material-icons">timer</span>
                                <span><?php echo $reading_time; ?> <?php esc_html_e('min read', 'westpace-material'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail() && !is_page_template('page-contact.php')) : ?>
            <div class="page-featured-image-section">
                <div class="featured-image-container">
                    <?php
                    the_post_thumbnail('hero-banner', array(
                        'class' => 'page-featured-image',
                        'alt' => get_the_title(),
                        'loading' => 'eager'
                    ));
                    ?>
                    
                    <!-- Image Caption -->
                    <?php
                    $image_caption = get_the_post_thumbnail_caption();
                    if ($image_caption) :
                    ?>
                        <div class="image-caption">
                            <?php echo esc_html($image_caption); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Page Content Section -->
        <section class="page-content-section">
            <div class="container">
                <div class="page-layout <?php echo is_active_sidebar('sidebar-1') ? 'has-sidebar' : 'full-width'; ?>">
                    <!-- Main Content -->
                    <article id="page-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                        <div class="page-content-wrapper">
                            <!-- Table of Contents (for long pages) -->
                            <?php if (get_post_meta(get_the_ID(), '_westpace_show_toc', true) === 'yes') : ?>
                                <div class="table-of-contents-wrapper">
                                    <div class="toc-card">
                                        <h3 class="toc-title">
                                            <span class="material-icons">list</span>
                                            <?php esc_html_e('Table of Contents', 'westpace-material'); ?>
                                        </h3>
                                        <div id="table-of-contents">
                                            <!-- Generated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Page Content -->
                            <div class="page-content entry-content">
                                <?php
                                the_content();
                                
                                wp_link_pages(array(
                                    'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'westpace-material') . '</span>',
                                    'after'       => '</div>',
                                    'link_before' => '<span class="page-link">',
                                    'link_after'  => '</span>',
                                ));
                                ?>
                            </div>

                            <!-- Page Footer Content -->
                            <div class="page-footer-content">
                                <!-- Child Pages (if any) -->
                                <?php
                                $child_pages = get_children(array(
                                    'post_parent' => get_the_ID(),
                                    'post_type' => 'page',
                                    'post_status' => 'publish',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC'
                                ));
                                
                                if ($child_pages) :
                                ?>
                                    <div class="child-pages-section">
                                        <h3 class="child-pages-title">
                                            <span class="material-icons">pages</span>
                                            <?php esc_html_e('Related Pages', 'westpace-material'); ?>
                                        </h3>
                                        <div class="child-pages-grid">
                                            <?php foreach ($child_pages as $child) : ?>
                                                <div class="child-page-card">
                                                    <?php if (has_post_thumbnail($child->ID)) : ?>
                                                        <div class="child-page-thumbnail">
                                                            <a href="<?php echo esc_url(get_permalink($child->ID)); ?>">
                                                                <?php echo get_the_post_thumbnail($child->ID, 'blog-grid', array('alt' => $child->post_title)); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="child-page-content">
                                                        <h4 class="child-page-title">
                                                            <a href="<?php echo esc_url(get_permalink($child->ID)); ?>">
                                                                <?php echo esc_html($child->post_title); ?>
                                                            </a>
                                                        </h4>
                                                        
                                                        <?php if ($child->post_excerpt) : ?>
                                                            <p class="child-page-excerpt">
                                                                <?php echo esc_html($child->post_excerpt); ?>
                                                            </p>
                                                        <?php else : ?>
                                                            <p class="child-page-excerpt">
                                                                <?php echo esc_html(wp_trim_words($child->post_content, 20)); ?>
                                                            </p>
                                                        <?php endif; ?>
                                                        
                                                        <a href="<?php echo esc_url(get_permalink($child->ID)); ?>" 
                                                           class="child-page-link">
                                                            <?php esc_html_e('Learn More', 'westpace-material'); ?>
                                                            <span class="material-icons">arrow_forward</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Contact CTA (for non-contact pages) -->
                                <?php if (!is_page_template('page-contact.php') && get_post_meta(get_the_ID(), '_westpace_show_contact_cta', true) !== 'no') : ?>
                                    <div class="page-contact-cta">
                                        <div class="cta-content">
                                            <div class="cta-icon">
                                                <span class="material-icons">contact_support</span>
                                            </div>
                                            <div class="cta-text">
                                                <h3><?php esc_html_e('Have Questions?', 'westpace-material'); ?></h3>
                                                <p><?php esc_html_e('Our team is here to help you with any inquiries about our services and products.', 'westpace-material'); ?></p>
                                            </div>
                                            <div class="cta-actions">
                                                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                                                    <span class="material-icons">message</span>
                                                    <?php esc_html_e('Contact Us', 'westpace-material'); ?>
                                                </a>
                                                <a href="tel:<?php echo esc_attr(get_theme_mod('footer_phone', '+679123456')); ?>" 
                                                   class="btn btn-secondary">
                                                    <span class="material-icons">phone</span>
                                                    <?php esc_html_e('Call Now', 'westpace-material'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>

                    <!-- Sidebar (if active and not full-width page) -->
                    <?php if (is_active_sidebar('sidebar-1') && get_post_meta(get_the_ID(), '_westpace_page_layout', true) !== 'full-width') : ?>
                        <aside class="page-sidebar">
                            <!-- Page Navigation (if parent/children exist) -->
                            <?php
                            $parent_id = wp_get_post_parent_id(get_the_ID());
                            $siblings = array();
                            
                            if ($parent_id) {
                                $siblings = get_children(array(
                                    'post_parent' => $parent_id,
                                    'post_type' => 'page',
                                    'post_status' => 'publish',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC'
                                ));
                            } elseif ($child_pages) {
                                $siblings = $child_pages;
                            }
                            
                            if ($siblings || $parent_id) :
                            ?>
                                <div class="sidebar-widget page-navigation-widget">
                                    <h3 class="widget-title">
                                        <span class="material-icons">menu_book</span>
                                        <?php esc_html_e('Page Navigation', 'westpace-material'); ?>
                                    </h3>
                                    
                                    <nav class="page-nav-menu">
                                        <?php if ($parent_id) : ?>
                                            <a href="<?php echo esc_url(get_permalink($parent_id)); ?>" 
                                               class="page-nav-item parent-page">
                                                <span class="material-icons">arrow_upward</span>
                                                <span class="nav-label"><?php echo esc_html(get_the_title($parent_id)); ?></span>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($siblings) : ?>
                                            <?php foreach ($siblings as $sibling) : ?>
                                                <a href="<?php echo esc_url(get_permalink($sibling->ID)); ?>" 
                                                   class="page-nav-item <?php echo ($sibling->ID === get_the_ID()) ? 'current' : ''; ?>">
                                                    <span class="nav-label"><?php echo esc_html($sibling->post_title); ?></span>
                                                    <?php if ($sibling->ID === get_the_ID()) : ?>
                                                        <span class="material-icons">arrow_forward_ios</span>
                                                    <?php endif; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                            <?php endif; ?>

                            <!-- Quick Actions Widget -->
                            <div class="sidebar-widget quick-actions-widget">
                                <h3 class="widget-title">
                                    <span class="material-icons">flash_on</span>
                                    <?php esc_html_e('Quick Actions', 'westpace-material'); ?>
                                </h3>
                                
                                <div class="quick-actions-list">
                                    <a href="<?php echo esc_url(home_url('/quote')); ?>" class="quick-action-item">
                                        <span class="material-icons">request_quote</span>
                                        <span class="action-text">
                                            <strong><?php esc_html_e('Get Quote', 'westpace-material'); ?></strong>
                                            <small><?php esc_html_e('Custom pricing for your project', 'westpace-material'); ?></small>
                                        </span>
                                    </a>
                                    
                                    <?php if (class_exists('WooCommerce')) : ?>
                                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="quick-action-item">
                                            <span class="material-icons">store</span>
                                            <span class="action-text">
                                                <strong><?php esc_html_e('Browse Products', 'westpace-material'); ?></strong>
                                                <small><?php esc_html_e('View our product catalog', 'westpace-material'); ?></small>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo esc_url(home_url('/about')); ?>" class="quick-action-item">
                                        <span class="material-icons">info</span>
                                        <span class="action-text">
                                            <strong><?php esc_html_e('About Us', 'westpace-material'); ?></strong>
                                            <small><?php esc_html_e('Learn about our company', 'westpace-material'); ?></small>
                                        </span>
                                    </a>
                                    
                                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="quick-action-item">
                                        <span class="material-icons">support_agent</span>
                                        <span class="action-text">
                                            <strong><?php esc_html_e('Contact Support', 'westpace-material'); ?></strong>
                                            <small><?php esc_html_e('Get help from our team', 'westpace-material'); ?></small>
                                        </span>
                                    </a>
                                </div>
                            </div>

                            <!-- Regular Sidebar Widgets -->
                            <?php dynamic_sidebar('sidebar-1'); ?>
                        </aside>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Page Navigation (Previous/Next) -->
        <?php
        $prev_page = get_previous_post(false, '', 'page');
        $next_page = get_next_post(false, '', 'page');
        
        if ($prev_page || $next_page) :
        ?>
            <nav class="page-navigation-section" aria-label="<?php esc_attr_e('Page Navigation', 'westpace-material'); ?>">
                <div class="container">
                    <div class="page-nav-wrapper">
                        <?php if ($prev_page) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_page)); ?>" class="nav-link">
                                    <div class="nav-direction">
                                        <span class="material-icons">chevron_left</span>
                                        <span><?php esc_html_e('Previous Page', 'westpace-material'); ?></span>
                                    </div>
                                    <h3 class="nav-title"><?php echo esc_html(get_the_title($prev_page)); ?></h3>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="nav-center">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-secondary">
                                <span class="material-icons">home</span>
                                <?php esc_html_e('Home', 'westpace-material'); ?>
                            </a>
                        </div>
                        
                        <?php if ($next_page) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_page)); ?>" class="nav-link">
                                    <div class="nav-direction">
                                        <span><?php esc_html_e('Next Page', 'westpace-material'); ?></span>
                                        <span class="material-icons">chevron_right</span>
                                    </div>
                                    <h3 class="nav-title"><?php echo esc_html(get_the_title($next_page)); ?></h3>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        <?php endif; ?>

        <!-- Comments Section (if enabled for pages) -->
        <?php if (comments_open() || get_comments_number()) : ?>
            <section class="page-comments-section">
                <div class="container">
                    <div class="comments-wrapper">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</div>

<!-- Enhanced Page Styles -->
<style>
/* Page Header */
.page-header-section {
    background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
    padding: 6rem 0 4rem;
    margin-top: 80px;
    text-align: center;
}

.page-header-content {
    max-width: 800px;
    margin: 0 auto;
}

/* Breadcrumbs */
.breadcrumbs {
    margin-bottom: 2rem;
}

.breadcrumb-list {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-item:not(:last-child)::after {
    content: '/';
    margin: 0 0.75rem;
    color: #94A3B8;
}

.breadcrumb-item a {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #64748B;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #1976D2;
}

.breadcrumb-item.active {
    color: #1976D2;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Page Title */
.page-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #0F172A;
    margin: 2rem 0 1.5rem;
    line-height: 1.1;
    letter-spacing: -0.025em;
}

/* Page Excerpt */
.page-excerpt {
    font-size: 1.25rem;
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* Page Meta */
.page-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    color: #64748B;
    font-size: 0.875rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-item .material-icons {
    font-size: 1rem;
    color: #94A3B8;
}

/* Featured Image */
.page-featured-image-section {
    margin-bottom: 4rem;
}

.featured-image-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    border-radius: 2rem;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.page-featured-image {
    width: 100%;
    height: auto;
    display: block;
}

.image-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    color: white;
    padding: 2rem;
    font-size: 0.875rem;
    font-style: italic;
}

/* Page Layout */
.page-content-section {
    padding: 2rem 0 4rem;
}

.page-layout {
    display: grid;
    gap: 4rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-layout.has-sidebar {
    grid-template-columns: 1fr 300px;
}

.page-layout.full-width {
    grid-template-columns: 1fr;
    max-width: 900px;
}

/* Table of Contents */
.table-of-contents-wrapper {
    margin-bottom: 3rem;
}

.toc-card {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 1rem;
    padding: 1.5rem;
}

.toc-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    color: #0F172A;
}

#table-of-contents ul {
    list-style: none;
    padding-left: 1rem;
    margin: 0.5rem 0;
}

#table-of-contents a {
    color: #64748B;
    text-decoration: none;
    padding: 0.25rem 0;
    display: block;
    transition: color 0.3s ease;
    font-size: 0.875rem;
}

#table-of-contents a:hover,
#table-of-contents a.active {
    color: #1976D2;
}

/* Page Content */
.page-content {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #374151;
}

.page-content h2,
.page-content h3,
.page-content h4 {
    margin: 2rem 0 1rem;
    color: #0F172A;
    font-weight: 600;
}

.page-content h2 {
    font-size: 2rem;
    border-bottom: 2px solid #E2E8F0;
    padding-bottom: 0.5rem;
}

.page-content h3 {
    font-size: 1.5rem;
}

.page-content h4 {
    font-size: 1.25rem;
}

.page-content p {
    margin-bottom: 1.5rem;
}

.page-content blockquote {
    border-left: 4px solid #1976D2;
    background: #F8FAFC;
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 0 0.5rem 0.5rem 0;
    font-style: italic;
}

.page-content img {
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.page-content ul,
.page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.page-content li {
    margin-bottom: 0.5rem;
}

/* Child Pages */
.child-pages-section {
    margin: 3rem 0;
    padding: 2rem;
    background: #F8FAFC;
    border-radius: 1.5rem;
}

.child-pages-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.5rem;
    color: #0F172A;
}

.child-pages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.child-page-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    transition: all 0.3s ease;
}

.child-page-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.child-page-thumbnail {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.child-page-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.child-page-card:hover .child-page-thumbnail img {
    transform: scale(1.05);
}

.child-page-content {
    padding: 1.5rem;
}

.child-page-title {
    margin-bottom: 0.75rem;
    font-size: 1.125rem;
}

.child-page-title a {
    color: #0F172A;
    text-decoration: none;
}

.child-page-title a:hover {
    color: #1976D2;
}

.child-page-excerpt {
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.child-page-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #1976D2;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.child-page-link:hover {
    color: #1565C0;
    transform: translateX(4px);
}

/* Contact CTA */
.page-contact-cta {
    margin: 3rem 0;
    background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
    border-radius: 1.5rem;
    color: white;
    overflow: hidden;
}

.cta-content {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 2rem;
    align-items: center;
    padding: 2rem;
}

.cta-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.cta-text h3 {
    color: white;
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
}

.cta-text p {
    opacity: 0.9;
    margin: 0;
}

.cta-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Sidebar */
.page-sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.sidebar-widget {
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    margin-bottom: 2rem;
}

.widget-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #0F172A;
}

/* Page Navigation Widget */
.page-nav-menu {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.page-nav-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    color: #64748B;
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.page-nav-item:hover,
.page-nav-item.current {
    background: #F1F5F9;
    color: #1976D2;
}

.page-nav-item.parent-page {
    border-bottom: 1px solid #E2E8F0;
    margin-bottom: 0.5rem;
    padding-bottom: 1rem;
}

/* Quick Actions Widget */
.quick-actions-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 0.75rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.quick-action-item:hover {
    background: #F1F5F9;
    border-color: #1976D2;
    transform: translateY(-2px);
}

.quick-action-item .material-icons {
    color: #1976D2;
    font-size: 1.5rem;
}

.action-text {
    flex: 1;
}

.action-text strong {
    display: block;
    color: #0F172A;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.action-text small {
    color: #64748B;
    font-size: 0.75rem;
}

/* Page Navigation Section */
.page-navigation-section {
    background: #F8FAFC;
    padding: 3rem 0;
    border-top: 1px solid #E2E8F0;
}

.page-nav-wrapper {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 2rem;
    align-items: center;
}

.nav-link {
    display: block;
    text-decoration: none;
    padding: 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    transition: all 0.3s ease;
    min-height: 100px;
}

.nav-link:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.nav-direction {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748B;
    margin-bottom: 0.5rem;
}

.nav-title {
    color: #0F172A;
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.3;
    margin: 0;
}

.nav-next {
    text-align: right;
}

.nav-next .nav-direction {
    justify-content: flex-end;
}

/* Comments Section */
.page-comments-section {
    background: white;
    padding: 4rem 0;
    border-top: 1px solid #E2E8F0;
}

.comments-wrapper {
    max-width: 800px;
    margin: 0 auto;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .page-layout.has-sidebar {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .page-sidebar {
        position: static;
    }
    
    .cta-content {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .page-header-section {
        padding: 4rem 0 3rem;
    }
    
    .page-meta {
        flex-direction: column;
        gap: 1rem;
    }
    
    .child-pages-grid {
        grid-template-columns: 1fr;
    }
    
    .page-nav-wrapper {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .nav-center {
        order: -1;
        text-align: center;
    }
    
    .nav-next {
        text-align: left;
    }
    
    .nav-next .nav-direction {
        justify-content: flex-start;
    }
}

@media (max-width: 480px) {
    .page-content {
        font-size: 1rem;
    }
    
    .quick-action-item {
        flex-direction: column;
        text-align: center;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

<?php
// Add Table of Contents generation script
if (get_post_meta(get_the_ID(), '_westpace_show_toc', true) === 'yes') :
    wp_add_inline_script('westpace-theme-js', '
    document.addEventListener("DOMContentLoaded", function() {
        const tocContainer = document.getElementById("table-of-contents");
        if (!tocContainer) return;
        
        const headings = document.querySelectorAll(".page-content h2, .page-content h3, .page-content h4");
        if (headings.length === 0) {
            tocContainer.innerHTML = "<p style=\"color: #94A3B8; font-style: italic;\">No headings found</p>";
            return;
        }
        
        let tocHTML = "<ul>";
        let currentLevel = 2;
        
        headings.forEach((heading, index) => {
            const level = parseInt(heading.tagName.charAt(1));
            const id = "heading-" + index;
            heading.id = id;
            
            if (level > currentLevel) {
                tocHTML += "<ul>";
            } else if (level < currentLevel) {
                tocHTML += "</ul>";
            }
            
            tocHTML += `<li><a href="#${id}">${heading.textContent}</a></li>`;
            currentLevel = level;
        });
        
        tocHTML += "</ul>";
        tocContainer.innerHTML = tocHTML;
        
        // Add smooth scrolling and active state
        const tocLinks = tocContainer.querySelectorAll("a");
        tocLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute("href"));
                if (target) {
                    target.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            });
        });
        
        // Highlight current section
        window.addEventListener("scroll", function() {
            let current = "";
            headings.forEach(heading => {
                const rect = heading.getBoundingClientRect();
                if (rect.top <= 100) {
                    current = heading.id;
                }
            });
            
            tocLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href") === "#" + current) {
                    link.classList.add("active");
                }
            });
        });
    });
    ');
endif;

get_footer();
?>