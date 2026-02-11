<?php

/***************************************************************
 * Распределение заявок
 * Отслеживаем откуда пришел пользователь
 * Отключаем авто форматирование в редакторе WP
 * Выводим шрифты в HTML
 * Добавление js и css файлов
 * Добавление js и css файлов для админки
 * Добавление атрибутов defer и async для скриптов
 * Настройка виджетов (футер, сайдбар, копирайт и тд.)
 * Переименовываем пункты меню
 * Изменение длины обрезаемого текста новостей
 * Добавляем title в ссылки на пагинации next/previous post
 * Функция для вывода объектов в читаемом виде + вывод ошибок
 * Изменение текста в подвале админ-панели
 * Добавляем столбец: Дата последнего изменения поста или страницы
 * Удаляем столбец комментариев в админке
 * Определение региона пользователя
 * Подключаемые файлы
 * * Включаем все необходимое для темы
 * * Добавление шаблонов блоков
 * * Кастомные шорткоды
 * * Кастомные страницы
 * * [Bootstrap 5] Интеграция bootstrap и меню WordPress
 * * [Bootstrap 5] Хлебные крошки
 * * Настройка плагинов
 * * Отправка заявок в CRM bitrix24
 ****************************************************************/
require __DIR__ . '/vendor/autoload.php';

/**
 * Выводим шрифты в HTML
 */
function st_get_font_face_styles(): string
{
    $font_name = 'Aeroport';
    $code = "
        @font-face {
            font-family: '" . $font_name . "';
            src: 
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Regular.woff2') . "') format('woff2'),
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Regular.woff') . "') format('woff'),
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Regular.ttf') . "') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: '" . $font_name . "';
            src: 
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Bold.woff2') . "') format('woff2'),
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Bold.woff') . "') format('woff'),
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Bold.ttf') . "') format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: '" . $font_name . "';
            src: 
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Black.woff2') . "') format('woff2'),
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Black.woff') . "') format('woff'),
                url('" . get_theme_file_uri('assets/fonts/' . $font_name . '-Black.ttf') . "') format('truetype');
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }
    ";

    return $code;
}

// Предварительно загружаем основной веб-шрифт для повышения производительности.
function st_preload_webfonts(): void
{
    $font_name = 'Aeroport';
?>
    <link rel="preload" href="<?= esc_url(get_theme_file_uri('assets/fonts/' . $font_name . '-Regular.woff2')); ?>"
        as="font" crossorigin>
<?php
}

add_action('wp_head', 'st_preload_webfonts');

/**
 * Добавление js и css файлов
 */
function st_css_and_js(): void
{
    // CSS
    wp_enqueue_style('styles', get_stylesheet_directory_uri() . '/assets/min/css/styles.min.css', [], '_rgbld_12_2_2026');
    wp_add_inline_style('styles', st_get_font_face_styles());

    // Для страниц и новостей подключаем стили отдельно
    if (is_category() || is_archive() || is_single() || str_contains($_SERVER['REQUEST_URI'], 'components')) {
        wp_enqueue_style('posts', get_stylesheet_directory_uri() . '/assets/min/css/posts.min.css', [], '_rgbld_12_2_2026');
        wp_enqueue_script('comment-reply', [], null, true);
        // Подключаем стили конкретного поста
        $patch_page_style = get_stylesheet_directory() . '/assets/min/css/style-post-';
        if (file_exists($patch_page_style . get_the_ID() . '.min.css') && (is_single() || is_category() || is_archive())) {
            wp_enqueue_style('style-post-' . get_the_ID(), get_stylesheet_directory_uri() . '/assets/min/css/style-post-' . get_the_ID() . '.min.css', [], '_rgbld_12_2_2026');
        }
    } else {
        wp_enqueue_style('pages', get_stylesheet_directory_uri() . '/assets/min/css/pages.min.css', [], '_rgbld_12_2_2026');
        // Подключаем стили конкретной страницы
        $patch_page_style = get_stylesheet_directory() . '/assets/min/css/style-page-';
        if (file_exists($patch_page_style . get_the_ID() . '.min.css') && (!is_single() && !is_category() && !is_archive())) {
            wp_enqueue_style('style-page-' . get_the_ID(), get_stylesheet_directory_uri() . '/assets/min/css/style-page-' . get_the_ID() . '.min.css', [], '_rgbld_12_2_2026');
        }
    }

    // Грамотно выводим мобильные стили
    $arr_display_styles = ['1400', '1200', '992', '768', '576'];
    $arr_name_files_mobile_style = ['main', 'pages', 'posts', get_the_ID()];
    $patch_mobile_styles = get_stylesheet_directory() . '/assets/min/css/';
    foreach ($arr_display_styles as $d) {
        foreach ($arr_name_files_mobile_style as $f) {
            if (file_exists($patch_mobile_styles . $f . '-max-' . $d . '.css')) {
                wp_enqueue_style($f . '-max-' . $d, get_stylesheet_directory_uri() . '/assets/min/css/' . $f . '-max-' . $d . '.css', [], '_rgbld_12_2_2026', 'screen and (max-width:' . $d . 'px)');
                if (is_single() || is_category() || is_archive() || str_contains($_SERVER['REQUEST_URI'], 'components')) {
                    wp_deregister_style('pages-max-' . $d);
                } else {
                    wp_deregister_style('posts-max-' . $d);
                }
            }
        }
    }

    // JS
    if (!is_admin() && !is_single()) {
        wp_deregister_script('jquery');
    }
    $vendorsLibsWebpack = file_exists(get_template_directory() . '/assets/min/js/vendors.min.js');
    if (!empty($vendorsLibsWebpack)) {
        wp_enqueue_script('vendors', get_stylesheet_directory_uri() . '/assets/min/js/vendors.min.js', [], '_rgbld_12_2_2026', true);
    }
    wp_register_script('main', get_stylesheet_directory_uri() . '/assets/min/js/main.min.js', !empty($vendorsLibsWebpack) ? ['vendors'] : [], '_rgbld_12_2_2026', true);
    $rg_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('st_send_form'),
    );
    if (function_exists('st_booking_data_for_js')) {
        $rg_data = array_merge($rg_data, st_booking_data_for_js());
    } else {
        $rg_data['booking_dates'] = array();
        $rg_data['booking_slot_labels'] = array();
        $rg_data['booking_booked'] = array('1' => array(), '2' => array(), '3' => array());
    }
    wp_localize_script('main', 'rgData', $rg_data);
    wp_enqueue_script('main');
    // Для страниц и новостей подключаем скрипты отдельно
    if (is_category() || is_archive() || is_single()) {
        wp_enqueue_script('posts', get_stylesheet_directory_uri() . '/assets/min/js/postsScripts.min.js', !empty($vendorsLibsWebpack) ? [
            'main',
            'vendors'
        ] : ['main'], '_rgbld_12_2_2026', true);
    } else {
        wp_enqueue_script('pages', get_stylesheet_directory_uri() . '/assets/min/js/pagesScripts.min.js', !empty($vendorsLibsWebpack) ? [
            'main',
            'vendors'
        ] : ['main'], '_rgbld_12_2_2026', true);
    }
}

add_action('wp_enqueue_scripts', 'st_css_and_js');

/**
 * Оптимизированная загрузка CSS: критический + асинхронный vendors.min.css
 */
function theme_optimized_css(): void
{
    $file_path = get_template_directory() . '/assets/min/css/vendors.min.css';
    $file_url = get_stylesheet_directory_uri() . '/assets/min/css/vendors.min.css';


    // Асинхронная загрузка vendors.min.css
    if (file_exists($file_path)) {
        echo '<link rel="preload" href="' . esc_url($file_url) . '" as="style" ';
        echo 'onload="this.onload=null;this.rel=\'stylesheet\';this.media=\'all\'">';
        echo '<noscript><link rel="stylesheet" href="' . esc_url($file_url) . '" media="all"></noscript>';
    }
}

add_action('wp_head', 'theme_optimized_css', 1);

/**
 * Защита от дублирования: удаляем стандартное подключение, если есть
 */
function theme_dequeue_vendor_if_needed(): void
{
    // Если где-то в теме или плагине всё же подключили 'vendors' — удаляем
    if (wp_style_is('vendors', 'enqueued')) {
        wp_dequeue_style('vendors');
        wp_deregister_style('vendors');
    }
}

add_action('wp_enqueue_scripts', 'theme_dequeue_vendor_if_needed', 20);

/**
 * Добавление js и css файлов для админки
 */
function st_css_and_js_admin(): void
{
    // CSS
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/assets/min/css/admin.min.css', [], '_rgbld_12_2_2026');
    wp_add_inline_style('admin-styles', st_get_font_face_styles());
    // JS
    wp_enqueue_script('admin-scripts', get_stylesheet_directory_uri() . '/assets/min/js/admin.min.js', [], '_rgbld_12_2_2026');
}

add_action('admin_enqueue_scripts', 'st_css_and_js_admin');

/**
 * Добавление атрибутов defer и async для скриптов
 */
function st_add_defer_and_async_attribute($tag, $handle)
{
    $handles = [
        'async' => [],
        'defer' => ['main', 'posts', 'vendors']
    ];
    if (!empty($handles)) {
        if (count($handles['async']) > 0) {
            foreach ($handles['async'] as $script) {
                if ($script === $handle) {
                    return str_replace(' src', ' async src', $tag);
                }
            }
        }
        if (count($handles['defer']) > 0) {
            foreach ($handles['defer'] as $script) {
                if ($script === $handle) {
                    return str_replace(' src', ' defer src', $tag);
                }
            }
        }
    }

    return $tag;
}

add_filter('script_loader_tag', 'st_add_defer_and_async_attribute', 10, 2);

/**
 * Настройка виджетов (футер, сайдбар, копирайт и тд.)
 */
function st_widgets_init(): void
{
    register_sidebar(array(
        'name' => "Сайдбар",
        'id' => 'sidebar-1',
        'description' => "Сайдбар на странице новости.",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ));
    register_sidebar(array(
        'name' => "Виджет #1 [footer]",
        'id' => 'footer-widget-1',
        'description' => "Лого",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ));
    register_sidebar(array(
        'name' => "Виджет #2 [footer]",
        'id' => 'footer-widget-2',
        'description' => "Footer Menu 1",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ));
    register_sidebar(array(
        'name' => "Виджет #3 [footer]",
        'id' => 'footer-widget-3',
        'description' => "Footer Menu 2",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ));
    register_sidebar(array(
        'name' => "Виджет #4 [footer]",
        'id' => 'footer-widget-4',
        'description' => "Контакты",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ));
    register_sidebar(array(
        'name' => "Виджет #5 [footer]",
        'id' => 'footer-widget-5',
        'description' => "Копирайт",
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<p class="widget-title">',
        'after_title' => '</p>',
    ));
}

add_action('widgets_init', 'st_widgets_init');

/**
 * Переименовываем пункты меню
 */
function st_edit_admin_menus(): void
{
    global $menu;
    if (!empty($menu[30])) // cf7
    {
        $menu[30][0] = 'Формы';
    }
}

add_action('admin_menu', 'st_edit_admin_menus');


/**
 * Функция для вывода объектов в читаемом виде + вывод ошибок
 *
 * @param $code
 * @param string $debug_method
 *
 * @return bool
 */
function ddd($code, string $debug_method = "print"): bool
{
    if (is_admin()) {
        if (!empty($code)) {
            ini_set("error_reporting", E_ALL);
            ini_set("display_errors", 1);
            ini_set("display_startup_errors", 1);
            echo "<pre>";
            switch ($debug_method) {
                case "print":
                    print_r($code);
                    break;
                case "dump":
                    var_dump($code);
                    break;
                case "export":
                    var_export($code);
                    break;
            }
            echo "</pre>";

            return true;
        } else {
            echo "<pre>Код то не передал...</pre>";
        }
    }

    return false;
}


/**
 * Добавляем столбец: Дата последнего изменения поста или страницы
 */
function st_page_modified_column_register($columns)
{
    $columns['page_modified'] = "Дата изменения";

    return $columns;
}

add_filter('manage_edit-page_columns', 'st_page_modified_column_register');
function st_page_modified_column_display($column_name, $page_id): void
{
    if ('page_modified' != $column_name) {
        return;
    }
    $page_modified = get_post_field('post_modified', $page_id);
    if (!$page_modified) {
        $page_modified = '' . "undefined" . '';
    }
    echo $page_modified;
}

add_action('manage_pages_custom_column', 'st_page_modified_column_display', 10, 2);
function st_page_modified_column_register_sortable($columns)
{
    $columns['page_modified'] = 'page_modified';

    return $columns;
}

add_filter('manage_edit-page_sortable_columns', 'st_page_modified_column_register_sortable');

/**
 * Удаляем столбец комментариев в админке
 */
function remove_post_columns($columns)
{
    unset($columns['comments']);

    return $columns;
}

add_filter('manage_edit-post_columns', 'remove_post_columns', 10, 1);
function remove_page_columns($columns)
{
    unset($columns['expirationdate']);
    unset($columns['comments']);

    return $columns;
}

add_filter('manage_edit-page_columns', 'remove_page_columns', 10, 1);

/**
 * Подключаемые файлы
 */
function st_include_custom_files($path): void
{
    $file = get_template_directory() . $path;
    if (!file_exists($file)) {
        echo 'Файл ' . $file . ' не найден!';
    } else {
        require_once $file;
    }
}

/**
 * Включаем все необходимое для темы
 */
st_include_custom_files('/inc/theme-supports.php');

/**
 * Кастомные шорткоды
 */
st_include_custom_files('/inc/custom-shortcodes.php');

/**
 * Кастомные страницы
 */
st_include_custom_files('/inc/custom-type-posts.php');

/**
 * SMTP настройки
 */
st_include_custom_files('/inc/smtp.php');

/**
 * Локальный конфиг (YetiForce и др.). Файл config-local.php не в git.
 */
$config_local = get_template_directory() . '/inc/config-local.php';
if (file_exists($config_local)) {
    require_once $config_local;
}

/**
 * AJAX обработчики
 */
st_include_custom_files('/inc/form-handler.php');

/**
 * Баннер согласия на использование cookies
 */
st_include_custom_files('/inc/cookie-consent.php');

/**
 * Слоты записи (date_1/2/3, time_1_1 … time_3_10)
 */
st_include_custom_files('/inc/booking-slots.php');

/**
 * Настройка плагинов
 */
st_include_custom_files('/inc/settings-plugins.php');
