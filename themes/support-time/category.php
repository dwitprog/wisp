<?php
/**
 * A Simple Category Template
 */

get_header(); ?>

<main id="main" class="site-main page-news">


    <section class="container">
        <h1><?= single_cat_title() ?></h1>
        <?php if (have_posts()) :
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
    </section>
</main><!-- .site-main -->

<?php get_footer(); ?>
