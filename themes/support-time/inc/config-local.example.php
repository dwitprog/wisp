<?php

/**
 * Пример локального конфига. Скопируйте в config-local.php и подставьте свои данные.
 * Файл config-local.php не коммитится в git.
 *
 * YetiForce CRM
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

// Опционально: способ авторизации при логине. По умолчанию 'auto' (перебор 1–5).
// define('ST_YETIFORCE_AUTH_METHOD', 'auto'); // '1'|'2'|'3'|'4'|'5'|'auto'
