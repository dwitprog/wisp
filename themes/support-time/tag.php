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


<main id="main" class="site-main">


    <section style="padding-top: 15px">
        <div class="container">
            <?php if (have_posts()) :
                ?>
                <div class="row">
                    <div class="col-md-8">
                        <?php
                        while (have_posts()) : the_post();
                            get_template_part('template-parts/blog-all', get_post_format());
                        endwhile;
                        ?>
                    </div>
                    <aside id="sidebar" class="col-md-4 right-sidebar">
                        <?php if (!dynamic_sidebar()) : ?>
                        <?php endif; ?>
                    </aside>
                </div>
                <div>
                    <?= get_the_posts_pagination() ?>
                </div>
            <?php
            else : get_template_part('template-parts/content', 'none');

            endif; ?>
        </div>
    </section>
</main><!-- .site-main -->


<?php get_footer(); ?>
