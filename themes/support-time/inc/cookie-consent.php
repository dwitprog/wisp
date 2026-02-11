<?php

/**
 * Cookie consent banner: HTML, styles, and script.
 * Text: We use cookies to enhance your browsing experience...
 * Consent stored in localStorage (key: st_cookie_consent).
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output cookie banner HTML before </body>.
 */
function st_cookie_consent_render(): void
{
    if (is_admin()) {
        return;
    }
    $consent = isset($_COOKIE['st_cookie_consent']) ? $_COOKIE['st_cookie_consent'] : null;
    if ($consent === null && function_exists('wp_add_inline_script')) {
        // Also check localStorage via inline script
    }
    ?>
    <div id="st-cookie-consent" class="st-cookie-consent" role="dialog" aria-label="Cookie consent" style="display: none;">
        <div class="st-cookie-consent__inner">
            <p class="st-cookie-consent__text">
                We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.
            </p>
            <button type="button" class="st-cookie-consent__btn" id="st-cookie-consent-accept">Accept All</button>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'st_cookie_consent_render', 5);

/**
 * Inline CSS for cookie banner.
 */
function st_cookie_consent_styles(): void
{
    if (is_admin()) {
        return;
    }
    $css = '
    .st-cookie-consent {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 99999;
        padding: 16px 24px;
        background: linear-gradient(182deg, #130839, #282251);
        color: #fff;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
        font-family: inherit;
    }
    .st-cookie-consent__inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }
    .st-cookie-consent__text {
        margin: 0;
        flex: 1;
        min-width: 280px;
        font-size: 14px;
        line-height: 1.5;
    }
    .st-cookie-consent__btn {
        flex-shrink: 0;
        padding: 12px 24px;
        background: #fff;
        color: #130839;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
    }
    .st-cookie-consent__btn:hover {
        opacity: 0.9;
    }
    @media (max-width: 575px) {
        .st-cookie-consent__inner { flex-direction: column; text-align: center; }
        .st-cookie-consent__text { min-width: 100%; }
    }
    ';
    wp_add_inline_style('styles', $css);
}

add_action('wp_enqueue_scripts', 'st_cookie_consent_styles', 15);

/**
 * Inline script: show banner if no consent, set cookie on Accept.
 */
function st_cookie_consent_script(): void
{
    if (is_admin()) {
        return;
    }
    $script = <<<'JS'
(function() {
    var key = 'st_cookie_consent';
    var banner = document.getElementById('st-cookie-consent');
    var btn = document.getElementById('st-cookie-consent-accept');
    if (!banner || !btn) return;
    function getConsent() {
        try {
            return localStorage.getItem(key) || (document.cookie.match(/st_cookie_consent=([^;]+)/) && RegExp.$1) || null;
        } catch (e) { return null; }
    }
    function setConsent() {
        try {
            localStorage.setItem(key, '1');
            document.cookie = 'st_cookie_consent=1; path=/; max-age=31536000; SameSite=Lax';
        } catch (e) {}
        banner.style.display = 'none';
    }
    if (getConsent() === '1') {
        banner.style.display = 'none';
        return;
    }
    banner.style.display = 'block';
    btn.addEventListener('click', setConsent);
})();
JS;
    wp_add_inline_script('main', $script, 'after');
}

add_action('wp_enqueue_scripts', 'st_cookie_consent_script', 20);
