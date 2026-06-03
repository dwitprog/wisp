<?php
/**
 * Шаблон страницы Terms of Use (URL: /terms-of-use/).
 *
 * @package WordPress
 * @subpackage support-time
 */

get_header();

while (have_posts()) :
    the_post();
    $article_attr = sprintf(
        'id="post-%d" class="%s"',
        (int) get_the_ID(),
        esc_attr(implode(' ', get_post_class('', get_the_ID())))
    );
    st_render_terms_of_use_main(get_the_title() ?: 'Terms of Use', $article_attr);
endwhile;

get_footer();
