<?php

/**
 * Интеграция с YetiForce CRM: создание лида через REST API.
 *
 * Как получить данные (в админке YetiForce https://complexwisps.yetiforce.eu):
 *
 * 1) ST_YETIFORCE_URL — адрес CRM без слэша в конце, например:
 *    https://complexwisps.yetiforce.eu
 *
 * 2) ST_YETIFORCE_API_KEY — API-ключ приложения:
 *    Меню: Integration → Web service - Applications → Add Key (или выберите существующее приложение).
 *    В форме: поле "Password" — это строка для API; после сохранения нажмите кнопку копирования ключа
 *    (copy to clipboard) и вставьте сюда. Либо используйте значение "Password", которое задали.
 *
 * 3) ST_YETIFORCE_USER и ST_YETIFORCE_PASSWORD — логин и пароль пользователя Webservice:
 *    Меню: Integration → Web service - Users → вкладка "Webservice Standard" → Add record.
 *    В форме: Server — выберите созданное приложение (из п.2); укажите логин (username) и пароль (Password).
 *    Сохраните. Эти логин и пароль подставляйте в ST_YETIFORCE_USER и ST_YETIFORCE_PASSWORD.
 *
 * Опционально: ST_YETIFORCE_AUTH_METHOD — способ авторизации при логине:
 *   'auto' (по умолчанию) — перебор методов 1–5 до первого успешного;
 *   '1' — только x-api-key + JSON body (userName, password);
 *   '2' — Basic Auth (user:password) + x-api-key + JSON body;
 *   '3' — Basic Auth (apikey:пусто) + x-api-key + JSON body;
 *   '4' — x-api-key + form-urlencoded body;
 *   '5' — только Basic Auth (user:password) + JSON body, без x-api-key.
 *   '6' — как 1, но URL: webservice.php?_container=...&module=Users&action=Login (без rewrite).
 *
 * В wp-config.php или config-local.php:
 *   define('ST_YETIFORCE_URL', 'https://complexwisps.yetiforce.eu');
 *   define('ST_YETIFORCE_API_KEY', 'ваш-api-key');
 *   define('ST_YETIFORCE_USER', 'логин webservice');
 *   define('ST_YETIFORCE_PASSWORD', 'пароль webservice');
 *
 * @param array $raw_fields Сантизированные поля формы (ключи: name, email, message, и др.)
 * @param string $message_text Готовый текст заявки (для поля description)
 * @return array{ok: bool, id?: int, error?: string}
 */
function st_yetiforce_create_lead(array $raw_fields, string $message_text): array
{
    $log = static function (string $msg, $context = null): void {
        $line = '[st_yetiforce] ' . $msg;
        if ($context !== null) {
            $line .= ' ' . (is_string($context) ? $context : wp_json_encode($context));
        }
        error_log($line);
    };

    $log('Start create lead', ['fields_keys' => array_keys($raw_fields), 'message_length' => strlen($message_text)]);

    if (!defined('ST_YETIFORCE_URL') || !defined('ST_YETIFORCE_API_KEY') || !defined('ST_YETIFORCE_USER') || !defined('ST_YETIFORCE_PASSWORD')) {
        $log('Missing config', [
            'has_url' => defined('ST_YETIFORCE_URL'),
            'has_api_key' => defined('ST_YETIFORCE_API_KEY'),
            'has_user' => defined('ST_YETIFORCE_USER'),
            'has_password' => defined('ST_YETIFORCE_PASSWORD'),
        ]);
        return ['ok' => false, 'error' => 'YetiForce not configured'];
    }

    $base_url = rtrim(ST_YETIFORCE_URL, '/');
    $login_url_rewrite = $base_url . '/webservice/WebserviceStandard/Users/Login';
    $login_url_query   = $base_url . '/webservice.php?_container=WebserviceStandard&module=Users&action=Login';

    $auth_method = defined('ST_YETIFORCE_AUTH_METHOD') ? ST_YETIFORCE_AUTH_METHOD : 'auto';
    $methods_to_try = $auth_method === 'auto' ? ['1', '2', '3', '4', '5', '6'] : [ (string) $auth_method ];

    $common_headers = [
        'User-Agent' => 'WordPress-YetiForce-Integration/1.0',
        'Accept'     => 'application/json',
    ];

    $login_body_json = wp_json_encode([
        'userName' => ST_YETIFORCE_USER,
        'password' => ST_YETIFORCE_PASSWORD,
    ]);
    $login_body_form = http_build_query([
        'userName' => ST_YETIFORCE_USER,
        'password' => ST_YETIFORCE_PASSWORD,
    ]);

    $token = null;
    $last_code = null;
    $last_body = null;
    $used_method = null;

    foreach ($methods_to_try as $method) {
        $headers = [];
        $body = '';

        switch ($method) {
            case '1':
                $headers = array_merge($common_headers, [ 'Content-Type' => 'application/json', 'x-api-key' => ST_YETIFORCE_API_KEY ]);
                $body = $login_body_json;
                $login_url = $login_url_rewrite;
                break;
            case '2':
                $headers = array_merge($common_headers, [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(ST_YETIFORCE_USER . ':' . ST_YETIFORCE_PASSWORD),
                    'x-api-key'     => ST_YETIFORCE_API_KEY,
                ]);
                $body = $login_body_json;
                $login_url = $login_url_rewrite;
                break;
            case '3':
                $headers = array_merge($common_headers, [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(ST_YETIFORCE_API_KEY . ':'),
                    'x-api-key'     => ST_YETIFORCE_API_KEY,
                ]);
                $body = $login_body_json;
                $login_url = $login_url_rewrite;
                break;
            case '4':
                $headers = array_merge($common_headers, [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'x-api-key'    => ST_YETIFORCE_API_KEY,
                ]);
                $body = $login_body_form;
                $login_url = $login_url_rewrite;
                break;
            case '5':
                $headers = array_merge($common_headers, [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(ST_YETIFORCE_USER . ':' . ST_YETIFORCE_PASSWORD),
                ]);
                $body = $login_body_json;
                $login_url = $login_url_rewrite;
                break;
            case '6':
                $headers = array_merge($common_headers, [ 'Content-Type' => 'application/json', 'x-api-key' => ST_YETIFORCE_API_KEY ]);
                $body = $login_body_json;
                $login_url = $login_url_query;
                break;
            default:
                continue 2;
        }

        $log('Login try method', [ 'method' => $method, 'url' => $login_url ]);

        $login_response = wp_remote_post($login_url, [
            'timeout' => 15,
            'headers' => $headers,
            'body'    => $body,
        ]);

        if (is_wp_error($login_response)) {
            $log('Login wp_remote_post error (method ' . $method . ')', $login_response->get_error_message());
            continue;
        }

        $code = wp_remote_retrieve_response_code($login_response);
        $rbody = wp_remote_retrieve_body($login_response);
        $data = json_decode($rbody, true);

        $last_code = $code;
        $last_body = $rbody;
        $log('Login response method ' . $method, ['code' => $code, 'body' => $rbody]);

        if ($code === 200 && !empty($data['result']['token'])) {
            $token = $data['result']['token'];
            $used_method = $method;
            $log('Login success with method', $method);
            break;
        }
    }

    if ($token === null) {
        $log('Login failed all methods', ['tried' => $methods_to_try]);
        return [
            'ok'                    => false,
            'error'                 => 'YetiForce login failed',
            'login_response_code'   => $last_code,
            'login_response_body'   => $last_body,
            'auth_methods_tried'    => $methods_to_try,
        ];
    }

    $name  = isset($raw_fields['name']) ? sanitize_text_field((string) $raw_fields['name']) : '';
    $email = isset($raw_fields['email']) ? sanitize_email((string) $raw_fields['email']) : '';
    $phone = isset($raw_fields['phone']) ? sanitize_text_field((string) $raw_fields['phone']) : '';

    $lead_data = [
        'lastname'    => $name !== '' ? $name : 'Lead from website',
        'description' => $message_text,
    ];

    if ($email !== '') {
        $lead_data['email'] = $email;
    }
    if ($phone !== '') {
        $lead_data['phone'] = $phone;
    }

    if (isset($raw_fields['web-site'])) {
        $v = sanitize_text_field((string) $raw_fields['web-site']);
        if ($v !== '') {
            $lead_data['website'] = $v;
        }
    }
    if (isset($raw_fields['company'])) {
        $v = sanitize_text_field((string) $raw_fields['company']);
        if ($v !== '') {
            $lead_data['company'] = $v;
        }
    }

    $record_url = $base_url . '/webservice/WebserviceStandard/Leads/Record';
    $log('Create lead URL', $record_url);
    $log('Lead data', $lead_data);

    $record_response = wp_remote_post($record_url, [
        'timeout' => 15,
        'headers' => [
            'Content-Type' => 'application/json',
            'x-token'      => $token,
        ],
        'body' => wp_json_encode($lead_data),
    ]);

    if (is_wp_error($record_response)) {
        $log('Create lead wp_remote_post error', $record_response->get_error_message());
        return ['ok' => false, 'error' => $record_response->get_error_message()];
    }

    $record_code = wp_remote_retrieve_response_code($record_response);
    $record_body = wp_remote_retrieve_body($record_response);
    $record_data = json_decode($record_body, true);

    $log('Create lead response', ['code' => $record_code, 'body_length' => strlen($record_body), 'body' => $record_body]);

    if ($record_code !== 200) {
        $log('Create lead failed', ['code' => $record_code, 'result' => $record_data]);
        return ['ok' => false, 'error' => 'YetiForce create lead failed'];
    }

    $id = isset($record_data['result']['id']) ? (int) $record_data['result']['id'] : null;
    $log('Lead created', ['id' => $id]);

    return ['ok' => true, 'id' => $id];
}

/**
 * Универсальная отправка формы на почту через AJAX
 */
function st_send_form(): void
{
    error_log('[st_send_form] Start');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        error_log('[st_send_form] Invalid request method: ' . ($_SERVER['REQUEST_METHOD'] ?? ''));
        wp_send_json_error(['message' => 'Invalid request method'], 405);
    }

    if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'st_send_form')) {
        error_log('[st_send_form] Invalid nonce');
        wp_send_json_error(['message' => 'Invalid nonce'], 403);
    }

    $raw_fields = wp_unslash($_POST);
    unset($raw_fields['action'], $raw_fields['nonce']);

    $lines = [];
    $page_url = '';
    if (!empty($raw_fields['page_url'])) {
        $page_url = esc_url_raw($raw_fields['page_url']);
        unset($raw_fields['page_url']);
    }
    if ($page_url === '') {
        $page_url = esc_url_raw(wp_get_referer());
    }
    if ($page_url !== '') {
        $lines[] = 'Page: ' . $page_url;
    }
    $label_map = [
        'name' => 'Name',
        'email' => 'Email',
        'message' => 'Message',
        'servicesPrice' => 'Planning budget',
        'services' => 'Service of interest',
        'platformsOfInterest' => 'Platforms of interest',
        'budget' => 'Total Budget per month',
        'duration' => "Duration",
        'currentStatus' => 'Current Status',
        'scope' => 'Scope',
        'execution-speed' => 'Execution Speed',
        'web-site' => 'Web Site',
    ];

    foreach ($raw_fields as $key => $value) {
        if ($value === '' || $value === null) {
            continue;
        }

        $label = $label_map[$key] ?? (string)$key;
        $label = sanitize_text_field($label);
        if (is_array($value)) {
            $clean_values = array_filter(
                array_map('sanitize_text_field', $value),
                static fn($item) => $item !== ''
            );
            if (!$clean_values) {
                continue;
            }
            $lines[] = $label . ': ' . implode(', ', $clean_values);
        } else {
            $clean_value = sanitize_text_field((string)$value);
            if ($clean_value === '') {
                continue;
            }
            $lines[] = $label . ': ' . $clean_value;
        }
    }

    if (!$lines) {
        error_log('[st_send_form] Empty form data after sanitize');
        wp_send_json_error(['message' => 'Empty form data'], 400);
    }

    $to = '';

    if (!defined('ST_SMTP_TO')) {
        $to = "stastimofeew98@gmail.com";
    } else {
        $to = ST_SMTP_TO;
    }

    $subject = 'Новая заявка с сайта ' . wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES);
    $message = implode("\n", $lines);

    $yetiforce_result = st_yetiforce_create_lead($raw_fields, $message);
    error_log('[st_send_form] YetiForce result: ' . wp_json_encode($yetiforce_result));
    if (!$yetiforce_result['ok']) {
        error_log('[st_send_form] YetiForce lead not created: ' . ($yetiforce_result['error'] ?? 'unknown'));
    }

    $headers = [];

    error_log('[st_send_form] To: ' . $to);
    error_log('[st_send_form] Subject: ' . $subject);
    error_log('[st_send_form] Message: ' . $message);
    error_log('[st_send_form] Headers: ' . implode('; ', $headers));

    $sent = wp_mail($to, $subject, $message, $headers);

    error_log('[st_send_form] wp_mail result: ' . ($sent ? 'true' : 'false'));

    if ($sent) {
        wp_send_json_success(['message' => 'Form sent']);
    }

    wp_send_json_error(['message' => 'Mail error']);
}

add_action('wp_ajax_st_send_form', 'st_send_form');
add_action('wp_ajax_nopriv_st_send_form', 'st_send_form');

/**
 * Логируем ошибки wp_mail
 */
function st_log_wp_mail_failed($wp_error): void
{
    if (is_wp_error($wp_error)) {
        error_log('[st_send_form] wp_mail_failed: ' . $wp_error->get_error_message());
        error_log('[st_send_form] wp_mail_failed data: ' . wp_json_encode($wp_error->get_error_data()));
    }
}

add_action('wp_mail_failed', 'st_log_wp_mail_failed');
