<?php
/**
 * Enhanced Single Post Template for Westpace Material Theme
 * Modern, readable, and engaging single post layout
 */

get_header();
?>

<div class="single-post-container">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Post Header Section -->
        <header class="post-header-section">
            <div class="container">
                <div class="post-header-content">
                    <!-- Breadcrumbs -->
                    <nav class="breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumb Navigation', 'westpace-material'); ?>">
                        <ol class="breadcrumb-list">
                            <li class="breadcrumb-item">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <span class="material-icons">home</span>
                                    <?php esc_html_e('Home', 'westpace-material'); ?>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                                    <?php esc_html_e('Blog', 'westpace-material'); ?>
                                </a>
                            </li>
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                                $main_category = $categories[0];
                            ?>
                                <li class="breadcrumb-item">
                                    <a href="<?php echo esc_url(get_category_link($main_category->term_id)); ?>">
                                        <?php echo esc_html($main_category->name); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php the_title(); ?>
                            </li>
                        </ol>
                    </nav>

                    <!-- Post Meta Info -->
                    <div class="post-meta-header">
                        <?php if (!empty($categories)) : ?>
                            <div class="post-categories">
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                       class="category-badge">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-meta-details">
                            <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                                <span class="material-icons">schedule</span>
                                <?php echo get_the_date(); ?>
                            </time>
                            
                            <div class="post-author">
                                <span class="material-icons">person</span>
                                <span><?php esc_html_e('By', 'westpace-material'); ?></span>
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" 
                                   class="author-link">
                                    <?php the_author(); ?>
                                </a>
                            </div>
                            
                            <div class="reading-time">
                                <span class="material-icons">timer</span>
                                <?php echo westpace_reading_time(); ?> <?php esc_html_e('min read', 'westpace-material'); ?>
                            </div>
                            
                            <?php if (comments_open() || get_comments_number()) : ?>
                                <div class="post-comments-count">
                                    <span class="material-icons">comment</span>
                                    <a href="#comments" class="comments-link">
                                        <?php
                                        $comment_count = get_comments_number();
                                        if ($comment_count == 0) {
                                            esc_html_e('No Comments', 'westpace-material');
                                        } elseif ($comment_count == 1) {
                                            esc_html_e('1 Comment', 'westpace-material');
                                        } else {
                                            printf(esc_html__('%s Comments', 'westpace-material'), $comment_count);
                                        }
                                        ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Post Title -->
                    <h1 class="post-title fade-in-up"><?php the_title(); ?></h1>
                    
                    <!-- Post Excerpt/Summary -->
                    <?php if (has_excerpt()) : ?>
                        <div class="post-excerpt fade-in-up">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Social Share Buttons -->
                    <div class="social-share-header fade-in-up">
                        <span class="share-label"><?php esc_html_e('Share this article:', 'westpace-material'); ?></span>
                        <div class="share-buttons">
                            <?php echo westpace_get_social_share_buttons(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-featured-image-section">
                <div class="featured-image-container">
                    <?php
                    the_post_thumbnail('blog-featured', array(
                        'class' => 'post-featured-image',
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

        <!-- Main Content Area -->
        <div class="post-content-section">
            <div class="container">
                <div class="post-layout">
                    <!-- Article Content -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-article'); ?>>
                        <div class="post-content-wrapper">
                            <div class="post-content entry-content">
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

                            <!-- Post Tags -->
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                            ?>
                                <div class="post-tags">
                                    <h3 class="tags-title">
                                        <span class="material-icons">tag</span>
                                        <?php esc_html_e('Tags:', 'westpace-material'); ?>
                                    </h3>
                                    <div class="tags-list">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                               class="tag-link"
                                               rel="tag">
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Author Bio -->
                            <?php if (get_the_author_meta('description')) : ?>
                                <div class="author-bio-section">
                                    <div class="author-bio-card">
                                        <div class="author-avatar">
                                            <?php echo get_avatar(get_the_author_meta('ID'), 80, '', get_the_author(), array('class' => 'author-avatar-img')); ?>
                                        </div>
                                        <div class="author-info">
                                            <h3 class="author-name">
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </h3>
                                            <p class="author-description">
                                                <?php echo esc_html(get_the_author_meta('description')); ?>
                                            </p>
                                            <div class="author-links">
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" 
                                                   class="btn btn-sm btn-secondary">
                                                    <?php esc_html_e('View All Posts', 'westpace-material'); ?>
                                                </a>
                                                
                                                <?php if (get_the_author_meta('user_url')) : ?>
                                                    <a href="<?php echo esc_url(get_the_author_meta('user_url')); ?>" 
                                                       class="btn btn-sm btn-ghost" 
                                                       target="_blank" 
                                                       rel="noopener">
                                                        <span class="material-icons">link</span>
                                                        <?php esc_html_e('Website', 'westpace-material'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Social Share Footer -->
                            <div class="social-share-footer">
                                <div class="share-content">
                                    <div class="share-text">
                                        <h3><?php esc_html_e('Share this article', 'westpace-material'); ?></h3>
                                        <p><?php esc_html_e('Help others discover this content by sharing it on your social networks.', 'westpace-material'); ?></p>
                                    </div>
                                    <div class="share-buttons-footer">
                                        <?php echo westpace_get_social_share_buttons(true); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Sidebar -->
                    <aside class="post-sidebar">
                        <!-- Table of Contents (if enabled) -->
                        <div class="sidebar-widget toc-widget">
                            <h3 class="widget-title">
                                <span class="material-icons">list</span>
                                <?php esc_html_e('Table of Contents', 'westpace-material'); ?>
                            </h3>
                            <div id="table-of-contents">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>

                        <!-- Related Posts -->
                        <?php
                        $related_posts = westpace_get_related_posts(get_the_ID(), 3);
                        if ($related_posts->have_posts()) :
                        ?>
                            <div class="sidebar-widget related-posts-widget">
                                <h3 class="widget-title">
                                    <span class="material-icons">article</span>
                                    <?php esc_html_e('Related Articles', 'westpace-material'); ?>
                                </h3>
                                <div class="related-posts-list">
                                    <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                        <article class="related-post-item">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="related-post-thumbnail">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('blog-grid', array('alt' => get_the_title())); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="related-post-content">
                                                <h4 class="related-post-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>
                                                <div class="related-post-meta">
                                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                                        <?php echo get_the_date(); ?>
                                                    </time>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>

                        <!-- Regular Sidebar -->
                        <?php if (is_active_sidebar('sidebar-1')) : ?>
                            <?php dynamic_sidebar('sidebar-1'); ?>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </div>

        <!-- Post Navigation -->
        <nav class="post-navigation-section" aria-label="<?php esc_attr_e('Post Navigation', 'westpace-material'); ?>">
            <div class="container">
                <div class="post-nav-wrapper">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post) : ?>
                        <div class="nav-previous">
                            <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-link">
                                <div class="nav-direction">
                                    <span class="material-icons">chevron_left</span>
                                    <span><?php esc_html_e('Previous Article', 'westpace-material'); ?></span>
                                </div>
                                <h3 class="nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></h3>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="nav-center">
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                           class="btn btn-secondary">
                            <span class="material-icons">grid_view</span>
                            <?php esc_html_e('All Articles', 'westpace-material'); ?>
                        </a>
                    </div>
                    
                    <?php if ($next_post) : ?>
                        <div class="nav-next">
                            <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-link">
                                <div class="nav-direction">
                                    <span><?php esc_html_e('Next Article', 'westpace-material'); ?></span>
                                    <span class="material-icons">chevron_right</span>
                                </div>
                                <h3 class="nav-title"><?php echo esc_html(get_the_title($next_post)); ?></h3>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- Comments Section -->
        <?php if (comments_open() || get_comments_number()) : ?>
            <section class="comments-section" id="comments">
                <div class="container">
                    <div class="comments-wrapper">
                        <?php comments_template(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</div>

<!-- Enhanced Single Post Styles -->
<style>
/* Post Header Section */
.post-header-section {
    background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
    padding: 6rem 0 4rem;
    margin-top: 80px;
}

.post-header-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
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

/* Post Meta Header */
.post-meta-header {
    margin-bottom: 2rem;
}

.post-categories {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.category-badge {
    background: #1976D2;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 1.5rem;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.category-badge:hover {
    background: #1565C0;
    transform: translateY(-2px);
}

.post-meta-details {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    color: #64748B;
    font-size: 0.875rem;
}

.post-meta-details > div {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.post-meta-details .material-icons {
    font-size: 1rem;
    color: #94A3B8;
}

.author-link,
.comments-link {
    color: #64748B;
    text-decoration: none;
    transition: color 0.3s ease;
}

.author-link:hover,
.comments-link:hover {
    color: #1976D2;
}

/* Post Title */
.post-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #0F172A;
    margin: 2rem 0 1.5rem;
    line-height: 1.1;
    letter-spacing: -0.025em;
}

/* Post Excerpt */
.post-excerpt {
    font-size: 1.25rem;
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 2rem;
}

/* Social Share Header */
.social-share-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.share-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748B;
}

.share-buttons {
    display: flex;
    gap: 0.75rem;
}

/* Featured Image */
.post-featured-image-section {
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

.post-featured-image {
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

/* Main Content */
.post-content-section {
    padding: 2rem 0 4rem;
}

.post-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 4rem;
    max-width: 1200px;
    margin: 0 auto;
}

.post-article {
    max-width: none;
}

.post-content {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #374151;
}

.post-content h2,
.post-content h3,
.post-content h4 {
    margin: 2rem 0 1rem;
    color: #0F172A;
    font-weight: 600;
}

.post-content h2 {
    font-size: 2rem;
    border-bottom: 2px solid #E2E8F0;
    padding-bottom: 0.5rem;
}

.post-content h3 {
    font-size: 1.5rem;
}

.post-content h4 {
    font-size: 1.25rem;
}

.post-content p {
    margin-bottom: 1.5rem;
}

.post-content blockquote {
    border-left: 4px solid #1976D2;
    background: #F8FAFC;
    padding: 1.5rem;
    margin: 2rem 0;
    border-radius: 0 0.5rem 0.5rem 0;
    font-style: italic;
}

.post-content img {
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Post Tags */
.post-tags {
    margin: 3rem 0;
    padding: 2rem;
    background: #F8FAFC;
    border-radius: 1rem;
}

.tags-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    color: #0F172A;
}

.tags-list {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.tag-link {
    background: white;
    color: #64748B;
    padding: 0.5rem 1rem;
    border-radius: 1.5rem;
    text-decoration: none;
    font-size: 0.875rem;
    border: 1px solid #E2E8F0;
    transition: all 0.3s ease;
}

.tag-link:hover {
    background: #1976D2;
    color: white;
    border-color: #1976D2;
}

/* Author Bio */
.author-bio-section {
    margin: 3rem 0;
}

.author-bio-card {
    display: flex;
    gap: 1.5rem;
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
}

.author-avatar-img {
    border-radius: 50%;
}

.author-name {
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.author-name a {
    color: #0F172A;
    text-decoration: none;
}

.author-name a:hover {
    color: #1976D2;
}

.author-description {
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.author-links {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Social Share Footer */
.social-share-footer {
    margin: 3rem 0;
    padding: 2rem;
    background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
    border-radius: 1.5rem;
    color: white;
    text-align: center;
}

.share-content h3 {
    color: white;
    margin-bottom: 0.5rem;
}

.share-content p {
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.share-buttons-footer {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Sidebar */
.post-sidebar {
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

.sidebar-widget .widget-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    color: #0F172A;
}

/* Table of Contents */
#table-of-contents {
    font-size: 0.875rem;
}

#table-of-contents ul {
    list-style: none;
    padding-left: 1rem;
}

#table-of-contents a {
    color: #64748B;
    text-decoration: none;
    padding: 0.25rem 0;
    display: block;
    transition: color 0.3s ease;
}

#table-of-contents a:hover,
#table-of-contents a.active {
    color: #1976D2;
}

/* Related Posts */
.related-posts-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.related-post-item {
    display: flex;
    gap: 1rem;
}

.related-post-thumbnail {
    flex-shrink: 0;
    width: 80px;
    height: 60px;
    border-radius: 0.5rem;
    overflow: hidden;
}

.related-post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-post-title {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.related-post-title a {
    color: #374151;
    text-decoration: none;
    line-height: 1.3;
}

.related-post-title a:hover {
    color: #1976D2;
}

.related-post-meta {
    font-size: 0.75rem;
    color: #94A3B8;
}

/* Post Navigation */
.post-navigation-section {
    background: #F8FAFC;
    padding: 3rem 0;
    border-top: 1px solid #E2E8F0;
}

.post-nav-wrapper {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 2rem;
    align-items: center;
}

.nav-previous,
.nav-next {
    min-height: 100px;
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
    height: 100%;
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
.comments-section {
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
    .post-layout {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .post-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .post-header-section {
        padding: 4rem 0 3rem;
    }
    
    .post-meta-details {
        flex-direction: column;
        gap: 1rem;
    }
    
    .post-title {
        font-size: clamp(2rem, 8vw, 3rem);
    }
    
    .author-bio-card {
        flex-direction: column;
        text-align: center;
    }
    
    .post-nav-wrapper {
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
    .post-content {
        font-size: 1rem;
    }
    
    .related-post-item {
        flex-direction: column;
    }
    
    .related-post-thumbnail {
        width: 100%;
        height: 120px;
    }
}
</style>

<?php
// Helper functions for single post template

// Calculate reading time
function westpace_reading_time($post_id = null) {
    $post = get_post($post_id);
    $word_count = str_word_count(wp_strip_all_tags($post->post_content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return $reading_time;
}

// Get social share buttons
function westpace_get_social_share_buttons($large = false) {
    $url = get_permalink();
    $title = get_the_title();
    $size_class = $large ? 'share-btn-lg' : 'share-btn';
    
    $buttons = array(
        'facebook' => array(
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url),
            'icon' => 'fab fa-facebook-f',
            'label' => __('Facebook', 'westpace-material')
        ),
        'twitter' => array(
            'url' => 'https://twitter.com/intent/tweet?url=' . urlencode($url) . '&text=' . urlencode($title),
            'icon' => 'fab fa-twitter',
            'label' => __('Twitter', 'westpace-material')
        ),
        'linkedin' => array(
            'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($url),
            'icon' => 'fab fa-linkedin-in',
            'label' => __('LinkedIn', 'westpace-material')
        ),
        'email' => array(
            'url' => 'mailto:?subject=' . urlencode($title) . '&body=' . urlencode($url),
            'icon' => 'fas fa-envelope',
            'label' => __('Email', 'westpace-material')
        ),
    );
    
    $output = '';
    foreach ($buttons as $network => $data) {
        $output .= sprintf(
            '<a href="%s" class="share-btn %s %s" target="_blank" rel="noopener" aria-label="%s"><i class="%s"></i></a>',
            esc_url($data['url']),
            esc_attr($size_class),
            esc_attr($network),
            esc_attr($data['label']),
            esc_attr($data['icon'])
        );
    }
    
    return $output;
}

// Get related posts
function westpace_get_related_posts($post_id, $limit = 3) {
    $categories = get_the_category($post_id);
    $category_ids = array();
    
    if ($categories) {
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
    }
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post__not_in' => array($post_id),
        'orderby' => 'rand',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        )
    );
    
    if (!empty($category_ids)) {
        $args['category__in'] = $category_ids;
    }
    
    return new WP_Query($args);
}

get_footer();
?>