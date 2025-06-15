<?php
/**
 * Template Functions for Westpace Material Theme
 * Helper functions for template rendering and theme functionality
 * 
 * @package Westpace_Material
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get the hero section for the homepage
 */
function westpace_get_hero_section() {
    if (!get_theme_mod('show_hero_section', true)) {
        return;
    }

    $hero_title = get_theme_mod('hero_title', __('West Pace Apparels', 'westpace-material'));
    $hero_subtitle = get_theme_mod('hero_subtitle', __('Premium Garment Manufacturing Since 1998', 'westpace-material'));
    $hero_description = get_theme_mod('hero_description', __('Family-owned Fijian company specializing in school wear, workwear, and winterwear for Australian and South Pacific markets.', 'westpace-material'));
    $hero_cta_text = get_theme_mod('hero_cta_text', __('Shop Now', 'westpace-material'));
    $hero_cta_url = get_theme_mod('hero_cta_url', '#');
    $hero_bg_image = get_theme_mod('hero_background_image', WESTPACE_THEME_URI . '/assets/images/hero-bg.jpg');

    ?>
    <section class="hero-section" style="background-image: url('<?php echo esc_url($hero_bg_image); ?>');">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
                <h2 class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></h2>
                <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
                <?php if ($hero_cta_text && $hero_cta_url) : ?>
                    <div class="hero-actions">
                        <a href="<?php echo esc_url($hero_cta_url); ?>" class="btn btn-primary btn-lg">
                            <?php echo esc_html($hero_cta_text); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Display breadcrumb navigation
 */
function westpace_breadcrumb() {
    if (is_front_page()) {
        return;
    }

    $separator = '<span class="breadcrumb-separator">/</span>';
    $home_title = __('Home', 'westpace-material');

    echo '<nav class="breadcrumb-navigation" aria-label="' . esc_attr__('Breadcrumb', 'westpace-material') . '">';
    echo '<ol class="breadcrumb-list">';
    
    // Home link
    echo '<li class="breadcrumb-item">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html($home_title) . '</a>';
    echo '</li>';

    if (is_single()) {
        // Single post
        $category = get_the_category();
        if (!empty($category)) {
            echo '<li class="breadcrumb-item">';
            echo $separator;
            echo '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>';
            echo '</li>';
        }
        
        echo '<li class="breadcrumb-item active">';
        echo $separator;
        echo '<span>' . get_the_title() . '</span>';
        echo '</li>';
        
    } elseif (is_page()) {
        // Single page
        $parent_pages = array();
        $page_id = get_the_ID();
        
        while ($page_id) {
            $page = get_page($page_id);
            $parent_pages[] = $page;
            $page_id = $page->post_parent;
        }
        
        $parent_pages = array_reverse($parent_pages);
        
        foreach ($parent_pages as $key => $page) {
            echo '<li class="breadcrumb-item' . (($key === count($parent_pages) - 1) ? ' active' : '') . '">';
            echo $separator;
            
            if ($key === count($parent_pages) - 1) {
                echo '<span>' . esc_html($page->post_title) . '</span>';
            } else {
                echo '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a>';
            }
            echo '</li>';
        }
        
    } elseif (is_category()) {
        // Category archive
        echo '<li class="breadcrumb-item active">';
        echo $separator;
        echo '<span>' . single_cat_title('', false) . '</span>';
        echo '</li>';
        
    } elseif (is_tag()) {
        // Tag archive
        echo '<li class="breadcrumb-item active">';
        echo $separator;
        echo '<span>' . single_tag_title('', false) . '</span>';
        echo '</li>';
        
    } elseif (is_search()) {
        // Search results
        echo '<li class="breadcrumb-item active">';
        echo $separator;
        echo '<span>' . sprintf(__('Search Results for: %s', 'westpace-material'), get_search_query()) . '</span>';
        echo '</li>';
        
    } elseif (is_404()) {
        // 404 page
        echo '<li class="breadcrumb-item active">';
        echo $separator;
        echo '<span>' . __('Page Not Found', 'westpace-material') . '</span>';
        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

/**
 * Display post meta information
 */
function westpace_post_meta() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf($time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    echo '<div class="post-meta">';
    
    // Date
    echo '<span class="post-date">';
    echo '<span class="material-icons-round">schedule</span>';
    echo $time_string;
    echo '</span>';
    
    // Author
    echo '<span class="post-author">';
    echo '<span class="material-icons-round">person</span>';
    echo '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>';
    echo '</span>';
    
    // Categories
    $categories_list = get_the_category_list(', ');
    if ($categories_list) {
        echo '<span class="post-categories">';
        echo '<span class="material-icons-round">folder</span>';
        echo $categories_list;
        echo '</span>';
    }
    
    // Comments count
    if (comments_open() || get_comments_number()) {
        echo '<span class="post-comments">';
        echo '<span class="material-icons-round">comment</span>';
        comments_popup_link(
            __('Leave a comment', 'westpace-material'),
            __('1 Comment', 'westpace-material'),
            __('% Comments', 'westpace-material')
        );
        echo '</span>';
    }
    
    echo '</div>';
}

/**
 * Display post navigation
 */
function westpace_post_navigation() {
    $previous_post = get_previous_post();
    $next_post = get_next_post();
    
    if (!$previous_post && !$next_post) {
        return;
    }
    
    echo '<nav class="post-navigation" aria-label="' . esc_attr__('Post Navigation', 'westpace-material') . '">';
    echo '<div class="nav-links">';
    
    if ($previous_post) {
        echo '<div class="nav-previous">';
        echo '<a href="' . esc_url(get_permalink($previous_post)) . '" class="nav-link">';
        echo '<span class="nav-label">' . __('Previous Post', 'westpace-material') . '</span>';
        echo '<span class="nav-title">' . esc_html(get_the_title($previous_post)) . '</span>';
        echo '</a>';
        echo '</div>';
    }
    
    if ($next_post) {
        echo '<div class="nav-next">';
        echo '<a href="' . esc_url(get_permalink($next_post)) . '" class="nav-link">';
        echo '<span class="nav-label">' . __('Next Post', 'westpace-material') . '</span>';
        echo '<span class="nav-title">' . esc_html(get_the_title($next_post)) . '</span>';
        echo '</a>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</nav>';
}

/**
 * Custom pagination
 */
function westpace_pagination() {
    $pagination = paginate_links(array(
        'type'      => 'array',
        'prev_text' => '<span class="material-icons-round">chevron_left</span> ' . __('Previous', 'westpace-material'),
        'next_text' => __('Next', 'westpace-material') . ' <span class="material-icons-round">chevron_right</span>',
    ));

    if (!$pagination) {
        return;
    }

    echo '<nav class="pagination-navigation" aria-label="' . esc_attr__('Posts Navigation', 'westpace-material') . '">';
    echo '<ul class="pagination">';
    
    foreach ($pagination as $key => $page_link) {
        $class = 'page-item';
        if (strpos($page_link, 'current') !== false) {
            $class .= ' active';
        }
        if (strpos($page_link, 'prev') !== false) {
            $class .= ' prev';
        }
        if (strpos($page_link, 'next') !== false) {
            $class .= ' next';
        }
        
        echo '<li class="' . esc_attr($class) . '">';
        echo str_replace('page-numbers', 'page-link', $page_link);
        echo '</li>';
    }
    
    echo '</ul>';
    echo '</nav>';
}

/**
 * Get social media links
 */
function westpace_get_social_links() {
    $social_links = array(
        'facebook'  => get_theme_mod('social_facebook', ''),
        'twitter'   => get_theme_mod('social_twitter', ''),
        'instagram' => get_theme_mod('social_instagram', ''),
        'linkedin'  => get_theme_mod('social_linkedin', ''),
        'youtube'   => get_theme_mod('social_youtube', ''),
    );
    
    $social_icons = array(
        'facebook'  => 'facebook',
        'twitter'   => 'twitter',
        'instagram' => 'instagram',
        'linkedin'  => 'linkedin',
        'youtube'   => 'youtube',
    );
    
    if (array_filter($social_links)) {
        echo '<div class="social-links">';
        
        foreach ($social_links as $platform => $url) {
            if ($url) {
                echo '<a href="' . esc_url($url) . '" class="social-link social-' . esc_attr($platform) . '" target="_blank" rel="noopener noreferrer">';
                echo '<span class="material-icons-round">' . esc_html($social_icons[$platform]) . '</span>';
                echo '<span class="screen-reader-text">' . esc_html(ucfirst($platform)) . '</span>';
                echo '</a>';
            }
        }
        
        echo '</div>';
    }
}

/**
 * Display featured products (if WooCommerce is active)
 */
function westpace_featured_products($limit = 4) {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'   => '_featured',
                'value' => 'yes'
            )
        )
    );
    
    $featured_products = new WP_Query($args);
    
    if ($featured_products->have_posts()) {
        echo '<section class="featured-products">';
        echo '<div class="container">';
        echo '<h2 class="section-title">' . __('Featured Products', 'westpace-material') . '</h2>';
        echo '<div class="products-grid">';
        
        while ($featured_products->have_posts()) {
            $featured_products->the_post();
            wc_get_template_part('content', 'product');
        }
        
        echo '</div>';
        echo '</div>';
        echo '</section>';
        
        wp_reset_postdata();
    }
}

/**
 * Get reading time estimate
 */
function westpace_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    if ($reading_time === 1) {
        return __('1 min read', 'westpace-material');
    } else {
        return sprintf(__('%d min read', 'westpace-material'), $reading_time);
    }
}

/**
 * Custom comment callback
 */
function westpace_comment_callback($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    
    echo '<' . $tag . ' id="comment-' . get_comment_ID() . '" class="comment-item">';
    
    echo '<div class="comment-body">';
    echo '<div class="comment-author">';
    echo get_avatar($comment, 48, '', '', array('class' => 'avatar'));
    echo '<cite class="fn">' . get_comment_author_link() . '</cite>';
    echo '<span class="comment-date">' . get_comment_date() . '</span>';
    echo '</div>';
    
    if ('0' == $comment->comment_approved) {
        echo '<p class="comment-awaiting-moderation">' . __('Your comment is awaiting moderation.', 'westpace-material') . '</p>';
    }
    
    echo '<div class="comment-content">';
    comment_text();
    echo '</div>';
    
    echo '<div class="comment-meta">';
    comment_reply_link(array_merge($args, array(
        'depth'     => $depth,
        'max_depth' => $args['max_depth'],
        'reply_text' => __('Reply', 'westpace-material'),
    )));
    edit_comment_link(__('Edit', 'westpace-material'));
    echo '</div>';
    
    echo '</div>';
}

/**
 * Get theme colors for use in templates
 */
function westpace_get_theme_colors() {
    return array(
        'primary'   => get_theme_mod('westpace_primary_color', '#1976D2'),
        'secondary' => get_theme_mod('westpace_secondary_color', '#FF6D00'),
        'text'      => get_theme_mod('westpace_text_color', '#0F172A'),
        'background' => get_theme_mod('westpace_background_color', '#FFFFFF'),
    );
}

/**
 * Check if we're on a WooCommerce page
 */
function westpace_is_woocommerce_page() {
    if (!class_exists('WooCommerce')) {
        return false;
    }
    
    return is_woocommerce() || is_cart() || is_checkout() || is_account_page();
}

/**
 * Get the appropriate sidebar for current page
 */
function westpace_get_sidebar() {
    $sidebar = 'sidebar-1';
    
    if (westpace_is_woocommerce_page()) {
        $sidebar = 'shop-sidebar';
    }
    
    return apply_filters('westpace_sidebar', $sidebar);
}

/**
 * Check if sidebar should be displayed
 */
function westpace_has_sidebar() {
    $sidebar_position = get_theme_mod('sidebar_position', 'right');
    
    if ($sidebar_position === 'none') {
        return false;
    }
    
    if (is_front_page() || is_page_template('page-fullwidth.php')) {
        return false;
    }
    
    return is_active_sidebar(westpace_get_sidebar());
}

/**
 * Get body classes for layout
 */
function westpace_body_classes($classes) {
    $sidebar_position = get_theme_mod('sidebar_position', 'right');
    
    if (westpace_has_sidebar()) {
        $classes[] = 'has-sidebar';
        $classes[] = 'sidebar-' . $sidebar_position;
    } else {
        $classes[] = 'no-sidebar';
    }
    
    if (westpace_is_woocommerce_page()) {
        $classes[] = 'woocommerce-page';
    }
    
    return $classes;
}
add_filter('body_class', 'westpace_body_classes');

/**
 * Newsletter signup form
 */
function westpace_newsletter_form() {
    ?>
    <form class="newsletter-form" data-action="westpace_newsletter">
        <div class="newsletter-input-group">
            <input type="email" 
                   name="email" 
                   placeholder="<?php esc_attr_e('Enter your email', 'westpace-material'); ?>" 
                   required>
            <button type="submit" class="btn btn-primary">
                <span class="material-icons-round">mail</span>
                <?php esc_html_e('Subscribe', 'westpace-material'); ?>
            </button>
        </div>
        <p class="newsletter-message"></p>
    </form>
    <?php
}

/**
 * Contact form
 */
function westpace_contact_form() {
    ?>
    <form class="contact-form material-card" data-action="westpace_contact_form">
        <div class="form-row">
            <div class="form-group">
                <label for="contact-name"><?php esc_html_e('Name', 'westpace-material'); ?> *</label>
                <input type="text" id="contact-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="contact-email"><?php esc_html_e('Email', 'westpace-material'); ?> *</label>
                <input type="email" id="contact-email" name="email" required>
            </div>
        </div>
        <div class="form-group">
            <label for="contact-subject"><?php esc_html_e('Subject', 'westpace-material'); ?></label>
            <input type="text" id="contact-subject" name="subject">
        </div>
        <div class="form-group">
            <label for="contact-message"><?php esc_html_e('Message', 'westpace-material'); ?> *</label>
            <textarea id="contact-message" name="message" rows="5" required></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-lg">
                <span class="material-icons-round">send</span>
                <?php esc_html_e('Send Message', 'westpace-material'); ?>
            </button>
        </div>
        <p class="contact-message"></p>
    </form>
    <?php
}