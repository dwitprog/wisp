<?php
/**
 * Шаблон для отображения страниц архива
 *
 * Используется для отображения страниц архивного типа, если запрос не совпадает ни с чем более конкретным.
 * Например, складывает страницы на основе даты, если нет date-page.php файла.
 *
 * Если вы хотите дополнительно настроить эти архивные представления, вы можете создать
 * новый файл шаблона для каждого из них. Например, tag.php (Архив тегов),
 * category.php (Категория архивы), author.php (авторские архивы) и др.
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */

get_header(); ?>

<main id="main" class="site-main">

    <header class="page-header">
        <div class="container">
            <?php
            the_archive_title('<h1>', '</h1>');
            the_archive_description('<div class="taxonomy-description">', '</div>');
            ?>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <?php if (have_posts()) : ?>

                <?php
                // Запуск цикла.
                while (have_posts()) : the_post();

                    /*
                     * Включение шаблона содержимого для определенного формата.
                     * Если вы хотите переопределить это в дочерней теме, включите файл
                     * под названием "content" -___.php (где ___ - имя формата записи), который будет использоваться вместо него.
                     */
                    get_template_part('template-parts/blog-all', get_post_format());

                    // Выход из цикла.
                endwhile;
            // Если нет содержимого, включите шаблон "Новостей пока нет!".
            else :
                get_template_part('template-parts/content', 'none');

            endif;
            ?>
        </div>
        <div class="">
            <?= get_the_posts_pagination() ?>
        </div>
    </div>
</main><!-- .site-main -->


<?php get_footer(); ?>
