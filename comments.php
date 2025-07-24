<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Devochki
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php
    if (have_comments()) {
        ?>
        <div class="comments-title">
            <?php
            $devochki_comment_count = get_comments_number();
            if ('1' === $devochki_comment_count) {
                printf(
                    esc_html__('Коментарий', 'pt-luna') . ':',
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        'Коментарии:',
                        'Коментарии:',
                        $devochki_comment_count,
                        'comments title',
                        'pt-luna'
                    )),
                    number_format_i18n($devochki_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </div>

        <?php the_comments_navigation(); ?>

        <div class="comment-list">
            <?php
            wp_list_comments(
                [
                    'comment' => 'comment',
                    'callback'   => 'showTemplateComment'
                ]
            );
            ?>
        </div>

        <?php
        the_comments_navigation();
        
        if (! comments_open()) {
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'pt-luna'); ?></p>
            <?php
        }
    }
        
        $defaults = [
            'fields' => [
                'author' => '<div class="comment-form-author">
                    <input
                        id="author"
                        name="author"
                        type="text"
                        value=""
                        required="required"
                        oninput="this.value = this.value.replace(/<[^>]*>/g, ``)"
                        placeholder="' . esc_html__('Имя', 'pt-luna') . ':"
                    />
                </div>',
            ],
            'comment_field' => '<div class="comment-form-comment">
                <textarea
                id="comment"
                name="comment"
                aria-required="true"
                required="required"
                oninput="this.value = this.value.replace(/<[^>]*>/g, ``)"
                placeholder="' . esc_html__('Коментарий', 'pt-luna') . ':">'
               . '</textarea>
            </div>',
            'must_log_in' => '',
            'logged_in_as' => '<p class="logged-in-as">' .
                sprintf(
                    wp_kses(
                        __('Вы вошли как: <a href="%1$s">%2$s</a>. <a href="%3$s">Выйти?</a>', 'pt-luna'),
                        array(
                            'a' => array(
                                'href' => array(),
                            ),
                        )
                    ),
                    get_edit_user_link(),
                    $user_identity,
                    wp_logout_url()
                ) . '</p>',
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
            'id_form'              => 'commentform',
            'id_submit'            => 'submit',
            'class_container'      => 'comment-respond',
            'class_form'           => 'comment-form',
            'class_submit'         => 'submit',
            'name_submit'          => 'submit',
            'title_reply'          => __('Leave a Reply'),
            'title_reply_to'       => __('Leave a Reply to %s'),
            'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
            'title_reply_after'    => '</h3>',
            'cancel_reply_link'    => __('Cancel reply'),
            'label_submit'         => __('Post Comment'),
            'submit_button'        => '<input  name="%1$s" type="submit" id="%2$s" class="%3$s btn" value="%4$s" />',
            'submit_field'         => '<p class="form-submit">%1$s %2$s</p>',
            'format'               => 'xhtml',
        ];
        
        comment_form($defaults);
        ?>

</div>
