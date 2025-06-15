<?php
/**
 * Template Functions for Westpace Material Theme
 * Helper functions for template rendering and theme functionality
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
            <div class="hero-content animate-fade-in">
                <?php if ($hero_title) : ?>
                    <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
                <?php endif; ?>
                
                <?php if ($hero_subtitle) : ?>
                    <h2 class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></h2>
                <?php endif; ?>
                
                <?php if ($hero_description) : ?>
                    <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
                <?php endif; ?>
                
                <div class="hero-actions">
                    <?php if ($hero_cta_text && $hero_cta_url) : ?>
                        <a href="<?php echo esc_url($hero_cta_url); ?>" class="btn btn-primary btn-lg">
                            <?php echo esc_html($hero_cta_text); ?>
                            <span class="material-icons">arrow_forward</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-outline btn-lg">
                            <?php _e('Browse Products', 'westpace-material'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Get services section for homepage
 */
function westpace_get_services_section() {
    if (!get_theme_mod('show_services_section', true)) {
        return;
    }

    $services = array(
        array(
            'icon' => 'school',
            'title' => __('School Wear', 'westpace-material'),
            'description' => __('High-quality uniforms for educational institutions across the Pacific region.', 'westpace-material'),
        ),
        array(
            'icon' => 'work',
            'title' => __('Work Wear', 'westpace-material'),
            'description' => __('Durable and professional workwear for various industries and professions.', 'westpace-material'),
        ),
        array(
            'icon' => 'ac_unit',
            'title' => __('Winter Wear', 'westpace-material'),
            'description' => __('Warm and comfortable winter clothing designed for cooler climates.', 'westpace-material'),
        ),
        array(
            'icon' => 'verified',
            'title' => __('Quality Assurance', 'westpace-material'),
            'description' => __('Rigorous quality control ensures every garment meets our high standards.', 'westpace-material'),
        ),
    );

    ?>
    <section class="services-section py-20 bg-gray-50">
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    <?php _e('Our Specialties', 'westpace-material'); ?>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    <?php _e('With over 25 years of experience, we deliver premium garments tailored to your needs.', 'westpace-material'); ?>
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($services as $service) : ?>
                    <div class="material-card p-6 text-center hover:elevation-3 transition-all duration-300">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-icons text-primary-600 text-3xl"><?php echo esc_attr($service['icon']); ?></span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-gray-900"><?php echo esc_html($service['title']); ?></h3>
                        <p class="text-gray-600 leading-relaxed"><?php echo esc_html($service['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Get featured products section
 */
function westpace_get_featured_products_section() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    $featured_products = wc_get_featured_product_ids();
    if (empty($featured_products)) {
        return;
    }

    $products = wc_get_products(array(
        'include' => array_slice($featured_products, 0, 8),
        'status' => 'publish',
    ));

    if (empty($products)) {
        return;
    }

    ?>
    <section class="featured-products-section py-20">
        <div class="container">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    <?php _e('Featured Products', 'westpace-material'); ?>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    <?php _e('Discover our most popular garments, trusted by customers across the region.', 'westpace-material'); ?>
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <?php foreach ($products as $product) : ?>
                    <div class="product-card material-card overflow-hidden hover:elevation-3 transition-all duration-300">
                        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
                            <?php if ($product->get_image_id()) : ?>
                                <div class="product-image overflow-hidden">
                                    <?php echo wp_get_attachment_image($product->get_image_id(), 'product-featured', false, array('class' => 'w-full h-64 object-cover transition-transform duration-300 hover:scale-110')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2 text-gray-900"><?php echo esc_html($product->get_name()); ?></h3>
                                <div class="text-xl font-bold text-primary-600 mb-4"><?php echo $product->get_price_html(); ?></div>
                                
                                <?php if ($product->get_short_description()) : ?>
                                    <p class="text-gray-600 text-sm mb-4"><?php echo wp_strip_all_tags($product->get_short_description()); ?></p>
                                <?php endif; ?>
                                
                                <div class="flex items-center justify-between">
                                    <?php echo apply_filters('woocommerce_loop_add_to_cart_link',
                                        sprintf('<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                            esc_url($product->add_to_cart_url()),
                                            esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                                            esc_attr(isset($args['class']) ? $args['class'] : 'btn btn-primary btn-sm'),
                                            isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                                            esc_html($product->add_to_cart_text())
                                        ),
                                        $product, $args
                                    ); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn-outline btn-lg">
                    <?php _e('View All Products', 'westpace-material'); ?>
                    <span class="material-icons">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Get breadcrumbs
 */
function westpace_get_breadcrumbs() {
    if (is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    echo '<div class="container">';
    echo '<ol class="breadcrumb-list flex items-center space-x-2 text-sm">';

    // Home link
    echo '<li class="breadcrumb-item">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="text-primary-600 hover:text-primary-700">';
    echo '<span class="material-icons text-base">home</span>';
    echo '<span class="sr-only">' . __('Home', 'westpace-material') . '</span>';
    echo '</a>';
    echo '</li>';

    if (is_category() || is_single()) {
        echo '<li class="breadcrumb-separator"><span class="material-icons text-gray-400">chevron_right</span></li>';
        
        if (is_single()) {
            $category = get_the_category();
            if ($category) {
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '" class="text-primary-600 hover:text-primary-700">';
                echo esc_html($category[0]->name);
                echo '</a>';
                echo '</li>';
                echo '<li class="breadcrumb-separator"><span class="material-icons text-gray-400">chevron_right</span></li>';
            }
            echo '<li class="breadcrumb-item text-gray-700">' . get_the_title() . '</li>';
        } else {
            echo '<li class="breadcrumb-item text-gray-700">' . single_cat_title('', false) . '</li>';
        }
    } elseif (is_page()) {
        echo '<li class="breadcrumb-separator"><span class="material-icons text-gray-400">chevron_right</span></li>';
        echo '<li class="breadcrumb-item text-gray-700">' . get_the_title() . '</li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumb-separator"><span class="material-icons text-gray-400">chevron_right</span></li>';
        echo '<li class="breadcrumb-item text-gray-700">' . sprintf(__('Search Results for "%s"', 'westpace-material'), get_search_query()) . '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumb-separator"><span class="material-icons text-gray-400">chevron_right</span></li>';
        echo '<li class="breadcrumb-item text-gray-700">' . __('Page Not Found', 'westpace-material') . '</li>';
    }

    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}

/**
 * Get post meta information
 */
function westpace_get_post_meta() {
    if (!is_single() && !is_page()) {
        return;
    }

    ?>
    <div class="post-meta flex items-center space-x-6 text-sm text-gray-600 mb-6">
        <div class="flex items-center space-x-2">
            <span class="material-icons text-base">person</span>
            <span><?php _e('By', 'westpace-material'); ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-primary-600 hover:text-primary-700"><?php the_author(); ?></a></span>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="material-icons text-base">schedule</span>
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo get_the_date(); ?></time>
        </div>
        
        <?php if (has_category()) : ?>
            <div class="flex items-center space-x-2">
                <span class="material-icons text-base">folder</span>
                <span><?php the_category(', '); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (comments_open()) : ?>
            <div class="flex items-center space-x-2">
                <span class="material-icons text-base">comment</span>
                <span><a href="<?php comments_link(); ?>" class="text-primary-600 hover:text-primary-700"><?php comments_number(__('0 Comments', 'westpace-material'), __('1 Comment', 'westpace-material'), __('% Comments', 'westpace-material')); ?></a></span>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Get social sharing buttons
 */
function westpace_get_social_sharing() {
    if (!is_single()) {
        return;
    }

    $post_title = urlencode(get_the_title());
    $post_url = urlencode(get_permalink());
    $post_excerpt = urlencode(get_the_excerpt());

    $facebook_url = "https://www.facebook.com/sharer/sharer.php?u={$post_url}";
    $twitter_url = "https://twitter.com/intent/tweet?text={$post_title}&url={$post_url}";
    $linkedin_url = "https://www.linkedin.com/sharing/share-offsite/?url={$post_url}";
    $email_url = "mailto:?subject={$post_title}&body={$post_excerpt}%20{$post_url}";

    ?>
    <div class="social-sharing bg-gray-50 p-6 rounded-lg">
        <h4 class="text-lg font-semibold mb-4 text-gray-900"><?php _e('Share this post', 'westpace-material'); ?></h4>
        <div class="flex space-x-3">
            <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener" class="btn btn-ghost p-3" aria-label="<?php _e('Share on Facebook', 'westpace-material'); ?>">
                <span class="material-icons">facebook</span>
            </a>
            <a href="<?php echo esc_url($twitter_url); ?>" target="_blank" rel="noopener" class="btn btn-ghost p-3" aria-label="<?php _e('Share on Twitter', 'westpace-material'); ?>">
                <span class="material-icons">twitter</span>
            </a>
            <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener" class="btn btn-ghost p-3" aria-label="<?php _e('Share on LinkedIn', 'westpace-material'); ?>">
                <span class="material-icons">linkedin</span>
            </a>
            <a href="<?php echo esc_url($email_url); ?>" class="btn btn-ghost p-3" aria-label="<?php _e('Share via email', 'westpace-material'); ?>">
                <span class="material-icons">email</span>
            </a>
        </div>
    </div>
    <?php
}

/**
 * Get related posts
 */
function westpace_get_related_posts($post_id = null, $limit = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $categories = wp_get_post_categories($post_id);
    if (empty($categories)) {
        return;
    }

    $related_posts = get_posts(array(
        'category__in' => $categories,
        'post__not_in' => array($post_id),
        'posts_per_page' => $limit,
        'orderby' => 'rand'
    ));

    if (empty($related_posts)) {
        return;
    }

    ?>
    <section class="related-posts mt-16 pt-16 border-t border-gray-200">
        <h3 class="text-2xl font-bold mb-8 text-gray-900"><?php _e('Related Posts', 'westpace-material'); ?></h3>
        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                <article class="material-card overflow-hidden hover:elevation-3 transition-all duration-300">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="block">
                            <?php the_post_thumbnail('blog-featured', array('class' => 'w-full h-48 object-cover')); ?>
                        </a>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h4 class="text-lg font-semibold mb-3">
                            <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary-600 transition-colors"><?php the_title(); ?></a>
                        </h4>
                        <p class="text-gray-600 text-sm mb-4"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo get_the_date(); ?></time>
                            <a href="<?php the_permalink(); ?>" class="text-primary-600 hover:text-primary-700 font-medium">
                                <?php _e('Read More', 'westpace-material'); ?>
                                <span class="material-icons text-sm ml-1">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    wp_reset_postdata();
}

/**
 * Get pagination
 */
function westpace_get_pagination() {
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    // Add current page to the array
    if ($paged >= 1) {
        $links[] = $paged;
    }

    // Add the pages around the current page to the array
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    ?>
    <nav class="pagination flex justify-center mt-12" aria-label="<?php _e('Posts navigation', 'westpace-material'); ?>">
        <div class="flex items-center space-x-2">
            <?php if (get_previous_posts_link()) : ?>
                <div class="previous-posts">
                    <?php previous_posts_link('<span class="btn btn-outline"><span class="material-icons">chevron_left</span> ' . __('Previous', 'westpace-material') . '</span>'); ?>
                </div>
            <?php endif; ?>

            <?php
            // Link to first page, plus ellipses if necessary
            if (!in_array(1, $links)) {
                $class = 1 == $paged ? 'btn btn-primary' : 'btn btn-ghost';
                printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link(1)), $class, '1');

                if (!in_array(2, $links)) {
                    echo '<span class="dots">…</span>';
                }
            }

            // Link to current page, plus 2 pages in either direction if necessary
            sort($links);
            foreach ((array) $links as $link) {
                $class = $paged == $link ? 'btn btn-primary' : 'btn btn-ghost';
                printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link($link)), $class, $link);
            }

            // Link to last page, plus ellipses if necessary
            if (!in_array($max, $links)) {
                if (!in_array($max - 1, $links)) {
                    echo '<span class="dots">…</span>';
                }

                $class = $paged == $max ? 'btn btn-primary' : 'btn btn-ghost';
                printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link($max)), $class, $max);
            }
            ?>

            <?php if (get_next_posts_link()) : ?>
                <div class="next-posts">
                    <?php next_posts_link('<span class="btn btn-outline">' . __('Next', 'westpace-material') . ' <span class="material-icons">chevron_right</span></span>'); ?>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <?php
}

/**
 * Get site logo
 */
function westpace_get_site_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    
    if ($custom_logo_id) {
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        echo '<a href="' . esc_url(home_url('/')) . '" class="site-logo">';
        echo '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="max-h-12 w-auto">';
        echo '</a>';
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '" class="site-title text-2xl font-bold text-gray-900 hover:text-primary-600 transition-colors">';
        echo esc_html(get_bloginfo('name'));
        echo '</a>';
    }
}

/**
 * Get footer social links
 */
function westpace_get_footer_social_links() {
    $social_networks = array(
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'youtube' => 'YouTube',
    );

    $has_social = false;
    foreach ($social_networks as $network => $label) {
        if (get_theme_mod("social_{$network}")) {
            $has_social = true;
            break;
        }
    }

    if (!$has_social) {
        return;
    }

    echo '<div class="social-links flex space-x-4">';
    foreach ($social_networks as $network => $label) {
        $url = get_theme_mod("social_{$network}");
        if ($url) {
            printf(
                '<a href="%s" target="_blank" rel="noopener" class="text-gray-400 hover:text-white transition-colors" aria-label="%s">
                    <span class="material-icons">%s</span>
                </a>',
                esc_url($url),
                esc_attr(sprintf(__('Follow us on %s', 'westpace-material'), $label)),
                esc_attr($network)
            );
        }
    }
    echo '</div>';
}

/**
 * Check if page has sidebar
 */
function westpace_has_sidebar() {
    if (is_404() || is_page_template('page-full-width.php')) {
        return false;
    }

    if (is_shop() || is_product_category() || is_product_tag()) {
        return get_theme_mod('shop_sidebar', 'left') !== 'none';
    }

    return get_theme_mod('sidebar_position', 'right') !== 'none';
}

/**
 * Get sidebar position
 */
function westpace_get_sidebar_position() {
    if (is_shop() || is_product_category() || is_product_tag()) {
        return get_theme_mod('shop_sidebar', 'left');
    }

    return get_theme_mod('sidebar_position', 'right');
}