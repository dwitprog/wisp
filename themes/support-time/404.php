<?php
/**
 * Страница 404 — оформление в стиле сайта (градиент, типографика, кнопка на главную).
 *
 * @package WordPress
 * @subpackage support-time
 */

get_header();
?>
<main id="main" class="site-main st-page-404" role="main">
    <div class="st-page-404__inner">
        <p class="st-page-404__code gradient-text" aria-hidden="true">404</p>
        <h1 class="st-page-404__title">Page not found</h1>
        <p class="st-page-404__desc">
            The page you are looking for does not exist or may have been moved.
        </p>
        <a class="btn btn-gradient st-page-404__btn" href="<?php echo esc_url(home_url('/')); ?>">Back to home</a>
    </div>
</main>
<?php
get_footer();
