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
 * Display author bio box
 */
function westpace_author_bio($author_id = null) {
    if (!$author_id) {
        $author_id = get_the_author_meta('ID');
    }
    
    $author_description = get_the_author_meta('description', $author_id);
    $author_avatar = get_avatar($author_id, 80);
    
    if (!$author_description) {
        return;
    }
    
    echo '<div class="author-bio material-card elevation-2">';
    echo '<div class="author-bio-avatar">' . $author_avatar . '</div>';
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
 * Display featured image with overlay
 */
function westpace_featured_image($size = 'westpace-featured', $show_overlay = true) {
    if (!has_post_thumbnail()) {
        return;
    }
    
    echo '<div class="featured-image-container">';
    
    if ($show_overlay) {
        echo '<div class="featured-image-overlay"></div>';
    }
    
    the_post_thumbnail($size, array('class' => 'featured-image'));
    
    echo '</div>';
}

/**
 * Display social sharing buttons
 */
function westpace_social_share($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_title = get_the_title($post_id);
    $post_url = get_permalink($post_id);
    $post_excerpt = get_the_excerpt($post_id);
    
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url);
    $twitter_url = 'https://twitter.com/intent/tweet?url=' . urlencode($post_url) . '&text=' . urlencode($post_title);
    $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($post_url);
    $email_url = 'mailto:?subject=' . urlencode($post_title) . '&body=' . urlencode($post_excerpt . ' ' . $post_url);
    
    echo '<div class="social-share">';
    echo '<h4 class="social-share-title">' . __('Share this post:', 'westpace-material') . '</h4>';
    echo '<div class="social-share-buttons">';
    
    echo '<a href="' . esc_url($facebook_url) . '" target="_blank" rel="noopener" class="social-share-button facebook" title="' . __('Share on Facebook', 'westpace-material') . '">';
    echo '<span class="material-icons">facebook</span>';
    echo '</a>';
    
    echo '<a href="' . esc_url($twitter_url) . '" target="_blank" rel="noopener" class="social-share-button twitter" title="' . __('Share on Twitter', 'westpace-material') . '">';
    echo '<span class="material-icons">twitter</span>';
    echo '</a>';
    
    echo '<a href="' . esc_url($linkedin_url) . '" target="_blank" rel="noopener" class="social-share-button linkedin" title="' . __('Share on LinkedIn', 'westpace-material') . '">';
    echo '<span class="material-icons">linkedin</span>';
    echo '</a>';
    
    echo '<a href="' . esc_url($email_url) . '" class="social-share-button email" title="' . __('Share via Email', 'westpace-material') . '">';
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
    $reading_time = ceil($word_count / 200); // Average reading speed
    
    if ($reading_time > 0) {
        echo '<span class="reading-time meta-item">';
        echo '<span class="material-icons">schedule</span>';
        echo sprintf(_n('%d min read', '%d min read', $reading_time, 'westpace-material'), $reading_time);
        echo '</span>';
    }
}

/**
 * Display related posts
 */
function westpace_related_posts($post_id = null, $posts_per_page = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return;
    }
    
    $args = array(
        'category__in' => $categories,
        'post__not_in' => array($post_id),
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
    );
    
    $related_posts = new WP_Query($args);
    
    if (!$related_posts->have_posts()) {
        return;
    }
    
    echo '<section class="related-posts">';
    echo '<h3 class="related-posts-title">' . __('Related Posts', 'westpace-material') . '</h3>';
    echo '<div class="related-posts-grid">';
    
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
        echo '<div class="related-post-meta">';
        echo '<time datetime="' . esc_attr(get_the_date('c')) . '">' . get_the_date() . '</time>';
        echo '</div>';
        echo '</div>';
        
        echo '</article>';
    }
    
    echo '</div>';
    echo '</section>';
    
    wp_reset_postdata();
}

/**
 * Display comment form with Material Design styling
 */
function westpace_comment_form($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    if (!comments_open($post_id)) {
        return;
    }
    
    $args = array(
        'class_form' => 'comment-form material-card elevation-2',
        'class_submit' => 'btn btn-primary comment-submit',
        'title_reply' => __('Leave a Comment', 'westpace-material'),
        'title_reply_to' => __('Reply to %s', 'westpace-material'),
        'cancel_reply_link' => __('Cancel Reply', 'westpace-material'),
        'label_submit' => __('Post Comment', 'westpace-material'),
        'format' => 'html5',
        'fields' => array(
            'author' => '<div class="form-group">
                <label for="author">' . __('Name', 'westpace-material') . ' <span class="required">*</span></label>
                <input id="author" name="author" type="text" class="form-control" required />
            </div>',
            'email' => '<div class="form-group">
                <label for="email">' . __('Email', 'westpace-material') . ' <span class="required">*</span></label>
                <input id="email" name="email" type="email" class="form-control" required />
            </div>',
            'url' => '<div class="form-group">
                <label for="url">' . __('Website', 'westpace-material') . '</label>
                <input id="url" name="url" type="url" class="form-control" />
            </div>',
        ),
        'comment_field' => '<div class="form-group">
            <label for="comment">' . __('Comment', 'westpace-material') . ' <span class="required">*</span></label>
            <textarea id="comment" name="comment" class="form-control" rows="5" required></textarea>
        </div>',
    );
    
    comment_form($args, $post_id);
}

/**
 * Display comment list with Material Design styling
 */
function westpace_comment_list($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $comments = get_comments(array(
        'post_id' => $post_id,
        'status' => 'approve',
        'hierarchical' => true,
    ));
    
    if (empty($comments)) {
        return;
    }
    
    echo '<section class="comments-section">';
    echo '<h3 class="comments-title">' . sprintf(_n('%d Comment', '%d Comments', count($comments), 'westpace-material'), count($comments)) . '</h3>';
    
    echo '<ol class="comment-list">';
    wp_list_comments(array(
        'walker' => new Westpace_Walker_Comment(),
        'style' => 'ol',
        'short_ping' => true,
        'avatar_size' => 50,
    ), $comments);
    echo '</ol>';
    
    echo '</section>';
}

/**
 * Custom Walker for Comments
 */
class Westpace_Walker_Comment extends Walker_Comment {
    
    public function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        
        if (!empty($args['callback'])) {
            ob_start();
            call_user_func($args['callback'], $comment, $args, $depth);
            $output .= ob_get_clean();
            return;
        }
        
        if (($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback') && $args['short_ping']) {
            ob_start();
            $this->ping($comment, $depth, $args);
            $output .= ob_get_clean();
        } elseif ($args['format'] == 'html5') {
            ob_start();
            $this->html5_comment($comment, $depth, $args);
            $output .= ob_get_clean();
        } else {
            ob_start();
            $this->comment($comment, $depth, $args);
            $output .= ob_get_clean();
        }
    }
    
    protected function html5_comment($comment, $depth, $args) {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent material-card elevation-1' : 'material-card elevation-1'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        if (0 != $args['avatar_size']) {
                            echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'comment-avatar'));
                        }
                        ?>
                        <b class="fn"><?php comment_author_link(); ?></b>
                        <span class="says"><?php _e('says:', 'westpace-material'); ?></span>
                    </div>
                    
                    <div class="comment-metadata">
                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                            <time datetime="<?php comment_time('c'); ?>">
                                <?php comment_date(); ?> <?php _e('at', 'westpace-material'); ?> <?php comment_time(); ?>
                            </time>
                        </a>
                        <?php edit_comment_link(__('Edit', 'westpace-material'), '<span class="edit-link">', '</span>'); ?>
                    </div>
                    
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'westpace-material'); ?></p>
                    <?php endif; ?>
                </footer>
                
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
                
                <div class="reply">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => 'div-comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'before' => '<div class="reply-link">',
                        'after' => '</div>'
                    )));
                    ?>
                </div>
            </article>
        <?php
    }
}

/**
 * Get theme option with default fallback
 */
function westpace_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

/**
 * Check if we're on a blog page
 */
function westpace_is_blog() {
    return (is_home() || is_archive() || is_category() || is_tag() || is_author() || is_date() || is_search());
}

/**
 * Display archive header
 */
function westpace_archive_header() {
    if (!westpace_is_blog() || is_front_page()) {
        return;
    }
    
    echo '<header class="archive-header">';
    echo '<div class="container">';
    
    if (is_home() && !is_front_page()) {
        echo '<h1 class="archive-title">' . get_the_title(get_option('page_for_posts')) . '</h1>';
    } elseif (is_category()) {
        echo '<h1 class="archive-title">' . single_cat_title('', false) . '</h1>';
        $category_description = category_description();
        if (!empty($category_description)) {
            echo '<div class="archive-description">' . $category_description . '</div>';
        }
    } elseif (is_tag()) {
        echo '<h1 class="archive-title">' . single_tag_title('', false) . '</h1>';
        $tag_description = tag_description();
        if (!empty($tag_description)) {
            echo '<div class="archive-description">' . $tag_description . '</div>';
        }
    } elseif (is_author()) {
        echo '<h1 class="archive-title">' . get_the_author() . '</h1>';
        $author_description = get_the_author_meta('description');
        if (!empty($author_description)) {
            echo '<div class="archive-description">' . esc_html($author_description) . '</div>';
        }
    } elseif (is_date()) {
        if (is_year()) {
            echo '<h1 class="archive-title">' . get_the_date('Y') . '</h1>';
        } elseif (is_month()) {
            echo '<h1 class="archive-title">' . get_the_date('F Y') . '</h1>';
        } elseif (is_day()) {
            echo '<h1 class="archive-title">' . get_the_date() . '</h1>';
        }
    } elseif (is_search()) {
        echo '<h1 class="archive-title">' . sprintf(__('Search Results for: %s', 'westpace-material'), get_search_query()) . '</h1>';
    }
    
    echo '</div>';
    echo '</header>';
}
?>