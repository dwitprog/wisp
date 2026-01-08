<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */

get_header(); ?>

<main id="main" class="site-main page-search">

    <div class="container">
        <?php if (have_posts()) : ?>
            <h1>Результаты поиска: <span><?= esc_html(get_search_query()) ?></span></h1>
            <div class="search-result">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID() ?>" class="mb-4 <?= join(' ', get_post_class()) ?>">
                        <h5 class="title pb-0 text-start"
                            itemprop="headline"><?php the_title(sprintf('<a href="%s">', esc_url(get_permalink())), '</a>'); ?></h5>
                        <?php if (get_the_excerpt()): ?>
                            <p class="desc mt-3 mb-0">
                                <?= get_the_excerpt() ?>
                            </p>
                        <?php endif; ?>
                        <p class="mb-0"><a href="<?= get_permalink() ?>"
                                           class="btn btn_link btn_icon bi bi-arrow-right">Перейти</a></p>
                    </article>
                <?php endwhile; ?>
            </div>
            <nav class="pagination d-flex flex-wrap justify-content-center">
                <?= paginate_links(
                    array(
                        'mid_size' => 3,
                        'end_size' => 2,
                        'prev_text' => '«',
                        'next_text' => '»',
                    )
                ) ?>
            </nav>
        <?php else : ?>
            <h1>По вашему запросу <span><?= esc_html(get_search_query()) ?></span> ничего не найдено...</h1>
            <?php echo get_search_form();
        endif;
        ?>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>
