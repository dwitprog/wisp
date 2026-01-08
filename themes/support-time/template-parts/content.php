<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */
?>
<div class="all-page-fon-white-news">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title(sprintf('<h2 style="padding-top: 40px;" class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
        </header><!-- .entry-header -->
        <div class="row">
            <div class="col-md-9">
                <div class="entry-content"><?php the_excerpt(); ?></div>
            </div>
            <div class="col-md-3">
                <footer class="entry-footer"><?php RSTheme_entry_meta(); ?></footer>
            </div>
        </div>
    </article><!-- #post-## -->
</div>
