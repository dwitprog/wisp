<?php

/**
 * Cookie Policy: контент, виртуальная страница при отсутствии записи в БД,
 * автосоздание страницы при активации темы / заходе в админку,
 * баннер согласия (стили в main.scss — .st-cookie-consent; вывод в wp_body_open для корректного position:fixed).
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Разметка основного блока Cookie Policy (общая для шаблона и «виртуальной» страницы).
 *
 * @param string $title Заголовок H1.
 * @param string $article_attributes Атрибуты тега article (безопасно собирать через esc_attr там, где нужно).
 */
function st_render_cookie_policy_main(string $title, string $article_attributes = 'class="post"'): void
{
    ?>
<main id="main" class="site-main page-h1">
    <div class="container">
        <h1><?php echo esc_html($title); ?></h1>
        <article <?php
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- строка атрибутов формируется вызывающим кодом (литерал или esc_attr).
        echo $article_attributes;
        ?>>
            <p>
                This page describes how this website uses cookies and similar technologies. By continuing to browse
                the site, you agree to the use of cookies in line with this policy (unless you have disabled them in
                your browser).
            </p>

            <h2>What are cookies?</h2>
            <p>
                Cookies are small text files that are placed on your computer or mobile device when you visit a
                website. They are widely used to make websites work more efficiently, remember your preferences, and
                understand how visitors use the site.
            </p>

            <h2>How we use cookies</h2>
            <p>We may use cookies for purposes such as:</p>
            <ul>
                <li>remembering your preferences and settings;</li>
                <li>measuring traffic and how the site is used (analytics);</li>
                <li>improving performance and security;</li>
                <li>supporting features of forms and interactive content where applicable.</li>
            </ul>

            <h2>Your choices</h2>
            <p>
                Most web browsers allow you to control cookies through their settings. You can refuse or delete
                cookies; however, some parts of the site may not work as intended if you disable essential cookies.
            </p>

            <h2>Updates</h2>
            <p>
                We may update this Cookie Policy from time to time. The “Last updated” date may be shown on this page
                when changes are made. We encourage you to review this page periodically.
            </p>

            <p>
                For questions about this policy, please use the contact details provided on our
                <a href="/contacts/">Contacts</a> page.
            </p>
        </article>
    </div>
</main>
    <?php
}

/**
 * Создаёт страницу cookie-policy при возможности (права publish_pages).
 */
function st_ensure_cookie_policy_page_callback(): void
{
    if (wp_installing() || wp_doing_ajax()) {
        return;
    }

    if (!current_user_can('publish_pages')) {
        return;
    }

    $slug = 'cookie-policy';
    $existing = get_posts(
        array(
            'post_type' => 'page',
            'name' => $slug,
            'post_status' => array('publish', 'draft', 'pending', 'private'),
            'posts_per_page' => 1,
            'fields' => 'ids',
            'no_found_rows' => true,
        )
    );

    if (!empty($existing)) {
        return;
    }

    $id = wp_insert_post(
        array(
            'post_title' => 'Cookie Policy',
            'post_name' => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
        ),
        true
    );

    if (!is_wp_error($id) && $id) {
        flush_rewrite_rules(false);
    }
}

add_action('after_switch_theme', 'st_ensure_cookie_policy_page_callback');
add_action('admin_init', 'st_ensure_cookie_policy_page_callback');

/**
 * Если записи страницы нет, отдаём тот же контент с кодом 200 (без 404).
 */
function st_cookie_policy_maybe_virtual(): void
{
    if (is_admin()) {
        return;
    }

    $path = isset($_SERVER['REQUEST_URI']) ? (string) wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    $path = trim($path, '/');
    if ($path !== 'cookie-policy') {
        return;
    }

    $existing = get_posts(
        array(
            'post_type' => 'page',
            'name' => 'cookie-policy',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'no_found_rows' => true,
        )
    );

    if (!empty($existing)) {
        return;
    }

    status_header(200);
    nocache_headers();
    get_header();
    st_render_cookie_policy_main('Cookie Policy', 'class="post"');
    get_footer();
    exit;
}

add_action('template_redirect', 'st_cookie_policy_maybe_virtual', 0);

/**
 * HTML баннера согласия.
 */
function st_cookie_consent_render(): void
{
    if (is_admin()) {
        return;
    }
    ?>
<div id="st-cookie-consent" class="st-cookie-consent" role="dialog" aria-labelledby="st-cookie-consent-label" aria-live="polite" hidden>
    <p id="st-cookie-consent-label" class="st-cookie-consent__text">This site uses cookies.</p>
    <div class="st-cookie-consent__actions">
        <a href="/cookie-policy/" class="st-cookie-consent__btn st-cookie-consent__btn--secondary">Read more</a>
        <button type="button" class="st-cookie-consent__btn st-cookie-consent__btn--primary" data-st-cookie-accept>
            Accept
        </button>
    </div>
</div>
    <?php
}

add_action('wp_body_open', 'st_cookie_consent_render', 5);

/**
 * Скрипт баннера (после main).
 */
function st_cookie_consent_script(): void
{
    if (is_admin()) {
        return;
    }
    $script = <<<'JS'
(function () {
    var key = 'st_cookie_consent';
    var yearSec = 365 * 24 * 60 * 60;
    var yearMs = yearSec * 1000;
    var banner = document.getElementById('st-cookie-consent');
    if (!banner) return;
    var acceptBtn = banner.querySelector('[data-st-cookie-accept]');
    function lsValid(raw) {
        if (!raw) return false;
        if (raw === 'accepted') return true;
        try {
            var o = JSON.parse(raw);
            if (o && typeof o.t === 'number' && Date.now() - o.t < yearMs) return true;
        } catch (e) {}
        return false;
    }
    function hasConsent() {
        try {
            if (lsValid(localStorage.getItem(key))) return true;
        } catch (e) {}
        return /(?:^|; )st_cookie_consent=accepted(?:;|$)/.test(document.cookie);
    }
    function pruneStaleLs() {
        try {
            var raw = localStorage.getItem(key);
            if (!raw || raw === 'accepted') return;
            var o = JSON.parse(raw);
            if (o && typeof o.t === 'number' && Date.now() - o.t >= yearMs) {
                localStorage.removeItem(key);
            }
        } catch (e) {}
    }
    function saveConsent() {
        var payload = JSON.stringify({ t: Date.now() });
        try {
            localStorage.setItem(key, payload);
        } catch (e) {}
        try {
            document.cookie = key + '=accepted; path=/; max-age=' + yearSec + '; SameSite=Lax';
        } catch (e) {}
        banner.remove();
    }
    pruneStaleLs();
    if (hasConsent()) {
        banner.remove();
        return;
    }
    banner.hidden = false;
    if (acceptBtn) acceptBtn.addEventListener('click', saveConsent);
})();
JS;
    wp_add_inline_script('main', $script, 'after');
}

add_action('wp_enqueue_scripts', 'st_cookie_consent_script', 25);
