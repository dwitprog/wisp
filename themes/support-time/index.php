<?php
/**
 * Основной файл шаблона
 *
 * Это самый общий файл шаблона в теме WordPress
 * и один из двух необходимых файлов для темы (другой стиль style.css)
 * Он используется для отображения страницы, когда ничего более конкретного не соответствует запросу.
 * Например, он объединяет домашнюю страницу, когда нет home-page.php файла.
 *
 * @package WordPress
 * @subpackage RSTheme
 * @since RSTheme 1.0
 */

get_header(); ?>

<main id="main" class="site-main page-blog">


    <div class="container">

        <?php if (is_home() && !is_front_page()) : ?>
            <h1><?= single_post_title() ?></h1>
        <?php endif;
        if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('template-parts/blog-all', get_post_format());
            endwhile;
            ?>
            <div>
                <?= get_the_posts_pagination() ?>
            </div>
        <?php
        else : get_template_part('template-parts/content', 'none');
        endif; ?>

    </div>
</main><!-- .site-main -->

<?php get_footer(); ?>
