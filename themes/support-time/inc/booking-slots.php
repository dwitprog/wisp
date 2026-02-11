<?php

/**
 * Слоты записи: date_1/2/3 (сегодня/завтра/послезавтра), time_1_1 … time_3_10 (группы с time + info).
 * При загрузке страницы: если date_1 не совпадает с реальным «сегодня» — сдвиг броней и обнуление послезавтра.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Метки слотов по порядку (10 слотов, индексы 0–9). */
function st_booking_slot_labels(): array
{
    return [
        '10:00-10:45',
        '11:00-11:45',
        '12:00-12:45',
        '14:00-14:45',
        '15:00-15:45',
        '16:00-16:45',
        '17:00-17:45',
        '18:00-18:45',
        '19:00-19:45',
        '20:00-20:45',
    ];
}

/**
 * Текущие даты: сегодня, завтра, послезавтра в таймзоне сайта.
 *
 * @return array{0: string, 1: string, 2: string} Y-m-d
 */
function st_booking_real_dates(): array
{
    $tz = function_exists('wp_timezone') ? wp_timezone() : new DateTimeZone('UTC');
    $d0 = new DateTimeImmutable('now', $tz);
    $d1 = $d0->add(new DateInterval('P1D'));
    $d2 = $d0->add(new DateInterval('P2D'));
    return [
        $d0->format('Y-m-d'),
        $d1->format('Y-m-d'),
        $d2->format('Y-m-d'),
    ];
}

/**
 * Ротация слотов при смене дня: date_1 != реальное сегодня.
 * Послезавтра → завтра, завтра → сегодня, послезавтра обнуляем.
 */
function st_booking_rotate_if_needed(): void
{
    if (!function_exists('get_field') || !function_exists('update_field')) {
        return;
    }

    list($real_today, $real_tomorrow, $real_day_after) = st_booking_real_dates();
    $date_1 = get_field('date_1', 'option');
    $date_2 = get_field('date_2', 'option');
    $date_3 = get_field('date_3', 'option');

    if ($date_1 === '' || $date_1 === null) {
        update_field('date_1', $real_today, 'option');
        update_field('date_2', $real_tomorrow, 'option');
        update_field('date_3', $real_day_after, 'option');
        return;
    }

    $date_1 = (string) $date_1;
    if ($date_1 === $real_today) {
        return;
    }

    for ($slot = 1; $slot <= 10; $slot++) {
        $key_2 = 'time_2_' . $slot;
        $key_3 = 'time_3_' . $slot;
        $val_2 = get_field($key_2, 'option');
        $val_3 = get_field($key_3, 'option');

        $time_2 = is_array($val_2) ? ($val_2['time'] ?? false) : (bool) $val_2;
        $info_2 = is_array($val_2) ? ($val_2['info'] ?? '') : '';

        update_field('time_1_' . $slot, ['time' => $time_2, 'info' => $info_2], 'option');
        update_field($key_2, [
            'time' => is_array($val_3) ? ($val_3['time'] ?? false) : (bool) $val_3,
            'info' => is_array($val_3) ? ($val_3['info'] ?? '') : '',
        ], 'option');
        update_field($key_3, ['time' => false, 'info' => ''], 'option');
    }

    update_field('date_1', $real_today, 'option');
    update_field('date_2', $real_tomorrow, 'option');
    update_field('date_3', $real_day_after, 'option');
}

/**
 * Данные для фронта: даты и занятость по дням (1,2,3) и слотам (0–9).
 *
 * @return array{booking_dates: array, booking_slot_labels: array, booking_booked: array}
 */
function st_booking_data_for_js(): array
{
    $labels = st_booking_slot_labels();
    $out = [
        'booking_dates' => [],
        'booking_slot_labels' => $labels,
        'booking_booked' => ['1' => [], '2' => [], '3' => []],
    ];

    if (!function_exists('get_field')) {
        return $out;
    }

    $out['booking_dates'] = [
        (string) get_field('date_1', 'option'),
        (string) get_field('date_2', 'option'),
        (string) get_field('date_3', 'option'),
    ];

    for ($day = 1; $day <= 3; $day++) {
        for ($slot = 1; $slot <= 10; $slot++) {
            $val = get_field('time_' . $day . '_' . $slot, 'option');
            $out['booking_booked'][(string) $day][] = is_array($val) ? !empty($val['time']) : (bool) $val;
        }
    }

    return $out;
}

add_action('init', 'st_booking_rotate_if_needed', 20);
