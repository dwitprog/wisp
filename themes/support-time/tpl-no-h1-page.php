<?php
/**
 * Шаблон для отображения страниц без H1
 *
 * Это шаблон, который отображает все страницы по умолчанию.
 * Обратите внимание, что это WordPress конструкция страниц и что
 * другие "страницы" на Вашем сайте WordPress будут использовать другой шаблон.
 *
 * Template name: Без H1
 * Template post type: post, page
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */

get_header() ?>

<main id="main" class="site-main">
    <?php

    while (have_posts()) : the_post();
        get_template_part('template-parts/content-page', 'single');
    endwhile;

    ?>
</main>

<?php get_footer(); ?>
