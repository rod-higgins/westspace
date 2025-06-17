<?php
/**
 * The template for displaying comments
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Westpace_Material
 * @version 3.0.0
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <span class="material-icons-round">comment</span>
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'westpace-material'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        '%1$s comment on &ldquo;%2$s&rdquo;',
                        '%1$s comments on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'westpace-material'
                    )),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'westpace_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'westpace-material'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().

    comment_form(array(
        'title_reply'          => __('Leave a Reply', 'westpace-material'),
        'title_reply_to'       => __('Leave a Reply to %s', 'westpace-material'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_before'  => '<small>',
        'cancel_reply_after'   => '</small>',
        'label_submit'         => __('Post Comment', 'westpace-material'),
        'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary" value="%4$s" />',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', 'westpace-material') . ' <span class="required">*</span></label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
        'fields'               => array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'westpace-material') . ' <span class="required">*</span></label> ' . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . __('Email', 'westpace-material') . ' <span class="required">*</span></label> ' . '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . __('Website', 'westpace-material') . '</label> ' . '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" /></p>',
        ),
        'class_container'      => 'comment-respond material-card elevation-2',
        'class_form'           => 'comment-form',
    ));
    ?>

</div>

<?php
/**
 * Custom comment callback function
 */
function westpace_comment_callback($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? 'parent' : '', $comment); ?> id="comment-<?php comment_ID(); ?>">
    <?php if ('div' !== $args['style']) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <?php endif; ?>
    
    <div class="comment-author vcard">
        <?php if ($args['avatar_size'] != 0) : ?>
            <?php echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'avatar')); ?>
        <?php endif; ?>
        
        <div class="comment-metadata">
            <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()); ?>
            <div class="comment-meta commentmetadata">
                <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                    <?php
                    printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time());
                    ?>
                </a>
                <?php edit_comment_link(__('(Edit)'), '&nbsp;&nbsp;', ''); ?>
            </div>
        </div>
    </div>

    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></em>
        <br />
    <?php endif; ?>

    <div class="comment-content">
        <?php comment_text(); ?>
    </div>

    <div class="reply">
        <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
    </div>
    
    <?php if ('div' !== $args['style']) : ?>
        </div>
    <?php endif; ?>
    <?php
}
?>

<style>
/* Comments Styles */
.comments-area {
    margin: var(--space-12) 0;
    background: white;
    border-radius: var(--radius-xl);
    padding: var(--space-8);
    box-shadow: var(--shadow-md);
}

.comments-title {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    font-size: var(--text-2xl);
    font-weight: var(--font-weight-bold);
    color: var(--gray-900);
    margin-bottom: var(--space-8);
    border-bottom: 2px solid var(--gray-200);
    padding-bottom: var(--space-4);
}

.comment-list {
    list-style: none;
    padding: 0;
    margin: 0 0 var(--space-8) 0;
}

.comment-list .comment {
    margin-bottom: var(--space-6);
    padding: var(--space-6);
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    border-left: 4px solid var(--primary-500);
}

.comment-list .children {
    list-style: none;
    margin-left: var(--space-8);
    margin-top: var(--space-6);
}

.comment-body {
    display: flex;
    gap: var(--space-4);
}

.avatar {
    border-radius: var(--radius-full);
    flex-shrink: 0;
}

.comment-author .fn {
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    font-style: normal;
}

.comment-metadata {
    flex: 1;
}

.comment-meta {
    font-size: var(--text-sm);
    color: var(--gray-600);
    margin-top: var(--space-1);
}

.comment-meta a {
    color: var(--gray-600);
    text-decoration: none;
}

.comment-meta a:hover {
    color: var(--primary-600);
}

.comment-content {
    margin: var(--space-4) 0;
    line-height: 1.6;
}

.comment-awaiting-moderation {
    color: var(--warning-600);
    font-style: italic;
    margin: var(--space-2) 0;
}

.reply {
    margin-top: var(--space-4);
}

.comment-reply-link {
    display: inline-flex;
    align-items: center;
    gap: var(--space-1);
    color: var(--primary-600);
    text-decoration: none;
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    padding: var(--space-2) var(--space-3);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.comment-reply-link:hover {
    background: var(--primary-50);
    color: var(--primary-700);
    text-decoration: none;
}

.comment-respond {
    background: white;
    padding: var(--space-8);
    border-radius: var(--radius-lg);
    margin-top: var(--space-8);
}

.comment-reply-title {
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--gray-900);
    margin-bottom: var(--space-6);
}

.comment-form {
    display: grid;
    gap: var(--space-4);
}

.comment-form p {
    margin: 0;
}

.comment-form label {
    display: block;
    font-weight: var(--font-weight-medium);
    color: var(--gray-700);
    margin-bottom: var(--space-2);
}

.comment-form input[type="text"],
.comment-form input[type="email"],
.comment-form input[type="url"],
.comment-form textarea {
    width: 100%;
    padding: var(--space-3);
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    font-size: var(--text-base);
    transition: border-color var(--transition-fast);
}

.comment-form input:focus,
.comment-form textarea:focus {
    outline: none;
    border-color: var(--primary-600);
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.required {
    color: var(--error-500);
}

.form-submit {
    text-align: right;
}

.no-comments {
    text-align: center;
    color: var(--gray-600);
    font-style: italic;
    margin: var(--space-8) 0;
}

/* Navigation */
.comment-navigation {
    margin: var(--space-6) 0;
}

.comment-navigation .nav-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.comment-navigation a {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-4);
    background: var(--gray-100);
    color: var(--gray-700);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.comment-navigation a:hover {
    background: var(--primary-600);
    color: white;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .comment-list .children {
        margin-left: var(--space-4);
    }
    
    .comment-body {
        flex-direction: column;
    }
    
    .comments-area {
        padding: var(--space-6);
    }
    
    .comment-respond {
        padding: var(--space-6);
    }
}
</style>