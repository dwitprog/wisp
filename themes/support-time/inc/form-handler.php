<?php

/**
 * Интеграция с YetiForce CRM: создание лида через REST API.
 *
 * Рабочий поток (как в Postman):
 * 1) POST {{URL}}/webservice/WebserviceStandard/Users/Login
 *    — Authorization: Basic base64(Basic Auth User : Basic Auth Password)
 *    — Header X-API-KEY = API Key
 *    — Body JSON: { "userName", "password", "code": "" }
 * 2) В ответе — result.token; в последующие запросы заголовок x-token с этим значением.
 *
 * Конфиг (config-local.php или wp-config.php):
 *   ST_YETIFORCE_URL — адрес CRM без слэша (https://complexwisps.yetiforce.eu)
 *   ST_YETIFORCE_API_KEY — API Key из Integration → Web service - Applications (копировать)
 *   ST_YETIFORCE_USER, ST_YETIFORCE_PASSWORD — userName и password в теле Login (Webservice Users)
 *   ST_YETIFORCE_BASIC_AUTH_USER, ST_YETIFORCE_BASIC_AUTH_PASSWORD — логин/пароль для Basic Auth
 *     (если не заданы, используются ST_YETIFORCE_USER и ST_YETIFORCE_PASSWORD)
 *
 * @param array $raw_fields Sanitized form fields (keys: name, email, message, etc.)
 * @param string $message_text Prepared request text (used for description; build in English for CRM)
 * @return array{ok: bool, id?: int, error?: string}
 */
function st_yetiforce_build_description_english(array $raw_fields, string $fallback_message): string
{
    $label_map = [
        'name' => 'Name',
        'email' => 'Email',
        'message' => 'Message',
        'phone' => 'Phone',
        'servicesPrice' => 'Planning budget',
        'services' => 'Service of interest',
        'platformsOfInterest' => 'Platforms of interest',
        'budget' => 'Total Budget per month',
        'duration' => 'Duration',
        'currentStatus' => 'Current Status',
        'scope' => 'Scope',
        'execution-speed' => 'Execution Speed',
        'web-site' => 'Web Site',
        'company' => 'Company',
    ];
    $lines = [];
    foreach ($raw_fields as $key => $value) {
        if ($value === '' || $value === null || in_array($key, ['action', 'nonce', 'page_url'], true)) {
            continue;
        }
        $label = $label_map[$key] ?? $key;
        if (is_array($value)) {
            $clean = array_filter(array_map('sanitize_text_field', $value), static fn($v) => $v !== '');
            if ($clean) {
                $lines[] = $label . ': ' . implode(', ', $clean);
            }
        } else {
            $clean = sanitize_text_field((string) $value);
            if ($clean !== '') {
                $lines[] = $label . ': ' . $clean;
            }
        }
    }
    return $lines !== [] ? implode("\n", $lines) : $fallback_message;
}

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

    $basic_user = defined('ST_YETIFORCE_BASIC_AUTH_USER') ? ST_YETIFORCE_BASIC_AUTH_USER : ST_YETIFORCE_USER;
    $basic_pass = defined('ST_YETIFORCE_BASIC_AUTH_PASSWORD') ? ST_YETIFORCE_BASIC_AUTH_PASSWORD : ST_YETIFORCE_PASSWORD;

    $login_url = $base_url . '/webservice/WebserviceStandard/Users/Login';
    $login_headers = [
        'Content-Type'  => 'application/json',
        'Authorization' => 'Basic ' . base64_encode($basic_user . ':' . $basic_pass),
        'X-API-KEY'     => ST_YETIFORCE_API_KEY,
        'User-Agent'    => 'WordPress-YetiForce-Integration/1.0',
        'Accept'        => 'application/json',
    ];
    $login_body = wp_json_encode([
        'userName' => ST_YETIFORCE_USER,
        'password' => ST_YETIFORCE_PASSWORD,
        'code'     => '',
    ]);

    $log('Login request', ['url' => $login_url]);
    $login_response = wp_remote_post($login_url, [
        'timeout' => 15,
        'headers' => $login_headers,
        'body'    => $login_body,
    ]);

    if (is_wp_error($login_response)) {
        $log('Login wp_remote_post error', $login_response->get_error_message());
        return ['ok' => false, 'error' => $login_response->get_error_message()];
    }

    $login_code = wp_remote_retrieve_response_code($login_response);
    $login_body_resp = wp_remote_retrieve_body($login_response);
    $login_data = json_decode($login_body_resp, true);
    $log('Login response', ['code' => $login_code, 'body' => $login_body_resp]);

    if ($login_code !== 200 || empty($login_data['result']['token'])) {
        $log('Login failed', ['code' => $login_code]);
        return [
            'ok'                  => false,
            'error'               => 'YetiForce login failed',
            'login_response_code' => $login_code,
            'login_response_body' => $login_body_resp,
        ];
    }

    $token = $login_data['result']['token'];
    $log('Login success', []);

    $name    = isset($raw_fields['name']) ? sanitize_text_field((string) $raw_fields['name']) : '';
    $email   = isset($raw_fields['email']) ? sanitize_email((string) $raw_fields['email']) : '';
    $phone   = isset($raw_fields['phone']) ? sanitize_text_field((string) $raw_fields['phone']) : '';
    $company = isset($raw_fields['company']) ? sanitize_text_field((string) $raw_fields['company']) : '';

    $lead_name = $name !== '' ? $name : 'Lead from website';
    $description_english = st_yetiforce_build_description_english($raw_fields, $message_text);
    $lead_data = [
        'lastname'    => $lead_name,
        'company'     => $company !== '' ? $company : $lead_name,
        'leadstatus'  => 'Pending',
        'description' => $description_english,
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

    $record_url = $base_url . '/webservice/WebserviceStandard/Leads/Record';
    $log('Create lead URL', $record_url);
    $log('Lead data', $lead_data);

    $record_headers = [
        'Content-Type'  => 'application/json',
        'User-Agent'    => 'WordPress-YetiForce-Integration/1.0',
        'Accept'        => 'application/json',
        'x-token'       => $token,
        'X-API-KEY'     => ST_YETIFORCE_API_KEY,
        'Authorization' => 'Basic ' . base64_encode($basic_user . ':' . $basic_pass),
    ];

    $record_response = wp_remote_post($record_url, [
        'timeout' => 15,
        'headers' => $record_headers,
        'body'    => wp_json_encode($lead_data),
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
        return [
            'ok'                  => false,
            'error'               => 'YetiForce create lead failed',
            'record_response_code' => $record_code,
            'record_response_body' => $record_body,
        ];
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

    // Success if lead was created in CRM or email was sent (so user sees success and button unblocks)
    if ($yetiforce_result['ok'] || $sent) {
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
