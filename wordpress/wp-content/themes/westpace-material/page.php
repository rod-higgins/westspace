<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class("page-content material-card elevation-2"); ?>>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="page-content-inner">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>