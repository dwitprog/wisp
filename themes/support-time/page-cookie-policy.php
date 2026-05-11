<?php
/**
 * Шаблон страницы политики cookies (URL со slug: cookie-policy, например /cookie-policy/).
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
    st_render_cookie_policy_main(get_the_title() ?: 'Cookie Policy', $article_attr);
endwhile;

get_footer();
