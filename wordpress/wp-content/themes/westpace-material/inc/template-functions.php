<?php
/**
 * Template Functions for Westpace Material Theme
 * Helper functions for template files
 * 
 * @package Westpace_Material
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display post meta information
 */
function westpace_post_meta() {
    $date = get_the_date();
    $author = get_the_author();
    $categories = get_the_category_list(', ');
    $comments_count = get_comments_number();
    
    echo '<div class="post-meta">';
    
    // Date
    echo '<span class="post-date meta-item">';
    echo '<span class="material-icons">schedule</span>';
    echo '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html($date) . '</time>';
    echo '</span>';
    
    // Author
    echo '<span class="post-author meta-item">';
    echo '<span class="material-icons">person</span>';
    echo '<span>' . esc_html($author) . '</span>';
    echo '</span>';
    
    // Categories
    if ($categories) {
        echo '<span class="post-categories meta-item">';
        echo '<span class="material-icons">folder</span>';
        echo '<span>' . $categories . '</span>';
        echo '</span>';
    }
    
    // Comments
    if (comments_open() && $comments_count > 0) {
        echo '<span class="post-comments meta-item">';
        echo '<span class="material-icons">comment</span>';
        echo '<a href="' . esc_url(get_comments_link()) . '">';
        echo sprintf(_n('%s Comment', '%s Comments', $comments_count, 'westpace-material'), $comments_count);
        echo '</a>';
        echo '</span>';
    }
    
    echo '</div>';
}

/**
 * Display post tags
 */
function westpace_post_tags() {
    $tags = get_the_tag_list();
    if ($tags) {
        echo '<div class="post-tags">';
        echo '<span class="tags-label">';
        echo '<span class="material-icons">local_offer</span>';
        echo __('Tags:', 'westpace-material');
        echo '</span>';
        echo '<span class="tags-list">' . $tags . '</span>';
        echo '</div>';
    }
}

/**
 * Display post navigation
 */
function westpace_post_navigation() {
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    
    if (!$prev_post && !$next_post) {
        return;
    }
    
    echo '<nav class="post-navigation" aria-label="' . __('Post navigation', 'westpace-material') . '">';
    echo '<div class="nav-links">';
    
    if ($prev_post) {
        echo '<div class="nav-previous">';
        echo '<a href="' . esc_url(get_permalink($prev_post)) . '" class="nav-link material-card elevation-1">';
        echo '<span class="nav-direction">';
        echo '<span class="material-icons">arrow_back</span>';
        echo __('Previous Post', 'westpace-material');
        echo '</span>';
        echo '<span class="nav-title">' . esc_html(get_the_title($prev_post)) . '</span>';
        echo '</a>';
        echo '</div>';
    }
    
    if ($next_post) {
        echo '<div class="nav-next">';
        echo '<a href="' . esc_url(get_permalink($next_post)) . '" class="nav-link material-card elevation-1">';
        echo '<span class="nav-direction">';
        echo __('Next Post', 'westpace-material');
        echo '<span class="material-icons">arrow_forward</span>';
        echo '</span>';
        echo '<span class="nav-title">' . esc_html(get_the_title($next_post)) . '</span>';
        echo '</a>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</nav>';
}

/**
 * Display related posts
 */
function westpace_related_posts($post_id = null, $limit = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = wp_get_post_categories($post_id);
    if (!$categories) {
        return;
    }
    
    $args = array(
        'category__in' => $categories,
        'post__not_in' => array($post_id),
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'rand'
    );
    
    $related_posts = new WP_Query($args);
    
    if ($related_posts->have_posts()) {
        echo '<section class="related-posts">';
        echo '<h3 class="related-posts-title">' . __('Related Posts', 'westpace-material') . '</h3>';
        echo '<div class="related-posts-grid grid grid-cols-' . min($limit, 3) . '">';
        
        while ($related_posts->have_posts()) {
            $related_posts->the_post();
            echo '<article class="related-post material-card elevation-2">';
            
            if (has_post_thumbnail()) {
                echo '<div class="related-post-thumbnail">';
                echo '<a href="' . esc_url(get_permalink()) . '">';
                the_post_thumbnail('westpace-thumbnail');
                echo '</a>';
                echo '</div>';
            }
            
            echo '<div class="related-post-content">';
            echo '<h4 class="related-post-title">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
            echo '</h4>';
            echo '<p class="related-post-excerpt">' . wp_trim_words(get_the_excerpt(), 15) . '</p>';
            echo '</div>';
            
            echo '</article>';
        }
        
        echo '</div>';
        echo '</section>';
        
        wp_reset_postdata();
    }
}

/**
 * Display post thumbnail with fallback
 */
function westpace_post_thumbnail($size = 'westpace-featured', $class = 'post-thumbnail') {
    if (has_post_thumbnail()) {
        echo '<div class="' . esc_attr($class) . '">';
        the_post_thumbnail($size);
        echo '</div>';
    } else {
        echo '<div class="' . esc_attr($class) . ' placeholder-thumbnail">';
        echo '<div class="placeholder-content">';
        echo '<span class="material-icons">image</span>';
        echo '</div>';
        echo '</div>';
    }
}

/**
 * Display search form
 */
function westpace_search_form() {
    ?>
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="search-form-group">
            <label for="search-field" class="screen-reader-text"><?php _e('Search for:', 'westpace-material'); ?></label>
            <input type="search" id="search-field" class="search-field form-control" placeholder="<?php _e('Search...', 'westpace-material'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            <button type="submit" class="search-submit btn btn-primary">
                <span class="material-icons">search</span>
                <span class="screen-reader-text"><?php _e('Search', 'westpace-material'); ?></span>
            </button>
        </div>
    </form>
    <?php
}

/**
 * Display social sharing buttons
 */
function westpace_social_share($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $title = get_the_title($post_id);
    $url = get_permalink($post_id);
    $excerpt = wp_trim_words(get_the_excerpt($post_id), 20);
    
    echo '<div class="social-share">';
    echo '<h4 class="social-share-title">' . __('Share this post:', 'westpace-material') . '</h4>';
    echo '<div class="social-share-buttons">';
    
    // Facebook
    echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url) . '" target="_blank" rel="noopener" class="social-share-button facebook" aria-label="' . __('Share on Facebook', 'westpace-material') . '">';
    echo '<span class="material-icons">facebook</span>';
    echo '</a>';
    
    // Twitter
    echo '<a href="https://twitter.com/intent/tweet?url=' . urlencode($url) . '&text=' . urlencode($title) . '" target="_blank" rel="noopener" class="social-share-button twitter" aria-label="' . __('Share on Twitter', 'westpace-material') . '">';
    echo '<span class="material-icons">telegram</span>';
    echo '</a>';
    
    // LinkedIn
    echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($url) . '&title=' . urlencode($title) . '&summary=' . urlencode($excerpt) . '" target="_blank" rel="noopener" class="social-share-button linkedin" aria-label="' . __('Share on LinkedIn', 'westpace-material') . '">';
    echo '<span class="material-icons">business</span>';
    echo '</a>';
    
    // Email
    echo '<a href="mailto:?subject=' . urlencode($title) . '&body=' . urlencode($url) . '" class="social-share-button email" aria-label="' . __('Share via Email', 'westpace-material') . '">';
    echo '<span class="material-icons">email</span>';
    echo '</a>';
    
    echo '</div>';
    echo '</div>';
}

/**
 * Display reading time estimate
 */
function westpace_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed of 200 words per minute
    
    echo '<span class="reading-time meta-item">';
    echo '<span class="material-icons">schedule</span>';
    echo sprintf(_n('%d min read', '%d min read', $reading_time, 'westpace-material'), $reading_time);
    echo '</span>';
}

/**
 * Display author bio
 */
function westpace_author_bio($author_id = null) {
    if (!$author_id) {
        $author_id = get_the_author_meta('ID');
    }
    
    $author_description = get_the_author_meta('description', $author_id);
    if (!$author_description) {
        return;
    }
    
    echo '<div class="author-bio material-card elevation-1">';
    echo '<div class="author-bio-avatar">';
    echo get_avatar($author_id, 80);
    echo '</div>';
    echo '<div class="author-bio-content">';
    echo '<h4 class="author-bio-name">' . get_the_author_meta('display_name', $author_id) . '</h4>';
    echo '<p class="author-bio-description">' . esc_html($author_description) . '</p>';
    
    $author_website = get_the_author_meta('user_url', $author_id);
    if ($author_website) {
        echo '<a href="' . esc_url($author_website) . '" class="author-bio-website btn btn-outline btn-sm" target="_blank" rel="noopener">';
        echo '<span class="material-icons">language</span>';
        echo __('Visit Website', 'westpace-material');
        echo '</a>';
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Display newsletter signup form
 */
function westpace_newsletter_form() {
    ?>
    <div class="newsletter-signup material-card elevation-2">
        <div class="newsletter-content">
            <h3 class="newsletter-title"><?php _e('Stay Updated', 'westpace-material'); ?></h3>
            <p class="newsletter-description"><?php _e('Subscribe to our newsletter for the latest updates and news.', 'westpace-material'); ?></p>
            
            <form class="newsletter-form" id="newsletter-form">
                <div class="form-group">
                    <label for="newsletter-email" class="screen-reader-text"><?php _e('Email Address', 'westpace-material'); ?></label>
                    <input type="email" id="newsletter-email" name="email" class="form-control" placeholder="<?php _e('Enter your email', 'westpace-material'); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary newsletter-submit">
                    <span class="material-icons">send</span>
                    <?php _e('Subscribe', 'westpace-material'); ?>
                </button>
            </form>
            
            <div class="newsletter-message" id="newsletter-message"></div>
        </div>
    </div>
    <?php
}

/**
 * Display page header
 */
function westpace_page_header($title = null, $subtitle = null, $background_image = null) {
    if (!$title) {
        $title = get_the_title();
    }
    
    echo '<header class="page-header"';
    if ($background_image) {
        echo ' style="background-image: url(' . esc_url($background_image) . ');"';
    }
    echo '>';
    echo '<div class="page-header-content">';
    echo '<div class="container">';
    
    // Breadcrumb
    westpace_breadcrumb();
    
    echo '<h1 class="page-title">' . esc_html($title) . '</h1>';
    
    if ($subtitle) {
        echo '<p class="page-subtitle">' . esc_html($subtitle) . '</p>';
    }
    
    echo '</div>';
    echo '</div>';
    echo '</header>';
}

/**
 * Display archive header
 */
function westpace_archive_header() {
    if (is_category()) {
        $title = single_cat_title('', false);
        $description = category_description();
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
        $description = tag_description();
    } elseif (is_author()) {
        $title = get_the_author();
        $description = get_the_author_meta('description');
    } elseif (is_date()) {
        if (is_year()) {
            $title = get_the_date('Y');
        } elseif (is_month()) {
            $title = get_the_date('F Y');
        } else {
            $title = get_the_date();
        }
        $description = '';
    } else {
        $title = get_the_archive_title();
        $description = get_the_archive_description();
    }
    
    echo '<header class="archive-header">';
    echo '<div class="container">';
    
    westpace_breadcrumb();
    
    echo '<h1 class="archive-title">' . esc_html($title) . '</h1>';
    
    if ($description) {
        echo '<div class="archive-description">' . wp_kses_post($description) . '</div>';
    }
    
    echo '</div>';
    echo '</header>';
}

/**
 * Display 404 error content
 */
function westpace_404_content() {
    ?>
    <div class="error-404-content">
        <div class="error-404-icon">
            <span class="material-icons">error_outline</span>
        </div>
        <h1 class="error-404-title"><?php _e('Page Not Found', 'westpace-material'); ?></h1>
        <p class="error-404-message"><?php _e('Sorry, the page you are looking for could not be found.', 'westpace-material'); ?></p>
        
        <div class="error-404-actions">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                <span class="material-icons">home</span>
                <?php _e('Go Home', 'westpace-material'); ?>
            </a>
            
            <button onclick="history.back()" class="btn btn-outline">
                <span class="material-icons">arrow_back</span>
                <?php _e('Go Back', 'westpace-material'); ?>
            </button>
        </div>
        
        <div class="error-404-search">
            <h3><?php _e('Search our site:', 'westpace-material'); ?></h3>
            <?php westpace_search_form(); ?>
        </div>
        
        <div class="error-404-recent">
            <h3><?php _e('Recent Posts:', 'westpace-material'); ?></h3>
            <?php
            $recent_posts = new WP_Query(array(
                'posts_per_page' => 5,
                'post_status' => 'publish'
            ));
            
            if ($recent_posts->have_posts()) {
                echo '<ul class="recent-posts-list">';
                while ($recent_posts->have_posts()) {
                    $recent_posts->the_post();
                    echo '<li><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></li>';
                }
                echo '</ul>';
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Display loading spinner
 */
function westpace_loading_spinner($text = null) {
    if (!$text) {
        $text = __('Loading...', 'westpace-material');
    }
    
    echo '<div class="loading-spinner">';
    echo '<div class="spinner"></div>';
    echo '<span class="loading-text">' . esc_html($text) . '</span>';
    echo '</div>';
}

/**
 * Format phone number for display
 */
function westpace_format_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) == 10) {
        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $phone);
    } elseif (strlen($phone) == 11) {
        return preg_replace('/(\d{1})(\d{3})(\d{3})(\d{4})/', '$1 ($2) $3-$4', $phone);
    }
    
    return $phone;
}

/**
 * Get theme color
 */
function westpace_get_theme_color($color_name, $default = '') {
    return get_theme_mod('westpace_' . $color_name, $default);
}

/**
 * Check if dark mode is enabled
 */
function westpace_is_dark_mode() {
    return get_theme_mod('enable_dark_mode', false);
}

/**
 * Display back to top button
 */
function westpace_back_to_top() {
    echo '<button id="back-to-top" class="back-to-top-button" aria-label="' . __('Back to top', 'westpace-material') . '">';
    echo '<span class="material-icons">keyboard_arrow_up</span>';
    echo '</button>';
}

/**
 * Display cookie notice (GDPR compliance)
 */
function westpace_cookie_notice() {
    if (get_theme_mod('enable_cookie_notice', false)) {
        ?>
        <div id="cookie-notice" class="cookie-notice" style="display: none;">
            <div class="cookie-notice-content">
                <p><?php echo esc_html(get_theme_mod('cookie_notice_text', __('This website uses cookies to improve your experience.', 'westpace-material'))); ?></p>
                <div class="cookie-notice-actions">
                    <button id="accept-cookies" class="btn btn-primary btn-sm"><?php _e('Accept', 'westpace-material'); ?></button>
                    <button id="decline-cookies" class="btn btn-outline btn-sm"><?php _e('Decline', 'westpace-material'); ?></button>
                </div>
            </div>
        </div>
        <?php
    }
}