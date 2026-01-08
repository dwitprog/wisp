<?php
/**
 * Шаблон для отображения основных страниц (Не для главной)
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
</article><!-- #post-## -->
