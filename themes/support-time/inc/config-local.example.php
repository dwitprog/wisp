<?php

/**
 * Пример локального конфига. Скопируйте в config-local.php и подставьте свои данные.
 * Файл config-local.php не коммитится в git.
 *
 * YetiForce CRM — один метод: Login (Basic Auth + X-API-KEY + body userName/password/code) → token → Record с x-token.
 */
if (!defined('ST_YETIFORCE_URL')) {
    define('ST_YETIFORCE_URL', 'https://your-crm.yetiforce.eu');
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
// Basic Auth для запроса Login (логин/пароль в Postman → Authorization → Basic Auth). Если не заданы — используются ST_YETIFORCE_USER и ST_YETIFORCE_PASSWORD.
// define('ST_YETIFORCE_BASIC_AUTH_USER', 'basic-auth-username');
// define('ST_YETIFORCE_BASIC_AUTH_PASSWORD', 'basic-auth-password');
