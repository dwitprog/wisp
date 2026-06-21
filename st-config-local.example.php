<?php

/**
 * Конфиг форм и CRM для боевого сервера.
 *
 * 1) Скопируйте в wp-content/st-config-local.php (рекомендуется — не затирается при git pull).
 * 2) Либо в themes/support-time/inc/config-local.php.
 * 3) Либо константы в wp-config.php (до require wp-settings.php).
 *
 * Файл с реальными паролями НЕ коммитить в git.
 */

// --- YetiForce CRM ---
if (!defined('ST_YETIFORCE_URL')) {
    define('ST_YETIFORCE_URL', 'https://complexwisps.yetiforce.eu');
}
if (!defined('ST_YETIFORCE_API_KEY')) {
    define('ST_YETIFORCE_API_KEY', 'PASTE_API_KEY_FROM_YETIFORCE');
}
if (!defined('ST_YETIFORCE_USER')) {
    define('ST_YETIFORCE_USER', 'webservice-username');
}
if (!defined('ST_YETIFORCE_PASSWORD')) {
    define('ST_YETIFORCE_PASSWORD', 'webservice-password');
}
// Если Basic Auth в CRM отличается от webservice user:
// define('ST_YETIFORCE_BASIC_AUTH_USER', 'basic-auth-user');
// define('ST_YETIFORCE_BASIC_AUTH_PASSWORD', 'basic-auth-password');

// --- Почта (SMTP обязателен на shared-хостинге) ---
if (!defined('ST_SMTP_HOST')) {
    define('ST_SMTP_HOST', 'mail.complexwisps.com'); // или smtp хостинга
}
if (!defined('ST_SMTP_PORT')) {
    define('ST_SMTP_PORT', 587);
}
if (!defined('ST_SMTP_SECURE')) {
    define('ST_SMTP_SECURE', 'tls'); // tls | ssl | '' для без шифрования
}
if (!defined('ST_SMTP_USER')) {
    define('ST_SMTP_USER', 'contact.us@complexwisps.com');
}
if (!defined('ST_SMTP_PASS')) {
    define('ST_SMTP_PASS', 'PASTE_MAILBOX_PASSWORD');
}
if (!defined('ST_SMTP_FROM')) {
    define('ST_SMTP_FROM', 'contact.us@complexwisps.com');
}
if (!defined('ST_SMTP_FROM_NAME')) {
    define('ST_SMTP_FROM_NAME', 'Complex Wisps');
}
if (!defined('ST_SMTP_TO')) {
    define('ST_SMTP_TO', 'contact.us@complexwisps.com');
}
