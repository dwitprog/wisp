<?php

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
