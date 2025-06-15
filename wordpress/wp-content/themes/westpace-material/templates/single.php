<?php
/**
 * The template for displaying all single posts
 * Enhanced single post template with modern design and features
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

get_header();
?>

<main id="primary" class="site-main single-post-main">
    <div class="container">
        <div class="content-layout <?php echo westpace_has_sidebar() ? 'has-sidebar' : 'full-width'; ?>">
            
            <div class="main-content">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-featured-image">
                                <?php the_post_thumbnail('hero-banner', array('loading' => 'eager')); ?>
                                <div class="post-featured-overlay">
                                    <div class="post-header-content">
                                        <div class="post-categories">
                                            <?php
                                            $categories = get_the_category();
                                            if (!empty($categories)) {
                                                echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="post-category-badge">';
                                                echo esc_html($categories[0]->name);
                                                echo '</a>';
                                            }
                                            ?>
                                        </div>
                                        <h1 class="post-title"><?php the_title(); ?></h1>
                                        <?php westpace_post_meta(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content-wrapper">
                            
                            <?php if (!has_post_thumbnail()) : ?>
                                <header class="post-header">
                                    <div class="post-categories">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="post-category-badge">';
                                            echo esc_html($categories[0]->name);
                                            echo '</a>';
                                        }
                                        ?>
                                    </div>
                                    <h1 class="post-title"><?php the_title(); ?></h1>
                                    <?php westpace_post_meta(); ?>
                                </header>
                            <?php endif; ?>

                            <!-- Reading Progress Bar -->
                            <div class="reading-progress">
                                <div class="reading-progress-bar"></div>
                            </div>

                            <!-- Post Content -->
                            <div class="post-content entry-content">
                                <?php
                                the_content(
                                    sprintf(
                                        wp_kses(
                                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'westpace-material'),
                                            array(
                                                'span' => array(
                                                    'class' => array(),
                                                ),
                                            )
                                        ),
                                        wp_kses_post(get_the_title())
                                    )
                                );

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
                            $tags_list = get_the_tag_list('', '');
                            if ($tags_list) :
                            ?>
                                <div class="post-tags">
                                    <h3 class="tags-title">
                                        <span class="material-icons-round">local_offer</span>
                                        <?php esc_html_e('Tags', 'westpace-material'); ?>
                                    </h3>
                                    <div class="tags-list">
                                        <?php echo $tags_list; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Post Footer with Share -->
                            <footer class="post-footer">
                                <div class="post-actions">
                                    
                                    <!-- Social Share -->
                                    <div class="social-share">
                                        <h3 class="share-title">
                                            <span class="material-icons-round">share</span>
                                            <?php esc_html_e('Share this post', 'westpace-material'); ?>
                                        </h3>
                                        <div class="share-buttons">
                                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               class="share-button twitter"
                                               aria-label="<?php esc_attr_e('Share on Twitter', 'westpace-material'); ?>">
                                                <span class="material-icons-round">twitter</span>
                                                <span><?php esc_html_e('Twitter', 'westpace-material'); ?></span>
                                            </a>
                                            
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               class="share-button facebook"
                                               aria-label="<?php esc_attr_e('Share on Facebook', 'westpace-material'); ?>">
                                                <span class="material-icons-round">facebook</span>
                                                <span><?php esc_html_e('Facebook', 'westpace-material'); ?></span>
                                            </a>
                                            
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               class="share-button linkedin"
                                               aria-label="<?php esc_attr_e('Share on LinkedIn', 'westpace-material'); ?>">
                                                <span class="material-icons-round">linkedin</span>
                                                <span><?php esc_html_e('LinkedIn', 'westpace-material'); ?></span>
                                            </a>
                                            
                                            <button class="share-button copy-link" 
                                                    data-url="<?php echo esc_url(get_permalink()); ?>"
                                                    aria-label="<?php esc_attr_e('Copy link', 'westpace-material'); ?>">
                                                <span class="material-icons-round">link</span>
                                                <span><?php esc_html_e('Copy Link', 'westpace-material'); ?></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Edit Link -->
                                    <?php
                                    edit_post_link(
                                        sprintf(
                                            wp_kses(
                                                __('Edit <span class="screen-reader-text">"%s"</span>', 'westpace-material'),
                                                array(
                                                    'span' => array(
                                                        'class' => array(),
                                                    ),
                                                )
                                            ),
                                            wp_kses_post(get_the_title())
                                        ),
                                        '<div class="edit-link">',
                                        '</div>'
                                    );
                                    ?>
                                </div>
                            </footer>

                        </div>
                    </article>

                    <!-- Author Bio -->
                    <?php
                    $author_bio = get_the_author_meta('description');
                    if (!empty($author_bio)) :
                    ?>
                        <div class="author-bio material-card elevation-1">
                            <div class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                            </div>
                            <div class="author-info">
                                <h3 class="author-name">
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                        <?php the_author(); ?>
                                    </a>
                                </h3>
                                <p class="author-description"><?php echo esc_html($author_bio); ?></p>
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-link">
                                    <?php esc_html_e('View all posts', 'westpace-material'); ?>
                                    <span class="material-icons-round">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Related Posts -->
                    <?php
                    $related_posts = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'meta_query' => array(
                            array(
                                'key' => '_thumbnail_id',
                                'compare' => 'EXISTS'
                            )
                        ),
                        'orderby' => 'rand'
                    ));

                    if ($related_posts->have_posts()) :
                    ?>
                        <div class="related-posts">
                            <h3 class="related-posts-title">
                                <span class="material-icons-round">auto_stories</span>
                                <?php esc_html_e('You might also like', 'westpace-material'); ?>
                            </h3>
                            <div class="related-posts-grid">
                                <?php
                                while ($related_posts->have_posts()) :
                                    $related_posts->the_post();
                                ?>
                                    <article class="related-post-card material-card elevation-1">
                                        <div class="related-post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('blog-featured'); ?>
                                            </a>
                                        </div>
                                        <div class="related-post-content">
                                            <div class="related-post-meta">
                                                <span class="material-icons-round">schedule</span>
                                                <?php echo get_the_date(); ?>
                                            </div>
                                            <h4 class="related-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <p class="related-post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                        </div>
                                    </article>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Post Navigation -->
                    <?php westpace_post_navigation(); ?>

                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>
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
/* Single Post Styles */
.single-post-article {
    background: white;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    margin-bottom: var(--space-12);
}

.post-featured-image {
    position: relative;
    height: 500px;
    overflow: hidden;
}

.post-featured-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.post-featured-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    padding: var(--space-12) var(--space-8) var(--space-8);
    color: white;
}

.post-category-badge {
    display: inline-block;
    background: var(--primary-600);
    color: white;
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-full);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    text-decoration: none;
    margin-bottom: var(--space-4);
    transition: all var(--transition-fast);
}

.post-category-badge:hover {
    background: var(--primary-700);
    color: white;
    text-decoration: none;
}

.post-title {
    font-size: var(--text-4xl);
    font-weight: var(--font-weight-bold);
    line-height: 1.2;
    margin-bottom: var(--space-6);
}

.post-featured-overlay .post-title {
    color: white;
}

.post-content-wrapper {
    padding: var(--space-8);
}

.post-header {
    text-align: center;
    margin-bottom: var(--space-8);
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: var(--space-6);
}

.post-header .post-title {
    color: var(--gray-900);
}

.reading-progress {
    position: sticky;
    top: 80px;
    width: 100%;
    height: 4px;
    background: var(--gray-200);
    border-radius: var(--radius-full);
    margin-bottom: var(--space-8);
    z-index: 10;
}

.reading-progress-bar {
    height: 100%;
    background: var(--primary-600);
    border-radius: var(--radius-full);
    width: 0%;
    transition: width 0.3s ease;
}

.post-content {
    font-size: var(--text-lg);
    line-height: 1.8;
    color: var(--gray-700);
}

.post-content h2,
.post-content h3,
.post-content h4,
.post-content h5,
.post-content h6 {
    margin: var(--space-8) 0 var(--space-4);
    color: var(--gray-900);
    font-weight: var(--font-weight-semibold);
    line-height: 1.3;
}

.post-content h2 {
    font-size: var(--text-2xl);
    border-bottom: 2px solid var(--gray-200);
    padding-bottom: var(--space-2);
}

.post-content h3 {
    font-size: var(--text-xl);
}

.post-content h4 {
    font-size: var(--text-lg);
}

.post-content p {
    margin-bottom: var(--space-6);
}

.post-content blockquote {
    border-left: 4px solid var(--primary-500);
    background: var(--primary-50);
    padding: var(--space-6);
    margin: var(--space-8) 0;
    border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
    font-style: italic;
    font-size: var(--text-lg);
}

.post-tags {
    margin: var(--space-8) 0;
    padding: var(--space-6);
    background: var(--gray-50);
    border-radius: var(--radius-lg);
}

.tags-title {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-2);
}

.tags-list a {
    display: inline-block;
    padding: var(--space-1) var(--space-3);
    background: white;
    color: var(--gray-700);
    text-decoration: none;
    border-radius: var(--radius-full);
    font-size: var(--text-sm);
    border: 1px solid var(--gray-300);
    transition: all var(--transition-fast);
}

.tags-list a:hover {
    background: var(--primary-600);
    color: white;
    border-color: var(--primary-600);
    text-decoration: none;
}

.post-footer {
    border-top: 1px solid var(--gray-200);
    padding-top: var(--space-8);
}

.social-share {
    margin-bottom: var(--space-6);
}

.share-title {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    margin-bottom: var(--space-4);
}

.share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-3);
}

.share-button {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-4);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
    transition: all var(--transition-fast);
    border: none;
    cursor: pointer;
    font-size: var(--text-sm);
}

.share-button.twitter {
    background: #1DA1F2;
    color: white;
}

.share-button.facebook {
    background: #4267B2;
    color: white;
}

.share-button.linkedin {
    background: #0077B5;
    color: white;
}

.share-button.copy-link {
    background: var(--gray-100);
    color: var(--gray-700);
}

.share-button:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
    color: inherit;
}

.author-bio {
    display: flex;
    gap: var(--space-6);
    padding: var(--space-8);
    margin: var(--space-8) 0;
    border-radius: var(--radius-lg);
    background: white;
}

.author-avatar {
    flex-shrink: 0;
}

.author-avatar img {
    border-radius: var(--radius-full);
    width: 80px;
    height: 80px;
}

.author-name {
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-3);
}

.author-name a {
    color: var(--gray-900);
    text-decoration: none;
}

.author-name a:hover {
    color: var(--primary-600);
}

.author-description {
    color: var(--gray-600);
    line-height: 1.6;
    margin-bottom: var(--space-4);
}

.author-link {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--primary-600);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
}

.author-link:hover {
    color: var(--primary-700);
    text-decoration: none;
}

.related-posts {
    margin: var(--space-12) 0;
}

.related-posts-title {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-2xl);
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    margin-bottom: var(--space-8);
    text-align: center;
    justify-content: center;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.related-post-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all var(--transition-normal);
}

.related-post-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.related-post-thumbnail {
    aspect-ratio: 16/9;
    overflow: hidden;
}

.related-post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-normal);
}

.related-post-card:hover .related-post-thumbnail img {
    transform: scale(1.05);
}

.related-post-content {
    padding: var(--space-6);
}

.related-post-meta {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--gray-500);
    font-size: var(--text-sm);
    margin-bottom: var(--space-3);
}

.related-post-title {
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-3);
    line-height: 1.4;
}

.related-post-title a {
    color: var(--gray-900);
    text-decoration: none;
}

.related-post-title a:hover {
    color: var(--primary-600);
}

.related-post-excerpt {
    color: var(--gray-600);
    line-height: 1.6;
    font-size: var(--text-sm);
}

/* Responsive Design */
@media (max-width: 768px) {
    .post-featured-image {
        height: 300px;
    }
    
    .post-content-wrapper {
        padding: var(--space-6);
    }
    
    .post-title {
        font-size: var(--text-2xl);
    }
    
    .share-buttons {
        justify-content: center;
    }
    
    .author-bio {
        flex-direction: column;
        text-align: center;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Reading Progress Bar
document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.querySelector('.reading-progress-bar');
    const postContent = document.querySelector('.post-content');
    
    if (progressBar && postContent) {
        function updateProgress() {
            const contentRect = postContent.getBoundingClientRect();
            const contentHeight = contentRect.height;
            const windowHeight = window.innerHeight;
            const scrolled = Math.max(0, -contentRect.top);
            const progress = Math.min(scrolled / (contentHeight - windowHeight), 1);
            
            progressBar.style.width = (progress * 100) + '%';
        }
        
        window.addEventListener('scroll', updateProgress);
        updateProgress();
    }
    
    // Copy Link Functionality
    const copyButtons = document.querySelectorAll('.share-button.copy-link');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const url = this.dataset.url;
            navigator.clipboard.writeText(url).then(() => {
                const originalText = this.querySelector('span:last-child').textContent;
                this.querySelector('span:last-child').textContent = 'Copied!';
                setTimeout(() => {
                    this.querySelector('span:last-child').textContent = originalText;
                }, 2000);
            });
        });
    });
});
</script>

<?php
get_footer();
?>