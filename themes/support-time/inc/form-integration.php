<?php

/**
 * Проверка настроек форм (почта + YetiForce). Уведомление в админке WP.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @return bool
 */
function st_form_is_yetiforce_configured(): bool
{
    return defined('ST_YETIFORCE_URL')
        && ST_YETIFORCE_URL !== ''
        && defined('ST_YETIFORCE_API_KEY')
        && ST_YETIFORCE_API_KEY !== ''
        && defined('ST_YETIFORCE_USER')
        && ST_YETIFORCE_USER !== ''
        && defined('ST_YETIFORCE_PASSWORD')
        && ST_YETIFORCE_PASSWORD !== '';
}

/**
 * @return bool
 */
function st_form_is_smtp_configured(): bool
{
    return defined('ST_SMTP_HOST')
        && ST_SMTP_HOST !== ''
        && defined('ST_SMTP_USER')
        && defined('ST_SMTP_PASS');
}

/**
 * @return list<string>
 */
function st_form_integration_missing(): array
{
    $missing = array();

    if (!st_form_is_yetiforce_configured()) {
        $missing[] = 'YetiForce CRM (ST_YETIFORCE_*)';
    }
    if (!st_form_is_smtp_configured()) {
        $missing[] = 'SMTP (ST_SMTP_HOST, ST_SMTP_USER, ST_SMTP_PASS)';
    }

    return $missing;
}

/**
 * @return bool
 */
function st_form_integration_ready(): bool
{
    return st_form_integration_missing() === [];
}

/**
 * Предупреждение в админке, если секреты не заданы на сервере.
 */
function st_form_integration_admin_notice(): void
{
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    if (st_form_integration_ready()) {
        return;
    }

    $missing = implode(', ', st_form_integration_missing());
    $paths = 'wp-content/st-config-local.php или themes/support-time/inc/config-local.php';

    echo '<div class="notice notice-error"><p><strong>Complex Wisps:</strong> не настроена отправка форм — '
        . esc_html($missing)
        . '. Создайте конфиг на сервере: '
        . esc_html($paths)
        . ' (см. st-config-local.example.php в репозитории).</p></div>';
}

add_action('admin_notices', 'st_form_integration_admin_notice');
