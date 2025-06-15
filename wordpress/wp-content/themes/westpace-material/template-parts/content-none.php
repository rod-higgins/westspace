<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Westpace_Material
 * @version 3.0.0
 */
?>

<section class="no-results not-found">
    <div class="no-results-content material-card elevation-2">
        
        <div class="no-results-icon">
            <?php if (is_search()) : ?>
                <span class="material-icons-round">search_off</span>
            <?php else : ?>
                <span class="material-icons-round">article</span>
            <?php endif; ?>
        </div>

        <header class="page-header">
            <h1 class="page-title">
                <?php
                if (is_search()) :
                    esc_html_e('Nothing found for your search', 'westpace-material');
                else :
                    esc_html_e('Nothing here', 'westpace-material');
                endif;
                ?>
            </h1>
        </header>

        <div class="page-content">
            <?php if (is_home() && current_user_can('publish_posts')) : ?>
                <p>
                    <?php
                    printf(
                        wp_kses(
                            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'westpace-material'),
                            array(
                                'a' => array(
                                    'href' => array(),
                                ),
                            )
                        ),
                        esc_url(admin_url('post-new.php'))
                    );
                    ?>
                </p>
            <?php elseif (is_search()) : ?>
                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'westpace-material'); ?></p>
                
                <div class="search-suggestions">
                    <h3><?php esc_html_e('Search Suggestions:', 'westpace-material'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('Try different keywords', 'westpace-material'); ?></li>
                        <li><?php esc_html_e('Try more general keywords', 'westpace-material'); ?></li>
                        <li><?php esc_html_e('Check your spelling', 'westpace-material'); ?></li>
                    </ul>
                </div>

                <div class="alternative-search">
                    <h3><?php esc_html_e('Try searching again:', 'westpace-material'); ?></h3>
                    <?php get_search_form(); ?>
                </div>
                
            <?php else : ?>
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try browsing our content below?', 'westpace-material'); ?></p>
            <?php endif; ?>
        </div>

        <?php if (is_search() || is_archive()) : ?>
            <div class="helpful-links">
                <h3><?php esc_html_e('You might be interested in:', 'westpace-material'); ?></h3>
                <div class="links-grid">
                    
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="helpful-link">
                        <span class="material-icons-round">home</span>
                        <span><?php esc_html_e('Home Page', 'westpace-material'); ?></span>
                    </a>
                    
                    <?php if (get_option('page_for_posts')) : ?>
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="helpful-link">
                            <span class="material-icons-round">article</span>
                            <span><?php esc_html_e('Blog', 'westpace-material'); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="helpful-link">
                            <span class="material-icons-round">store</span>
                            <span><?php esc_html_e('Shop', 'westpace-material'); ?></span>
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="helpful-link">
                        <span class="material-icons-round">contact_mail</span>
                        <span><?php esc_html_e('Contact Us', 'westpace-material'); ?></span>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php
        // Show recent posts if no content found
        if (!is_home()) :
            $recent_posts = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true,
            ));

            if ($recent_posts->have_posts()) :
                ?>
                <div class="recent-posts-section">
                    <h3><?php esc_html_e('Recent Posts:', 'westpace-material'); ?></h3>
                    <div class="recent-posts-grid">
                        <?php
                        while ($recent_posts->have_posts()) :
                            $recent_posts->the_post();
                            ?>
                            <article class="recent-post-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="recent-post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="recent-post-content">
                                    <h4 class="recent-post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    <div class="recent-post-meta">
                                        <span class="material-icons-round">schedule</span>
                                        <?php echo get_the_date(); ?>
                                    </div>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php
            endif;
        endif;
        ?>
    </div>
</section>

<style>
/* No Results Styles */
.no-results {
    padding: var(--space-12) 0;
}

.no-results-content {
    max-width: 800px;
    margin: 0 auto;
    padding: var(--space-12);
    text-align: center;
    border-radius: var(--radius-xl);
    background: white;
}

.no-results-icon {
    font-size: 4rem;
    color: var(--gray-400);
    margin-bottom: var(--space-6);
}

.no-results-icon .material-icons-round {
    font-size: inherit;
}

.no-results .page-title {
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--gray-900);
    margin-bottom: var(--space-6);
}

.no-results .page-content {
    font-size: var(--text-lg);
    color: var(--gray-600);
    line-height: 1.6;
    margin-bottom: var(--space-8);
}

.search-suggestions {
    background: var(--gray-50);
    padding: var(--space-6);
    border-radius: var(--radius-lg);
    margin: var(--space-6) 0;
    text-align: left;
}

.search-suggestions h3 {
    color: var(--gray-900);
    margin-bottom: var(--space-4);
    font-size: var(--text-lg);
}

.search-suggestions ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.search-suggestions li {
    color: var(--gray-600);
    margin-bottom: var(--space-2);
    padding-left: var(--space-6);
    position: relative;
}

.search-suggestions li::before {
    content: '•';
    color: var(--primary-600);
    position: absolute;
    left: 0;
    font-weight: bold;
}

.alternative-search {
    margin: var(--space-8) 0;
}

.alternative-search h3 {
    color: var(--gray-900);
    margin-bottom: var(--space-4);
    font-size: var(--text-lg);
}

.helpful-links {
    margin: var(--space-8) 0;
}

.helpful-links h3 {
    color: var(--gray-900);
    margin-bottom: var(--space-6);
    font-size: var(--text-xl);
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
}

.helpful-link {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-4);
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    text-decoration: none;
    color: var(--gray-700);
    transition: all var(--transition-fast);
    border: 1px solid var(--gray-200);
}

.helpful-link:hover {
    background: var(--primary-50);
    color: var(--primary-700);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

.recent-posts-section {
    margin-top: var(--space-12);
    text-align: left;
}

.recent-posts-section h3 {
    color: var(--gray-900);
    margin-bottom: var(--space-6);
    font-size: var(--text-xl);
    text-align: center;
}

.recent-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-4);
}

.recent-post-card {
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid var(--gray-200);
    transition: all var(--transition-fast);
}

.recent-post-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.recent-post-thumbnail {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.recent-post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.recent-post-card:hover .recent-post-thumbnail img {
    transform: scale(1.05);
}

.recent-post-content {
    padding: var(--space-4);
}

.recent-post-title {
    margin-bottom: var(--space-2);
    font-size: var(--text-base);
    line-height: 1.4;
}

.recent-post-title a {
    color: var(--gray-900);
    text-decoration: none;
}

.recent-post-title a:hover {
    color: var(--primary-600);
}

.recent-post-meta {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--gray-500);
    font-size: var(--text-sm);
}

.recent-post-meta .material-icons-round {
    font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .no-results-content {
        padding: var(--space-8);
        margin: 0 var(--space-4);
    }
    
    .links-grid {
        grid-template-columns: 1fr;
    }
    
    .recent-posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>