<?php
/**
 * Шаблон для отображения контента на главной странице
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->
