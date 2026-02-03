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
 * В wp-config.php или functions.php добавьте:
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
    if (!defined('ST_YETIFORCE_URL') || !defined('ST_YETIFORCE_API_KEY') || !defined('ST_YETIFORCE_USER') || !defined('ST_YETIFORCE_PASSWORD')) {
        error_log('[st_yetiforce] Missing ST_YETIFORCE_URL, ST_YETIFORCE_API_KEY, ST_YETIFORCE_USER or ST_YETIFORCE_PASSWORD');
        return ['ok' => false, 'error' => 'YetiForce not configured'];
    }

    $base_url = rtrim(ST_YETIFORCE_URL, '/');
    $login_url = $base_url . '/webservice/WebserviceStandard/Users/Login';

    $login_body = [
        'userName' => ST_YETIFORCE_USER,
        'password' => ST_YETIFORCE_PASSWORD,
    ];

    $login_response = wp_remote_post($login_url, [
        'timeout' => 15,
        'headers' => [
            'Content-Type' => 'application/json',
            'x-api-key'   => ST_YETIFORCE_API_KEY,
        ],
        'body' => wp_json_encode($login_body),
    ]);

    if (is_wp_error($login_response)) {
        error_log('[st_yetiforce] Login request failed: ' . $login_response->get_error_message());
        return ['ok' => false, 'error' => $login_response->get_error_message()];
    }

    $code = wp_remote_retrieve_response_code($login_response);
    $body  = wp_remote_retrieve_body($login_response);
    $data  = json_decode($body, true);

    if ($code !== 200 || empty($data['result']['token'])) {
        error_log('[st_yetiforce] Login failed. Code: ' . $code . ', Body: ' . $body);
        return ['ok' => false, 'error' => 'YetiForce login failed'];
    }

    $token = $data['result']['token'];

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

    $record_response = wp_remote_post($record_url, [
        'timeout' => 15,
        'headers' => [
            'Content-Type' => 'application/json',
            'x-token'      => $token,
        ],
        'body' => wp_json_encode($lead_data),
    ]);

    if (is_wp_error($record_response)) {
        error_log('[st_yetiforce] Create lead request failed: ' . $record_response->get_error_message());
        return ['ok' => false, 'error' => $record_response->get_error_message()];
    }

    $record_code = wp_remote_retrieve_response_code($record_response);
    $record_body = wp_remote_retrieve_body($record_response);
    $record_data = json_decode($record_body, true);

    if ($record_code !== 200) {
        error_log('[st_yetiforce] Create lead failed. Code: ' . $record_code . ', Body: ' . $record_body);
        return ['ok' => false, 'error' => 'YetiForce create lead failed'];
    }

    $id = isset($record_data['result']['id']) ? (int) $record_data['result']['id'] : null;
    error_log('[st_yetiforce] Lead created. ID: ' . ($id ?? 'unknown'));

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
