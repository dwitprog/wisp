<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */
?>

<?php if (is_active_sidebar('sidebar-1')) : ?>
    <aside id="secondary" class="sidebar widget-area">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </aside><!-- .sidebar .widget-area -->
<?php endif; ?>
