<?php
/**
 * Enhanced Blog Index Template for Westpace Material Theme
 * Modern, grid-based blog layout with advanced filtering and search
 */

get_header();
?>

<div class="blog-page-container">
    <!-- Blog Header Section -->
    <header class="blog-header-section">
        <div class="container">
            <div class="blog-header-content">
                <h1 class="blog-title fade-in-up">
                    <?php
                    if (is_home() && !is_front_page()) {
                        echo esc_html(get_the_title(get_option('page_for_posts')));
                    } elseif (is_category()) {
                        printf(__('Category: %s', 'westpace-material'), single_cat_title('', false));
                    } elseif (is_tag()) {
                        printf(__('Tag: %s', 'westpace-material'), single_tag_title('', false));
                    } elseif (is_author()) {
                        printf(__('Author: %s', 'westpace-material'), get_the_author());
                    } elseif (is_search()) {
                        printf(__('Search Results for: %s', 'westpace-material'), get_search_query());
                    } elseif (is_date()) {
                        echo __('Archive', 'westpace-material');
                    } else {
                        echo __('Latest Articles', 'westpace-material');
                    }
                    ?>
                </h1>
                
                <?php if (is_home() && !is_front_page() && get_the_content(get_option('page_for_posts'))) : ?>
                    <div class="blog-description fade-in-up" style="animation-delay: 0.2s;">
                        <?php echo wp_kses_post(get_post_field('post_content', get_option('page_for_posts'))); ?>
                    </div>
                <?php elseif (is_category() && category_description()) : ?>
                    <div class="blog-description fade-in-up" style="animation-delay: 0.2s;">
                        <?php echo wp_kses_post(category_description()); ?>
                    </div>
                <?php elseif (is_tag() && tag_description()) : ?>
                    <div class="blog-description fade-in-up" style="animation-delay: 0.2s;">
                        <?php echo wp_kses_post(tag_description()); ?>
                    </div>
                <?php else : ?>
                    <div class="blog-description fade-in-up" style="animation-delay: 0.2s;">
                        <p><?php esc_html_e('Discover insights, industry news, and expert tips from West Pace Apparels. Stay informed about the latest trends in garment manufacturing and textile innovation.', 'westpace-material'); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Blog Statistics -->
                <div class="blog-stats fade-in-up" style="animation-delay: 0.4s;">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo wp_count_posts()->publish; ?></span>
                        <span class="stat-label"><?php esc_html_e('Articles Published', 'westpace-material'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo wp_count_terms('category', array('hide_empty' => true)); ?></span>
                        <span class="stat-label"><?php esc_html_e('Categories', 'westpace-material'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo wp_count_comments()->approved; ?></span>
                        <span class="stat-label"><?php esc_html_e('Comments', 'westpace-material'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Blog Filters and Search -->
    <section class="blog-filters-section">
        <div class="container">
            <div class="blog-filters-wrapper">
                <!-- Search Form -->
                <div class="blog-search-form">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-group">
                            <label for="blog-search" class="sr-only"><?php esc_html_e('Search articles', 'westpace-material'); ?></label>
                            <input type="search" 
                                   id="blog-search"
                                   class="search-input" 
                                   placeholder="<?php esc_attr_e('Search articles...', 'westpace-material'); ?>" 
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s"
                                   autocomplete="off">
                            <button type="submit" class="search-btn">
                                <span class="material-icons">search</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Category Filter -->
                <div class="category-filter">
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="category-filter-toggle">
                            <span class="material-icons">category</span>
                            <span class="filter-text"><?php esc_html_e('Categories', 'westpace-material'); ?></span>
                            <span class="material-icons">expand_more</span>
                        </button>
                        <div class="filter-dropdown-menu" id="category-dropdown">
                            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                               class="filter-option <?php echo !is_category() ? 'active' : ''; ?>">
                                <?php esc_html_e('All Categories', 'westpace-material'); ?>
                            </a>
                            <?php
                            $categories = get_categories(array('hide_empty' => true));
                            foreach ($categories as $category) :
                                $is_active = is_category($category->term_id) ? 'active' : '';
                            ?>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                   class="filter-option <?php echo $is_active; ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="category-count">(<?php echo $category->count; ?>)</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="sort-filter">
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="sort-filter-toggle">
                            <span class="material-icons">sort</span>
                            <span class="filter-text"><?php esc_html_e('Sort By', 'westpace-material'); ?></span>
                            <span class="material-icons">expand_more</span>
                        </button>
                        <div class="filter-dropdown-menu" id="sort-dropdown">
                            <a href="<?php echo add_query_arg('orderby', 'date', get_pagenum_link()); ?>" 
                               class="filter-option <?php echo (!isset($_GET['orderby']) || $_GET['orderby'] === 'date') ? 'active' : ''; ?>">
                                <?php esc_html_e('Latest First', 'westpace-material'); ?>
                            </a>
                            <a href="<?php echo add_query_arg('orderby', 'title', get_pagenum_link()); ?>" 
                               class="filter-option <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'title') ? 'active' : ''; ?>">
                                <?php esc_html_e('Alphabetical', 'westpace-material'); ?>
                            </a>
                            <a href="<?php echo add_query_arg('orderby', 'comment_count', get_pagenum_link()); ?>" 
                               class="filter-option <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'comment_count') ? 'active' : ''; ?>">
                                <?php esc_html_e('Most Discussed', 'westpace-material'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- View Toggle -->
                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid" aria-label="<?php esc_attr_e('Grid View', 'westpace-material'); ?>">
                        <span class="material-icons">grid_view</span>
                    </button>
                    <button class="view-btn" data-view="list" aria-label="<?php esc_attr_e('List View', 'westpace-material'); ?>">
                        <span class="material-icons">view_list</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content Section -->
    <section class="blog-content-section">
        <div class="container">
            <div class="blog-layout">
                <!-- Main Content Area -->
                <main class="blog-main-content">
                    <?php if (have_posts()) : ?>
                        <!-- Featured Post (only on first page of home) -->
                        <?php if (is_home() && !is_paged() && !is_search()) : ?>
                            <?php
                            // Get featured post
                            $featured_args = array(
                                'posts_per_page' => 1,
                                'meta_query' => array(
                                    array(
                                        'key' => '_thumbnail_id',
                                        'compare' => 'EXISTS'
                                    )
                                ),
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            $featured_query = new WP_Query($featured_args);
                            
                            if ($featured_query->have_posts()) :
                                $featured_query->the_post();
                                $featured_post_id = get_the_ID();
                            ?>
                                <article class="featured-post-card fade-in-up">
                                    <div class="featured-post-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('hero-banner', array('alt' => get_the_title())); ?>
                                        </a>
                                        <div class="featured-badge">
                                            <span class="material-icons">star</span>
                                            <?php esc_html_e('Featured', 'westpace-material'); ?>
                                        </div>
                                    </div>
                                    <div class="featured-post-content">
                                        <div class="post-categories">
                                            <?php
                                            $categories = get_the_category();
                                            if ($categories) :
                                                foreach (array_slice($categories, 0, 2) as $category) :
                                            ?>
                                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                                   class="category-badge">
                                                    <?php echo esc_html($category->name); ?>
                                                </a>
                                            <?php 
                                                endforeach;
                                            endif; 
                                            ?>
                                        </div>
                                        
                                        <h2 class="featured-post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <div class="post-excerpt">
                                            <?php echo westpace_custom_excerpt(25); ?>
                                        </div>
                                        
                                        <div class="post-meta">
                                            <div class="meta-item">
                                                <span class="material-icons">schedule</span>
                                                <time datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date(); ?>
                                                </time>
                                            </div>
                                            <div class="meta-item">
                                                <span class="material-icons">person</span>
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </div>
                                            <div class="meta-item">
                                                <span class="material-icons">timer</span>
                                                <?php echo westpace_reading_time(); ?> <?php esc_html_e('min read', 'westpace-material'); ?>
                                            </div>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <?php esc_html_e('Read Full Article', 'westpace-material'); ?>
                                            <span class="material-icons">arrow_forward</span>
                                        </a>
                                    </div>
                                </article>
                                <?php
                                wp_reset_postdata();
                            endif;
                            ?>
                        <?php endif; ?>

                        <!-- Posts Grid -->
                        <div class="posts-grid" id="posts-grid">
                            <?php
                            $post_count = 0;
                            $exclude_featured = isset($featured_post_id) ? array($featured_post_id) : array();
                            
                            while (have_posts()) :
                                the_post();
                                
                                // Skip featured post if it's already shown
                                if (in_array(get_the_ID(), $exclude_featured)) {
                                    continue;
                                }
                                
                                $post_count++;
                                $animation_delay = $post_count * 0.1;
                            ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card fade-in-up'); ?> style="animation-delay: <?php echo esc_attr($animation_delay); ?>s;">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('blog-grid', array('alt' => get_the_title())); ?>
                                            </a>
                                            
                                            <!-- Reading Time Overlay -->
                                            <div class="reading-time-overlay">
                                                <span class="material-icons">timer</span>
                                                <?php echo westpace_reading_time(); ?> min
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content">
                                        <!-- Categories -->
                                        <?php
                                        $categories = get_the_category();
                                        if ($categories) :
                                        ?>
                                            <div class="post-categories">
                                                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" 
                                                   class="category-link">
                                                    <?php echo esc_html($categories[0]->name); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Title -->
                                        <h2 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <!-- Excerpt -->
                                        <div class="post-excerpt">
                                            <?php echo westpace_custom_excerpt(20); ?>
                                        </div>
                                        
                                        <!-- Meta -->
                                        <div class="post-meta">
                                            <div class="meta-left">
                                                <div class="post-author">
                                                    <?php echo get_avatar(get_the_author_meta('ID'), 32, '', get_the_author(), array('class' => 'author-avatar')); ?>
                                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                        <?php the_author(); ?>
                                                    </a>
                                                </div>
                                                <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date('M j, Y'); ?>
                                                </time>
                                            </div>
                                            
                                            <div class="meta-right">
                                                <?php if (comments_open() || get_comments_number()) : ?>
                                                    <div class="post-comments">
                                                        <span class="material-icons">comment</span>
                                                        <span><?php comments_number('0', '1', '%'); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Read More Button -->
                                        <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                            <?php esc_html_e('Read More', 'westpace-material'); ?>
                                            <span class="material-icons">arrow_forward</span>
                                        </a>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <nav class="blog-pagination" aria-label="<?php esc_attr_e('Blog Pagination', 'westpace-material'); ?>">
                            <?php
                            echo paginate_links(array(
                                'prev_text' => '<span class="material-icons">chevron_left</span> ' . __('Previous', 'westpace-material'),
                                'next_text' => __('Next', 'westpace-material') . ' <span class="material-icons">chevron_right</span>',
                                'type' => 'list',
                                'end_size' => 2,
                                'mid_size' => 1,
                            ));
                            ?>
                        </nav>

                    <?php else : ?>
                        <!-- No Posts Found -->
                        <div class="no-posts-found">
                            <div class="no-posts-content">
                                <div class="no-posts-icon">
                                    <span class="material-icons">search_off</span>
                                </div>
                                <h2><?php esc_html_e('No articles found', 'westpace-material'); ?></h2>
                                <p>
                                    <?php if (is_search()) : ?>
                                        <?php esc_html_e('Sorry, no articles matched your search criteria. Please try a different search term.', 'westpace-material'); ?>
                                    <?php else : ?>
                                        <?php esc_html_e('It looks like there are no articles to display at the moment. Please check back later!', 'westpace-material'); ?>
                                    <?php endif; ?>
                                </p>
                                <div class="no-posts-actions">
                                    <?php if (is_search()) : ?>
                                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                                           class="btn btn-primary">
                                            <?php esc_html_e('View All Articles', 'westpace-material'); ?>
                                        </a>
                                        <button class="btn btn-secondary" onclick="document.getElementById('blog-search').focus();">
                                            <?php esc_html_e('Try Another Search', 'westpace-material'); ?>
                                        </button>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                                            <?php esc_html_e('Back to Homepage', 'westpace-material'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </main>

                <!-- Sidebar -->
                <aside class="blog-sidebar">
                    <!-- Popular Posts -->
                    <div class="sidebar-widget popular-posts-widget">
                        <h3 class="widget-title">
                            <span class="material-icons">trending_up</span>
                            <?php esc_html_e('Popular Articles', 'westpace-material'); ?>
                        </h3>
                        <div class="popular-posts-list">
                            <?php
                            $popular_posts = new WP_Query(array(
                                'posts_per_page' => 5,
                                'orderby' => 'comment_count',
                                'order' => 'DESC',
                                'meta_query' => array(
                                    array(
                                        'key' => '_thumbnail_id',
                                        'compare' => 'EXISTS'
                                    )
                                )
                            ));
                            
                            if ($popular_posts->have_posts()) :
                                $count = 1;
                                while ($popular_posts->have_posts()) : $popular_posts->the_post();
                            ?>
                                <article class="popular-post-item">
                                    <div class="popular-post-number"><?php echo $count; ?></div>
                                    <div class="popular-post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title())); ?>
                                        </a>
                                    </div>
                                    <div class="popular-post-content">
                                        <h4 class="popular-post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="popular-post-meta">
                                            <time datetime="<?php echo get_the_date('c'); ?>">
                                                <?php echo get_the_date('M j'); ?>
                                            </time>
                                            <span class="comments-count">
                                                <?php comments_number('0', '1', '%'); ?> <?php esc_html_e('comments', 'westpace-material'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                                <?php $count++; ?>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget categories-widget">
                        <h3 class="widget-title">
                            <span class="material-icons">category</span>
                            <?php esc_html_e('Categories', 'westpace-material'); ?>
                        </h3>
                        <ul class="categories-list">
                            <?php
                            $categories = get_categories(array('hide_empty' => true));
                            foreach ($categories as $category) :
                            ?>
                                <li class="category-item">
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                       class="category-link">
                                        <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                        <span class="category-count"><?php echo $category->count; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="sidebar-widget newsletter-widget">
                        <div class="newsletter-content">
                            <div class="newsletter-icon">
                                <span class="material-icons">mail</span>
                            </div>
                            <h3 class="widget-title"><?php esc_html_e('Stay Updated', 'westpace-material'); ?></h3>
                            <p><?php esc_html_e('Get the latest articles and industry insights delivered to your inbox.', 'westpace-material'); ?></p>
                            
                            <form class="newsletter-form" id="sidebar-newsletter-form">
                                <div class="form-group">
                                    <input type="email" 
                                           name="email" 
                                           placeholder="<?php esc_attr_e('Your email address', 'westpace-material'); ?>" 
                                           required 
                                           class="newsletter-input">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <?php esc_html_e('Subscribe', 'westpace-material'); ?>
                                    </button>
                                </div>
                                <p class="newsletter-privacy">
                                    <?php esc_html_e('No spam. Unsubscribe anytime.', 'westpace-material'); ?>
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Regular Sidebar Widgets -->
                    <?php if (is_active_sidebar('sidebar-1')) : ?>
                        <?php dynamic_sidebar('sidebar-1'); ?>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </section>
</div>

<!-- Enhanced Blog Styles -->
<style>
/* Blog Header */
.blog-header-section {
    background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
    padding: 6rem 0 4rem;
    margin-top: 80px;
    text-align: center;
}

.blog-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 1.5rem;
    letter-spacing: -0.025em;
}

.blog-description {
    max-width: 600px;
    margin: 0 auto 3rem;
    font-size: 1.25rem;
    color: #64748B;
    line-height: 1.6;
}

.blog-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #E2E8F0;
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

/* Blog Filters */
.blog-filters-section {
    background: white;
    padding: 2rem 0;
    border-bottom: 1px solid #E2E8F0;
}

.blog-filters-wrapper {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.blog-search-form {
    flex: 1;
    min-width: 300px;
}

.search-input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem;
    padding-right: 3rem;
    border: 2px solid #E2E8F0;
    border-radius: 0.75rem;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #1976D2;
}

.search-btn {
    position: absolute;
    right: 0.5rem;
    background: none;
    border: none;
    color: #64748B;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: color 0.3s ease;
}

.search-btn:hover {
    color: #1976D2;
}

/* Filter Dropdowns */
.filter-dropdown {
    position: relative;
}

.filter-toggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    border: 2px solid #E2E8F0;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-toggle:hover {
    border-color: #1976D2;
}

.filter-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    border: 1px solid #E2E8F0;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 10;
}

.filter-dropdown:hover .filter-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.filter-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    color: #64748B;
    text-decoration: none;
    transition: all 0.3s ease;
}

.filter-option:hover,
.filter-option.active {
    background: #F8FAFC;
    color: #1976D2;
}

.category-count {
    font-size: 0.75rem;
    opacity: 0.7;
}

/* View Toggle */
.view-toggle {
    display: flex;
    background: #F1F5F9;
    border-radius: 0.75rem;
    padding: 0.25rem;
}

.view-btn {
    background: none;
    border: none;
    padding: 0.5rem;
    border-radius: 0.5rem;
    cursor: pointer;
    color: #64748B;
    transition: all 0.3s ease;
}

.view-btn.active,
.view-btn:hover {
    background: white;
    color: #1976D2;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Blog Layout */
.blog-content-section {
    padding: 3rem 0;
}

.blog-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 4rem;
}

/* Featured Post */
.featured-post-card {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    background: white;
    border-radius: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    overflow: hidden;
    margin-bottom: 4rem;
}

.featured-post-image {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
}

.featured-post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.featured-post-card:hover .featured-post-image img {
    transform: scale(1.05);
}

.featured-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: linear-gradient(135deg, #FF6D00 0%, #FF8F00 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.featured-post-content {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.featured-post-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 1rem 0;
    line-height: 1.2;
}

.featured-post-title a {
    color: #0F172A;
    text-decoration: none;
}

.featured-post-title a:hover {
    color: #1976D2;
}

/* Posts Grid */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.post-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #E2E8F0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.post-thumbnail {
    position: relative;
    aspect-ratio: 16/10;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.reading-time-overlay {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.post-content {
    padding: 1.5rem;
}

.post-categories {
    margin-bottom: 1rem;
}

.category-link {
    background: #E3F2FD;
    color: #1976D2;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.category-link:hover {
    background: #1976D2;
    color: white;
}

.post-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.post-title a {
    color: #0F172A;
    text-decoration: none;
}

.post-title a:hover {
    color: #1976D2;
}

.post-excerpt {
    color: #64748B;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.post-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #94A3B8;
}

.meta-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.post-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.author-avatar {
    border-radius: 50%;
}

.post-author a {
    color: #64748B;
    text-decoration: none;
    font-weight: 500;
}

.post-author a:hover {
    color: #1976D2;
}

.post-comments {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #1976D2;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.read-more-btn:hover {
    color: #1565C0;
    transform: translateX(4px);
}

/* List View Styles */
.posts-grid.list-view {
    grid-template-columns: 1fr;
}

.posts-grid.list-view .post-card {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.5rem;
}

.posts-grid.list-view .post-thumbnail {
    aspect-ratio: 4/3;
}

/* Sidebar */
.blog-sidebar {
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
    font-size: 1.125rem;
    font-weight: 600;
    color: #0F172A;
    margin-bottom: 1rem;
}

/* Popular Posts */
.popular-posts-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.popular-post-item {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.popular-post-number {
    width: 24px;
    height: 24px;
    background: #1976D2;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    flex-shrink: 0;
}

.popular-post-thumbnail {
    width: 60px;
    height: 45px;
    border-radius: 0.5rem;
    overflow: hidden;
    flex-shrink: 0;
}

.popular-post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popular-post-title {
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.popular-post-title a {
    color: #374151;
    text-decoration: none;
}

.popular-post-title a:hover {
    color: #1976D2;
}

.popular-post-meta {
    font-size: 0.75rem;
    color: #94A3B8;
}

/* Categories List */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-item {
    margin-bottom: 0.5rem;
}

.category-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0;
    color: #64748B;
    text-decoration: none;
    transition: color 0.3s ease;
}

.category-link:hover {
    color: #1976D2;
}

.category-count {
    background: #F1F5F9;
    color: #64748B;
    padding: 0.125rem 0.5rem;
    border-radius: 1rem;
    font-size: 0.75rem;
}

/* Newsletter Widget */
.newsletter-widget {
    background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
    color: white;
    text-align: center;
}

.newsletter-widget .widget-title {
    color: white;
    justify-content: center;
}

.newsletter-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.newsletter-widget p {
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.newsletter-form .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.newsletter-input {
    padding: 0.75rem;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 0.875rem;
}

.newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.newsletter-privacy {
    font-size: 0.75rem;
    opacity: 0.8;
    margin: 0;
}

/* No Posts Found */
.no-posts-found {
    text-align: center;
    padding: 4rem 2rem;
    color: #64748B;
}

.no-posts-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-posts-content h2 {
    font-size: 1.5rem;
    color: #374151;
    margin-bottom: 1rem;
}

.no-posts-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    flex-wrap: wrap;
}

/* Pagination */
.blog-pagination {
    margin-top: 3rem;
    text-align: center;
}

.blog-pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    color: #64748B;
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.blog-pagination .page-numbers:hover,
.blog-pagination .page-numbers.current {
    background: #1976D2;
    color: white;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .blog-layout {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    .blog-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .blog-stats {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .blog-filters-wrapper {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .featured-post-card {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .posts-grid {
        grid-template-columns: 1fr;
    }
    
    .posts-grid.list-view .post-card {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .blog-header-section {
        padding: 4rem 0 3rem;
    }
    
    .popular-post-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .popular-post-number {
        align-self: flex-start;
    }
}
</style>

<?php
// Add filter toggle functionality
wp_add_inline_script('westpace-theme-js', '
document.addEventListener("DOMContentLoaded", function() {
    // View toggle functionality
    const viewButtons = document.querySelectorAll(".view-btn");
    const postsGrid = document.getElementById("posts-grid");
    
    viewButtons.forEach(button => {
        button.addEventListener("click", function() {
            viewButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
            
            const view = this.dataset.view;
            if (view === "list") {
                postsGrid.classList.add("list-view");
            } else {
                postsGrid.classList.remove("list-view");
            }
        });
    });
    
    // Filter dropdown toggles
    const filterToggles = document.querySelectorAll(".filter-toggle");
    filterToggles.forEach(toggle => {
        toggle.addEventListener("click", function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            dropdown.style.opacity = dropdown.style.opacity === "1" ? "0" : "1";
            dropdown.style.visibility = dropdown.style.visibility === "visible" ? "hidden" : "visible";
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener("click", function(e) {
        if (!e.target.closest(".filter-dropdown")) {
            document.querySelectorAll(".filter-dropdown-menu").forEach(menu => {
                menu.style.opacity = "0";
                menu.style.visibility = "hidden";
            });
        }
    });
});
');

get_footer();
?>