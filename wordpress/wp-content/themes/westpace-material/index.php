<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Westpace_Material
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-layout <?php echo westpace_has_sidebar() ? 'has-sidebar' : 'full-width'; ?>">
            
            <div class="main-content">
                <?php westpace_archive_header(); ?>
                
                <?php if (have_posts()) : ?>
                    
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card material-card elevation-2'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                            <?php the_post_thumbnail('westpace-featured', array('alt' => the_title_attribute(array('echo' => false)))); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <header class="entry-header">
                                        <?php
                                        if (is_singular()) :
                                            the_title('<h1 class="entry-title">', '</h1>');
                                        else :
                                            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                        endif;
                                        ?>
                                        
                                        <?php if ('post' === get_post_type()) : ?>
                                            <div class="entry-meta">
                                                <?php westpace_post_meta(); ?>
                                                <?php westpace_reading_time(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </header>
                                    
                                    <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <footer class="entry-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more-link btn btn-outline btn-sm">
                                            <span class="material-icons">arrow_forward</span>
                                            <?php _e('Read More', 'westpace-material'); ?>
                                        </a>
                                    </footer>
                                </div>
                                
                            </article>
                            
                        <?php endwhile; ?>
                    </div>
                    
                    <?php westpace_posts_navigation(); ?>
                    
                <?php else : ?>
                    
                    <section class="no-results not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php _e('Nothing here', 'westpace-material'); ?></h1>
                        </header>
                        
                        <div class="page-content">
                            <?php if (is_home() && current_user_can('publish_posts')) : ?>
                                
                                <p><?php
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
                                ?></p>
                                
                            <?php elseif (is_search()) : ?>
                                
                                <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'westpace-material'); ?></p>
                                <?php get_search_form(); ?>
                                
                            <?php else : ?>
                                
                                <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'westpace-material'); ?></p>
                                <?php get_search_form(); ?>
                                
                            <?php endif; ?>
                        </div>
                    </section>
                    
                <?php endif; ?>
            </div>
            
            <?php if (westpace_has_sidebar()) : ?>
                <aside class="sidebar">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>
            
        </div>
    </div>
</main>

<?php
get_footer();