<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-layout <?php echo westpace_has_sidebar() ? 'has-sidebar' : 'full-width'; ?>">
            
            <div class="main-content">
                <?php if (have_posts()) : ?>

                    <?php if (is_home() && !is_front_page()) : ?>
                        <header class="page-header">
                            <h1 class="page-title"><?php single_post_title(); ?></h1>
                            <?php
                            $description = get_the_archive_description();
                            if ($description) :
                                ?>
                                <div class="archive-description"><?php echo $description; ?></div>
                            <?php endif; ?>
                        </header>
                    <?php endif; ?>

                    <?php if (is_archive()) : ?>
                        <header class="page-header">
                            <?php
                            the_archive_title('<h1 class="page-title">', '</h1>');
                            $description = get_the_archive_description();
                            if ($description) :
                                ?>
                                <div class="archive-description"><?php echo $description; ?></div>
                            <?php endif; ?>
                        </header>
                    <?php endif; ?>

                    <?php if (is_search()) : ?>
                        <header class="page-header">
                            <h1 class="page-title">
                                <?php
                                printf(
                                    esc_html__('Search Results for: %s', 'westpace-material'),
                                    '<span class="search-term">' . get_search_query() . '</span>'
                                );
                                ?>
                            </h1>
                            <p class="search-results-count">
                                <?php
                                global $wp_query;
                                $total = $wp_query->found_posts;
                                if ($total == 1) {
                                    printf(esc_html__('Found %d result', 'westpace-material'), $total);
                                } else {
                                    printf(esc_html__('Found %d results', 'westpace-material'), $total);
                                }
                                ?>
                            </p>
                        </header>
                    <?php endif; ?>

                    <div class="posts-container">
                        <?php if (is_home() || is_archive() || is_search()) : ?>
                            <div class="posts-grid">
                                <?php
                                while (have_posts()) :
                                    the_post();
                                    get_template_part('template-parts/content', get_post_type());
                                endwhile;
                                ?>
                            </div>
                        <?php else : ?>
                            <?php
                            while (have_posts()) :
                                the_post();
                                get_template_part('template-parts/content', get_post_type());
                            endwhile;
                            ?>
                        <?php endif; ?>
                    </div>

                    <?php westpace_pagination(); ?>

                <?php else : ?>

                    <?php get_template_part('template-parts/content', 'none'); ?>

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

<?php
get_footer();
?>