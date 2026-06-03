<?php
/**
 * Шаблон California Privacy Policy / CCPA (URL: /california-privacy-policy/).
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
    st_render_california_privacy_policy_main(
        get_the_title() ?: 'California Privacy Policy (CCPA)',
        $article_attr
    );
endwhile;

get_footer();
