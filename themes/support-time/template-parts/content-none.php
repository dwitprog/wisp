<?php
/**
 * Шаблон, когда записи отсутствуют
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e('Nothing Found', 'rstheme'); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>

            <p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'rstheme'), esc_url(admin_url('post-new.php'))); ?></p>

        <?php elseif (is_search()) : ?>

            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rstheme'); ?></p>
            <?php get_search_form(); ?>

        <?php else : ?>

            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'rstheme'); ?></p>
            <?php get_search_form(); ?>

        <?php endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->
