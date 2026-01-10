<?php
/**
 * Часть шаблона для отображения отдельных записей
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since My Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
</article>
