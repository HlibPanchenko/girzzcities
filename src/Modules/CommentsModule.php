<?php

namespace ESC\Luna\Modules;

class CommentsModule
{
    public static function registerHooks(): void
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'addSupportTreeComments']);
        add_filter('get_comment_text', [__CLASS__, 'removeHtmlForComments']);
        add_filter('pre_comment_content', [__CLASS__, 'removeLinkComment']);
        add_filter('comment_text', [__CLASS__, 'removeLinkComment']);

        add_filter('wp_list_comments_args', [__CLASS__, 'customizeCommentsTemplate']);
        add_filter('get_comment_text', [__CLASS__, 'removeHtmlForComments']);
    }

    public static function addSupportTreeComments(): void
    {
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    public static function removeHtmlForComments($comment): string
    {
        return wp_strip_all_tags($comment);
    }

    public static function removeLinkComment($link_text): string
    {
        return strip_tags($link_text);
    }
    
    public static function customizeCommentsTemplate($args): array
    {
        $args['callback'] = [__CLASS__, 'showTemplateComment'];
        return $args;
    }
    
    public static function showTemplateComment($comment, $args, $depth): void
    {
        $tag = 'div';
        if ('div' === $args['style']) {
            $add_below = 'comment';
        } else {
            $add_below = 'div-comment';
        }
        ?>
        
        <<?php echo $tag; ?>
            <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>
        id="comment-<?php comment_ID() ?>">
        <?php if ('div' !== $args['style']) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php } ?>
        
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) {
                echo get_avatar($comment, $args['avatar_size']);
            }
                printf(__('<span class="fn">%s:</span>'), get_comment_author_link());
            ?>
        </div>
        
        <?php if ($comment->comment_approved == '0') { ?>
            <?php _e('Your comment is awaiting moderation.'); ?>
        <br/>
        <?php } ?>
        
        <div class="comment-meta commentmetadata">
            <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                <?php
                    /* translators: 1: date, 2: time */
                    printf(
                        __('%1$s at %2$s'),
                        get_comment_date(),
                        get_comment_time()
                    );
                ?>
            </a>
            <?php edit_comment_link(__('(Edit)'), '  ', ''); ?>
        </div>
        
        <?php comment_text(); ?>
        
        <?php
        $rating = get_comment_meta($comment->comment_ID, 'comments_score', true);
        
        if (!empty($rating)) :
            ?>
            <div class="comment-rating"><?php echo esc_html__('Оценка', 'pt-luna')?>: <span><?php echo esc_html($rating); ?>★</span></div>
        <?php endif; ?>
        
        <div class="reply">
            <?php
                comment_reply_link(
                    array_merge(
                        $args,
                        [
                            'add_below' => $add_below,
                            'depth' => $depth,
                            'max_depth' => $args['max_depth']
                        ]
                    )
                );
            ?>
        </div>
        
        <?php if ('div' !== $args['style']) { ?>
        </div>
        <?php } ?>
        <?php
    }
}
