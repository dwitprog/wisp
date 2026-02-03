<?php

/**
 * Тест отправки лида в YetiForce.
 * Запуск из корня сайта WordPress:
 *   php wp-content/themes/support-time/inc/test-yetiforce-lead.php
 *   php wp-content/themes/support-time/inc/test-yetiforce-lead.php --debug
 * (--debug выводит полный ответ YetiForce на запрос Login).
 *
 * Логи пишутся в error_log. Результат выводится в консоль.
 */

$wp_load_path = __DIR__ . '/../../../wp-load.php';
if (!is_file($wp_load_path)) {
    $wp_load_path = __DIR__ . '/../../../../wp-load.php';
}
if (!is_file($wp_load_path)) {
    echo "Не найден wp-load.php. Укажите путь в скрипте.\n";
    exit(1);
}

if (php_sapi_name() === 'cli') {
    error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
}
require_once $wp_load_path;

$inc_dir = __DIR__;
if (is_file($inc_dir . '/config-local.php')) {
    require_once $inc_dir . '/config-local.php';
}
require_once $inc_dir . '/form-handler.php';

if (!function_exists('st_yetiforce_create_lead')) {
    echo "Функция st_yetiforce_create_lead не найдена.\n";
    exit(1);
}

$test_fields = [
    'name'    => 'Test Lead ' . date('Y-m-d H:i:s'),
    'email'   => 'test@example.com',
    'message' => 'Тестовая заявка с сайта. Время: ' . date('c'),
];
$test_message = "Page: https://example.com/test\nName: {$test_fields['name']}\nEmail: {$test_fields['email']}\nMessage: {$test_fields['message']}";

echo "=== Тест YetiForce Create Lead ===\n";
echo "URL: " . (defined('ST_YETIFORCE_URL') ? ST_YETIFORCE_URL : '(не задан)') . "\n";
echo "User: " . (defined('ST_YETIFORCE_USER') ? ST_YETIFORCE_USER : '(не задан)') . "\n";
echo "API Key: " . (defined('ST_YETIFORCE_API_KEY') ? substr(ST_YETIFORCE_API_KEY, 0, 8) . '...' : '(не задан)') . "\n";
echo "Auth method: " . (defined('ST_YETIFORCE_AUTH_METHOD') ? ST_YETIFORCE_AUTH_METHOD : 'auto') . "\n";
echo "---\n";

if (php_sapi_name() === 'cli' && in_array('--debug', $argv ?? [], true)) {
    echo "[DEBUG] Прямой запрос Login для просмотра ответа YetiForce:\n";
    $base_url = rtrim(ST_YETIFORCE_URL, '/');
    $login_url = $base_url . '/webservice/WebserviceStandard/Users/Login';
    $body = wp_json_encode(['userName' => ST_YETIFORCE_USER, 'password' => ST_YETIFORCE_PASSWORD]);
    $resp = wp_remote_post($login_url, [
        'timeout' => 15,
        'headers' => [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(ST_YETIFORCE_USER . ':' . ST_YETIFORCE_PASSWORD),
            'x-api-key'     => ST_YETIFORCE_API_KEY,
        ],
        'body' => $body,
    ]);
    $code = is_wp_error($resp) ? 0 : wp_remote_retrieve_response_code($resp);
    $rbody = is_wp_error($resp) ? $resp->get_error_message() : wp_remote_retrieve_body($resp);
    echo "  URL: $login_url\n  HTTP Code: $code\n  Response: $rbody\n---\n";
}

$result = st_yetiforce_create_lead($test_fields, $test_message);

echo "Result: " . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
echo "---\n";
if (!empty($result['login_response_code']) || isset($result['login_response_body'])) {
    echo "Ответ YetiForce на Login:\n  HTTP " . ($result['login_response_code'] ?? '') . "\n  Body: " . ($result['login_response_body'] ?? '') . "\n";
    if (!empty($result['auth_methods_tried'])) {
        echo "  Испробованы методы: " . implode(', ', $result['auth_methods_tried']) . "\n";
    }
    echo "---\n";
}
echo $result['ok'] ? "OK: лид создан, id=" . ($result['id'] ?? '') . "\n" : "Ошибка: " . ($result['error'] ?? '') . "\n";

exit($result['ok'] ? 0 : 1);
