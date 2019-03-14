<?php
if (!function_exists('epstarter_the_posts_navigation')) :

    /**
     * Documentation for function.
     */
    function epstarter_the_posts_navigation() {
        the_posts_pagination(
                array(
                    'mid_size' => 2,
                    'prev_text' => sprintf('<i class="fa fa-chevron-left"></i> <span class="nav-prev-text">%s</span>', __('Newer posts', 'epstarter')),
                    'next_text' => sprintf('<span class="nav-next-text">%s</span> <i class="fa fa-chevron-right"></i>', __('Older posts', 'epstarter')),
                )
        );
    }

endif;

if (!function_exists('epstarter_post_thumbnail')) :

    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function epstarter_post_thumbnail($size = "post-thumbnail", $attr = []) {
        if (!epstarter_can_show_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <figure class="post-thumbnail">
            <?php the_post_thumbnail($size, $attr); ?>
            </figure><!-- .post-thumbnail -->

            <?php
        else :
            ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" title="<?php echo $attr['title']; ?>" aria-hidden="true" tabindex="-1">
                    <?php
                    the_post_thumbnail($size, $attr);
                    ?>
                </a>
            </figure>

        <?php
        endif; // End is_singular().
    }

endif;

/**
 * Determines if post thumbnail can be displayed.
 */
function epstarter_can_show_post_thumbnail() {
    return apply_filters('epstarter_can_show_post_thumbnail', !post_password_required() && !is_attachment() && has_post_thumbnail());
}

/**
 * Add custom sizes attribute to responsive image functionality for post thumbnails.
 *
 * @param array $attr  Attributes for the image markup.
 * @return string Value for use in post thumbnail 'sizes' attribute.
 */
function epstarter_post_thumbnail_sizes_attr($attr) {

    if (is_admin()) {
        return $attr;
    }

    if (!is_singular()) {
        $attr['sizes'] = '(max-width: 34.9rem) calc(100vw - 2rem), (max-width: 53rem) calc(8 * (100vw / 12)), (min-width: 53rem) calc(6 * (100vw / 12)), 100vw';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'epstarter_post_thumbnail_sizes_attr', 10, 1);

if (!function_exists('epstarter_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function epstarter_entry_footer() {

        // Hide author, post date, category and tag text for pages.
        if ('post' === get_post_type()) {

            // Posted by
            epstarter_posted_by();

            echo " | ";

            // Posted on
            epstarter_posted_on();

            echo " | ";

            /* translators: used between list items, there is a space after the comma. */
            $categories_list = get_the_category_list(__(', ', 'epstarter'));
            if ($categories_list) {
                /* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
                printf(
                        '<span class="cat-links"><i class="fa fa-thumbtack"></i> <span class="screen-reader-text">%1$s</span>%2$s</span>', __('Posted in ', 'epstarter'), $categories_list
                ); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma. */
            $tags_list = get_the_tag_list('', __(', ', 'epstarter'));
            if ($tags_list) {
                echo " | ";
                /* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of tags. */
                printf(
                        '<span class="tags-links"><i class="fa fa-tags"></i> <span class="screen-reader-text">%1$s </span>%2$s</span>', __('Tags:', 'epstarter'), $tags_list
                ); // WPCS: XSS OK.
            }
        }

        // Comment count.
        if (!is_singular()) {
            epstarter_comment_count();
        }

        // Edit post link.
        edit_post_link(
                sprintf(
                        wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers. */
                                __('Edit <span class="screen-reader-text">%s</span>', 'epstarter'), array(
            'span' => array(
                'class' => array(),
            ),
                                )
                        ), get_the_title()
                ), '<span class="edit-link"><i class="fa fa-edit"></i></span>'
        );
    }

endif;


if (!function_exists('epstarter_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function epstarter_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
                $time_string, esc_attr(get_the_date(DATE_W3C)), esc_html(get_the_date()), esc_attr(get_the_modified_date(DATE_W3C)), esc_html(get_the_modified_date())
        );

        printf(
                '<span class="posted-on"><i class="fa fa-clock"></i> <a href="%1$s" rel="bookmark">%2$s</a></span>', esc_url(get_permalink()), $time_string
        );
    }

endif;

if (!function_exists('epstarter_posted_by')) :

    /**
     * Prints HTML with meta information about theme author.
     */
    function epstarter_posted_by() {
        printf(
                '<span class="byline"><i class="fa fa-user"></i> <span class="screen-reader-text">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
                /* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */ __('Posted by ', 'epstarter'), esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())
        );
    }

endif;


if (!function_exists('epstarter_comment_count')) :

    /**
     * Prints HTML with the comment count for the current post.
     */
    function epstarter_comment_count() {
        if (!post_password_required() && ( comments_open() || get_comments_number() )) {
            echo ' | <span class="comments-link"><i class="fa fa-comment"></i> ';

            /* translators: %s: Name of current post. Only visible to screen readers. */
            comments_popup_link(sprintf(__('Leave a comment<span class="screen-reader-text"> on %s</span>', 'epstarter'), get_the_title()));

            echo '</span>';
        }
    }

endif;

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function epstarter_pingback_header() {
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
    }
}

add_action('wp_head', 'epstarter_pingback_header');
?>
