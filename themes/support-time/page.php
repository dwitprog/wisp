<?php
/**
 * Шаблон для отображения страниц
 *
 * Это шаблон, который отображает все страницы по умолчанию.
 * Обратите внимание, что это WordPress конструкция страниц и что
 * другие "страницы" на Вашем сайте WordPress будут использовать другой шаблон.
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */

get_header() ?>

<main id="main" class="site-main page-h1">


    <div class="container">
        <h1><?= the_title() ?></h1>
    

    <?php

    while (have_posts()) : the_post();
        get_template_part('template-parts/content-page', 'single');
    endwhile;

    ?>
    </div>
</main>

<?php get_footer(); ?>
