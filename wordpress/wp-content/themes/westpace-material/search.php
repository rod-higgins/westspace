<?php
/**
 * The template for displaying search results pages
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

get_header();
?>

<main id="primary" class="site-main search-results-main">
    <div class="container">
        <div class="content-layout <?php echo westpace_has_sidebar() ? 'has-sidebar' : 'full-width'; ?>">
            
            <div class="main-content">
                
                <!-- Search Results Header -->
                <header class="search-results-header">
                    <div class="search-results-info">
                        <h1 class="search-results-title">
                            <span class="material-icons-round">search</span>
                            <?php
                            printf(
                                esc_html__('Search Results for: %s', 'westpace-material'),
                                '<span class="search-query">' . get_search_query() . '</span>'
                            );
                            ?>
                        </h1>
                        
                        <div class="search-results-count">
                            <?php
                            global $wp_query;
                            $total = $wp_query->found_posts;
                            if ($total == 0) {
                                esc_html_e('No results found', 'westpace-material');
                            } elseif ($total == 1) {
                                esc_html_e('Found 1 result', 'westpace-material');
                            } else {
                                printf(esc_html__('Found %d results', 'westpace-material'), $total);
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Search Form -->
                    <div class="search-form-container">
                        <form role="search" method="get" class="search-form material-card elevation-1" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="search-input-group">
                                <input type="search" 
                                       class="search-field" 
                                       placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'westpace-material'); ?>" 
                                       value="<?php echo get_search_query(); ?>" 
                                       name="s" 
                                       required>
                                <button type="submit" class="search-submit btn btn-primary">
                                    <span class="material-icons-round">search</span>
                                    <span class="sr-only"><?php echo _x('Search', 'submit button', 'westpace-material'); ?></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </header>

                <?php if (have_posts()) : ?>
                    
                    <!-- Search Filters -->
                    <div class="search-filters">
                        <div class="filter-tabs">
                            <button class="filter-tab active" data-filter="all">
                                <span class="material-icons-round">dashboard</span>
                                <?php esc_html_e('All Results', 'westpace-material'); ?>
                                <span class="filter-count"><?php echo $wp_query->found_posts; ?></span>
                            </button>
                            
                            <?php
                            // Count posts by type
                            $post_types = array();
                            while (have_posts()) {
                                the_post();
                                $type = get_post_type();
                                if (!isset($post_types[$type])) {
                                    $post_types[$type] = 0;
                                }
                                $post_types[$type]++;
                            }
                            rewind_posts();
                            
                            foreach ($post_types as $type => $count) {
                                $type_obj = get_post_type_object($type);
                                if ($type_obj && $count > 0) {
                                    $icon = $type === 'product' ? 'shopping_bag' : ($type === 'page' ? 'description' : 'article');
                                    echo '<button class="filter-tab" data-filter="' . esc_attr($type) . '">';
                                    echo '<span class="material-icons-round">' . $icon . '</span>';
                                    echo esc_html($type_obj->labels->name);
                                    echo '<span class="filter-count">' . $count . '</span>';
                                    echo '</button>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Search Results -->
                    <div class="search-results-container">
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item material-card elevation-1'); ?> data-post-type="<?php echo get_post_type(); ?>">
                                
                                <div class="search-result-content">
                                    
                                    <!-- Post Type Badge -->
                                    <div class="post-type-badge">
                                        <?php
                                        $post_type_obj = get_post_type_object(get_post_type());
                                        if ($post_type_obj) {
                                            $icon = get_post_type() === 'product' ? 'shopping_bag' : (get_post_type() === 'page' ? 'description' : 'article');
                                            echo '<span class="material-icons-round">' . $icon . '</span>';
                                            echo esc_html($post_type_obj->labels->singular_name);
                                        }
                                        ?>
                                    </div>
                                    
                                    <!-- Thumbnail -->
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="search-result-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('blog-grid'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="search-result-text">
                                        
                                        <!-- Title -->
                                        <h2 class="search-result-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <!-- Meta Information -->
                                        <div class="search-result-meta">
                                            <span class="result-date">
                                                <span class="material-icons-round">schedule</span>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            
                                            <?php if (get_post_type() === 'post') : ?>
                                                <span class="result-author">
                                                    <span class="material-icons-round">person</span>
                                                    <?php the_author(); ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if (get_post_type() === 'product' && class_exists('WooCommerce')) : ?>
                                                <?php
                                                $product = wc_get_product(get_the_ID());
                                                if ($product) :
                                                ?>
                                                    <span class="result-price">
                                                        <span class="material-icons-round">attach_money</span>
                                                        <?php echo $product->get_price_html(); ?>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Excerpt -->
                                        <div class="search-result-excerpt">
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            if (empty($excerpt)) {
                                                $excerpt = wp_trim_words(get_the_content(), 30);
                                            }
                                            echo wp_kses_post($excerpt);
                                            ?>
                                        </div>
                                        
                                        <!-- Categories/Tags -->
                                        <?php if (get_post_type() === 'post') : ?>
                                            <?php
                                            $categories = get_the_category();
                                            if (!empty($categories)) :
                                            ?>
                                                <div class="search-result-categories">
                                                    <?php foreach ($categories as $category) : ?>
                                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-tag">
                                                            <?php echo esc_html($category->name); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <!-- Read More Link -->
                                        <div class="search-result-actions">
                                            <a href="<?php the_permalink(); ?>" class="read-more-link">
                                                <?php
                                                if (get_post_type() === 'product') {
                                                    esc_html_e('View Product', 'westpace-material');
                                                } else {
                                                    esc_html_e('Read More', 'westpace-material');
                                                }
                                                ?>
                                                <span class="material-icons-round">arrow_forward</span>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </article>
                            
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <?php westpace_pagination(); ?>

                <?php else : ?>
                    
                    <!-- No Results Found -->
                    <div class="no-search-results">
                        <div class="no-results-content material-card elevation-2">
                            <div class="no-results-icon">
                                <span class="material-icons-round">search_off</span>
                            </div>
                            
                            <h2 class="no-results-title">
                                <?php esc_html_e('No results found', 'westpace-material'); ?>
                            </h2>
                            
                            <p class="no-results-message">
                                <?php
                                printf(
                                    esc_html__('Sorry, no results were found for "%s". Please try a different search term or browse our content below.', 'westpace-material'),
                                    '<strong>' . get_search_query() . '</strong>'
                                );
                                ?>
                            </p>
                            
                            <!-- Search Suggestions -->
                            <div class="search-suggestions">
                                <h3><?php esc_html_e('Search Suggestions:', 'westpace-material'); ?></h3>
                                <ul>
                                    <li><?php esc_html_e('Try different keywords', 'westpace-material'); ?></li>
                                    <li><?php esc_html_e('Try more general keywords', 'westpace-material'); ?></li>
                                    <li><?php esc_html_e('Check your spelling', 'westpace-material'); ?></li>
                                    <li><?php esc_html_e('Use fewer keywords', 'westpace-material'); ?></li>
                                </ul>
                            </div>
                            
                            <!-- Popular Content -->
                            <?php
                            $popular_posts = new WP_Query(array(
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                            ));
                            
                            if ($popular_posts->have_posts()) :
                            ?>
                                <div class="popular-content">
                                    <h3><?php esc_html_e('Popular Content:', 'westpace-material'); ?></h3>
                                    <div class="popular-posts-grid">
                                        <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                                            <article class="popular-post-card">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <div class="popular-post-thumbnail">
                                                        <a href="<?php the_permalink(); ?>">
                                                            <?php the_post_thumbnail('thumbnail'); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="popular-post-content">
                                                    <h4 class="popular-post-title">
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h4>
                                                    <div class="popular-post-meta">
                                                        <span class="material-icons-round">schedule</span>
                                                        <?php echo get_the_date(); ?>
                                                    </div>
                                                </div>
                                            </article>
                                        <?php endwhile; wp_reset_postdata(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
            </div>

            <?php if (westpace_has_sidebar()) : ?>
                <aside id="secondary" class="widget-area sidebar">
                    <?php dynamic_sidebar(westpace_get_sidebar()); ?>
                </aside>
            <?php endif; ?>

        </div>
    </div>
</main>

<style>
/* Search Results Styles */
.search-results-main {
    padding: var(--space-8) 0;
}

.search-results-header {
    text-align: center;
    margin-bottom: var(--space-12);
    padding: var(--space-8);
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
}

.search-results-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-3);
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.search-query {
    color: var(--primary-600);
    font-style: italic;
}

.search-results-count {
    color: var(--gray-600);
    margin-bottom: var(--space-6);
    font-size: var(--text-lg);
}

.search-form-container {
    max-width: 500px;
    margin: 0 auto;
}

.search-form {
    padding: var(--space-4);
    border-radius: var(--radius-lg);
}

.search-input-group {
    display: flex;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.search-field {
    flex: 1;
    padding: var(--space-4);
    border: none;
    font-size: var(--text-base);
    outline: none;
}

.search-submit {
    border: none;
    border-radius: 0;
    padding: var(--space-4) var(--space-6);
}

/* Search Filters */
.search-filters {
    margin-bottom: var(--space-8);
}

.filter-tabs {
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
    justify-content: center;
}

.filter-tab {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-4);
    background: white;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-lg);
    cursor: pointer;
    transition: all var(--transition-fast);
    font-size: var(--text-sm);
    color: var(--gray-700);
}

.filter-tab:hover,
.filter-tab.active {
    background: var(--primary-600);
    color: white;
    border-color: var(--primary-600);
}

.filter-count {
    background: rgba(255, 255, 255, 0.2);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    min-width: 20px;
    text-align: center;
}

.filter-tab.active .filter-count {
    background: rgba(255, 255, 255, 0.3);
}

/* Search Results */
.search-results-container {
    display: grid;
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

.search-result-item {
    background: white;
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    transition: all var(--transition-normal);
    border: 1px solid var(--gray-200);
}

.search-result-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.search-result-content {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: var(--space-6);
    align-items: start;
}

.search-result-item:not(:has(.search-result-thumbnail)) .search-result-content {
    grid-template-columns: 1fr;
}

.post-type-badge {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: var(--space-2);
    background: var(--primary-100);
    color: var(--primary-700);
    padding: var(--space-1) var(--space-3);
    border-radius: var(--radius-full);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    width: fit-content;
    margin-bottom: var(--space-4);
}

.search-result-thumbnail {
    width: 150px;
    height: 100px;
    border-radius: var(--radius-md);
    overflow: hidden;
}

.search-result-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.search-result-item:hover .search-result-thumbnail img {
    transform: scale(1.05);
}

.search-result-title {
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-3);
    line-height: 1.4;
}

.search-result-title a {
    color: var(--gray-900);
    text-decoration: none;
}

.search-result-title a:hover {
    color: var(--primary-600);
}

.search-result-meta {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    color: var(--gray-600);
    font-size: var(--text-sm);
    margin-bottom: var(--space-3);
    flex-wrap: wrap;
}

.search-result-meta span {
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

.search-result-meta .material-icons-round {
    font-size: 1rem;
}

.search-result-excerpt {
    color: var(--gray-700);
    line-height: 1.6;
    margin-bottom: var(--space-4);
}

.search-result-categories {
    display: flex;
    gap: var(--space-2);
    margin-bottom: var(--space-4);
    flex-wrap: wrap;
}

.category-tag {
    background: var(--gray-100);
    color: var(--gray-700);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-md);
    font-size: var(--text-xs);
    text-decoration: none;
    transition: all var(--transition-fast);
}

.category-tag:hover {
    background: var(--primary-600);
    color: white;
    text-decoration: none;
}

.read-more-link {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--primary-600);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
    transition: all var(--transition-fast);
}

.read-more-link:hover {
    color: var(--primary-700);
    text-decoration: none;
    transform: translateX(4px);
}

/* No Results */
.no-search-results {
    text-align: center;
}

.no-results-content {
    padding: var(--space-12);
    background: white;
    border-radius: var(--radius-xl);
    max-width: 600px;
    margin: 0 auto;
}

.no-results-icon {
    font-size: 4rem;
    color: var(--gray-400);
    margin-bottom: var(--space-6);
}

.no-results-title {
    font-size: var(--text-2xl);
    font-weight: var(--font-weight-bold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.no-results-message {
    color: var(--gray-600);
    line-height: 1.6;
    margin-bottom: var(--space-8);
}

.search-suggestions {
    text-align: left;
    background: var(--gray-50);
    padding: var(--space-6);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-8);
}

.search-suggestions h3 {
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.search-suggestions ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.search-suggestions li {
    padding: var(--space-2) 0;
    color: var(--gray-600);
    position: relative;
    padding-left: var(--space-6);
}

.search-suggestions li::before {
    content: '•';
    color: var(--primary-600);
    position: absolute;
    left: 0;
    font-weight: bold;
}

.popular-content {
    text-align: left;
}

.popular-content h3 {
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.popular-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
}

.popular-post-card {
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all var(--transition-fast);
}

.popular-post-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.popular-post-thumbnail {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.popular-post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popular-post-content {
    padding: var(--space-4);
}

.popular-post-title {
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    margin-bottom: var(--space-2);
    line-height: 1.4;
}

.popular-post-title a {
    color: var(--gray-900);
    text-decoration: none;
}

.popular-post-title a:hover {
    color: var(--primary-600);
}

.popular-post-meta {
    display: flex;
    align-items: center;
    gap: var(--space-1);
    color: var(--gray-600);
    font-size: var(--text-xs);
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-results-header {
        padding: var(--space-6);
    }
    
    .search-results-title {
        font-size: var(--text-2xl);
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .filter-tabs {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: var(--space-2);
    }
    
    .search-result-content {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .search-result-thumbnail {
        width: 100%;
        height: 200px;
    }
    
    .search-result-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-2);
    }
    
    .popular-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .no-results-content {
        padding: var(--space-8);
    }
}
</style>

<script>
// Search Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const searchResults = document.querySelectorAll('.search-result-item');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter results
            searchResults.forEach(result => {
                if (filter === 'all' || result.dataset.postType === filter) {
                    result.style.display = 'block';
                } else {
                    result.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php
get_footer();
?>