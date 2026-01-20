<?php

/**
 * SMTP настройки для wp_mail
 */
function st_configure_smtp($phpmailer): void
{
    if (!defined('ST_SMTP_HOST') || !defined('ST_SMTP_USER') || !defined('ST_SMTP_PASS')) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host = ST_SMTP_HOST;
    $phpmailer->Port = defined('ST_SMTP_PORT') ? ST_SMTP_PORT : 587;

    $has_auth = ST_SMTP_USER !== '' && ST_SMTP_PASS !== '';
    $phpmailer->SMTPAuth = $has_auth;
    if ($has_auth) {
        $phpmailer->Username = ST_SMTP_USER;
        $phpmailer->Password = ST_SMTP_PASS;
    }

    $secure = defined('ST_SMTP_SECURE') ? ST_SMTP_SECURE : '';
    if ($secure) {
        $phpmailer->SMTPSecure = $secure;
    } else {
        $phpmailer->SMTPSecure = false;
        $phpmailer->SMTPAutoTLS = false;
    }
    $phpmailer->CharSet = 'UTF-8';

    if (defined('ST_SMTP_FROM')) {
        $from_name = defined('ST_SMTP_FROM_NAME') ? ST_SMTP_FROM_NAME : get_bloginfo('name');
        $phpmailer->setFrom(ST_SMTP_FROM, $from_name, false);
    }
}

add_action('phpmailer_init', 'st_configure_smtp');
