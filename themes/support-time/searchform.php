<?php
/**
 * Template for displaying search forms in support-time
 *
 * @package WordPress
 * @subpackage My_Theme
 * @since support-time 1.9.96
 */
?>

<form method="get" class="search-form d-flex" action="<?= site_url() ?>">
    <div class="form-floating w-100">
        <input type="search" class="form-control" id="inlineFormInputSearchToSite" name="s" placeholder="Что ищем?"
               value="<?php echo get_search_query(); ?>">
        <label for="inlineFormInputSearchToSite">Что ищем?</label>
    </div>
    <button type="submit" class="btn search-submit"><span class="screen-reader-text">Найти</span></button>
</form>
