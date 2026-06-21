<?php

/**
 * Пример локального конфига темы. Скопируйте в config-local.php и подставьте данные.
 *
 * На боевом сервере удобнее положить конфиг в wp-content/st-config-local.php
 * (см. st-config-local.example.php в корне репозитория) — он не в git и не теряется при деплое.
 *
 * YetiForce: Login (Basic Auth + X-API-KEY + userName/password) → token → Leads/Record.
 */
if (!defined('ST_YETIFORCE_URL')) {
    define('ST_YETIFORCE_URL', 'https://complexwisps.yetiforce.eu');
}
if (!defined('ST_YETIFORCE_API_KEY')) {
    define('ST_YETIFORCE_API_KEY', 'your-api-key');
}
if (!defined('ST_YETIFORCE_USER')) {
    define('ST_YETIFORCE_USER', 'webservice-username');
}
if (!defined('ST_YETIFORCE_PASSWORD')) {
    define('ST_YETIFORCE_PASSWORD', 'webservice-password');
}
// define('ST_YETIFORCE_BASIC_AUTH_USER', 'basic-auth-username');
// define('ST_YETIFORCE_BASIC_AUTH_PASSWORD', 'basic-auth-password');

// SMTP (без этих констант wp_mail на хостинге обычно не работает)
// define('ST_SMTP_HOST', 'mail.complexwisps.com');
// define('ST_SMTP_PORT', 587);
// define('ST_SMTP_SECURE', 'tls');
// define('ST_SMTP_USER', 'contact.us@complexwisps.com');
// define('ST_SMTP_PASS', 'mailbox-password');
// define('ST_SMTP_FROM', 'contact.us@complexwisps.com');
// define('ST_SMTP_FROM_NAME', 'Complex Wisps');
// define('ST_SMTP_TO', 'contact.us@complexwisps.com');
