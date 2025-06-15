<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class("single-post material-card elevation-2"); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail("blog-featured"); ?>
                    </div>
                <?php endif; ?>
                
                <header class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
                    <div class="post-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <span class="post-author"><?php the_author(); ?></span>
                        <span class="post-categories"><?php the_category(", "); ?></span>
                    </div>
                </header>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="post-footer">
                    <?php the_tags("<div class=\"post-tags\">", "", "</div>"); ?>
                </footer>
            </article>
            
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>