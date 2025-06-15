<?php
/**
 * Template part for displaying posts
 *
 * @package Westpace_Material
 * @version 3.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card material-card elevation-2'); ?>>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail('blog-featured', array('loading' => 'lazy')); ?>
            </a>
            
            <?php if (is_sticky()) : ?>
                <div class="post-badge sticky-badge">
                    <span class="material-icons-round">push_pin</span>
                    <span><?php esc_html_e('Featured', 'westpace-material'); ?></span>
                </div>
            <?php endif; ?>
            
            <div class="post-overlay">
                <div class="post-meta-overlay">
                    <span class="post-date">
                        <span class="material-icons-round">schedule</span>
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="reading-time">
                        <span class="material-icons-round">schedule</span>
                        <?php echo westpace_get_reading_time(); ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="post-content">
        
        <?php if (has_category()) : ?>
            <div class="post-categories">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="post-category">';
                    echo esc_html($categories[0]->name);
                    echo '</a>';
                }
                ?>
            </div>
        <?php endif; ?>

        <header class="post-header">
            <?php
            if (is_singular()) :
                the_title('<h1 class="post-title">', '</h1>');
            else :
                the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>
        </header>

        <div class="post-excerpt">
            <?php
            if (is_singular()) {
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
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'westpace-material'),
                    'after'  => '</div>',
                ));
            } else {
                the_excerpt();
            }
            ?>
        </div>

        <footer class="post-footer">
            <div class="post-meta">
                <div class="post-author">
                    <span class="material-icons-round">person</span>
                    <span class="author-name">
                        <?php esc_html_e('By', 'westpace-material'); ?>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php the_author(); ?>
                        </a>
                    </span>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="post-comments">
                        <span class="material-icons-round">comment</span>
                        <?php
                        comments_popup_link(
                            esc_html__('Leave a comment', 'westpace-material'),
                            esc_html__('1 Comment', 'westpace-material'),
                            esc_html__('% Comments', 'westpace-material')
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!is_singular()) : ?>
                <div class="post-actions">
                    <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm read-more-btn">
                        <span><?php esc_html_e('Read More', 'westpace-material'); ?></span>
                        <span class="material-icons-round">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </footer>

        <?php if (is_singular()) : ?>
            <div class="post-tags">
                <?php
                $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'westpace-material'));
                if ($tags_list) {
                    printf('<div class="tags-wrapper"><span class="material-icons-round">local_offer</span><span class="tags-list">%s</span></div>', $tags_list);
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</article>