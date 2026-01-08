<?php
/***************************************************************
 * Включаем все необходимое для темы
 * - Включаем поддержку логотипа
 * - Включаем поддержку миниатюр
 * - Включаем поддержку SVG
 * - Добавляет возможность изменять фон из админки
 * - Изменение изображения в шапке из админки
 * - Включаем возможность добавлять ссылки на RSS фиды постов и комментариев в head часть HTML документа
 * - Поддержка HTML 5
 * - Эта функция позволит плагинам и темам изменять метатег <title>
 * - Включает поддержку «Selective Refresh» (выборочное обновление) для виджетов в кастомайзере
 * - Включает поддержку широкого выравнивания для картинок у блоков Гутенберга
 * - Определяет свою коллекцию цветов которые можно будет использовать при редактировании блоков
 * Включение шорткодов в виджете «Текст»
 * Возможность менять добавлять меню
 * Вставляем свой логотип при входе на сайт
 * Удаление файлов license.txt и readme.html для защиты
 ****************************************************************/

/**
 * Включаем все необходимое для темы
 */

function st_add_theme_support()
{
    // - Включаем поддержку логотипа
    add_theme_support('custom-logo');
    // - Включаем поддержку блоков
    //add_theme_support( 'wp-block-styles' );
    add_editor_style('./assets/min/css/main.min.css');

    // - Включаем поддержку миниатюр
    add_theme_support('post-thumbnails');


    // - Включаем поддержку SVG
    // Добавляет SVG в список разрешенных для загрузки файлов.
    add_filter('upload_mimes', function ($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    });
    // Исправление MIME типа для SVG файлов.
    add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes, $real_mime = '') {
        if (version_compare($GLOBALS['wp_version'], '5.1.0', '>='))
            $dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml']);
        else
            $dosvg = ('.svg' === strtolower(substr($filename, -4)));
        // mime тип был обнулен, поправим его, а также проверим право пользователя
        if ($dosvg) {
            // разрешим
            if (current_user_can('manage_options')) {
                $data['ext'] = 'svg';
                $data['type'] = 'image/svg+xml';
            } // запретим
            else {
                $data['ext'] = $type_and_ext['type'] = false;
            }
        }
        return $data;
    }, 10, 5);

    // - Добавляет возможность изменять фон из админки
    add_theme_support('custom-background');
    add_theme_support('custom-background', [
        'default-color' => '',
        'default-image' => '',
        'wp-head-callback' => '_custom_background_cb',
        'admin-head-callback' => '',
        'admin-preview-callback' => ''
    ]);


    // - Включаем возможность добавлять ссылки на RSS фиды постов и комментариев в head часть HTML документа
    add_theme_support('automatic-feed-links');

    // - Поддержка HTML 5
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
        'script',
        'style',
    ));

    // - Эта функция позволит плагинам и темам изменять метатег <title>
    add_theme_support('title-tag');

    // - Включает поддержку «Selective Refresh» (выборочное обновление) для виджетов в кастомайзере
    add_theme_support('customize-selective-refresh-widgets');


    // - Определяет свою коллекцию цветов которые можно будет использовать при редактировании блоков
    add_theme_support('editor-color-palette', [
        [
            'name' => __('strong magenta', 'domain'),
            'slug' => 'strong-magenta',
            'color' => '#a156b4',
        ],
        [
            'name' => __('light grayish magenta', 'domain'),
            'slug' => 'light-grayish-magenta',
            'color' => '#d0a5db',
        ],
        [
            'name' => __('very light gray', 'domain'),
            'slug' => 'very-light-gray',
            'color' => '#eee',
        ],
        [
            'name' => __('very dark gray', 'domain'),
            'slug' => 'very-dark-gray',
            'color' => '#444',
        ],
    ]);


}

add_action('after_setup_theme', 'st_add_theme_support');

/**
 * Включение шорткодов в виджете «Текст»
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Возможность менять добавлять меню
 */
register_nav_menus(array(
    'header_menu' => 'Основное меню',
    'footer_menu' => 'Меню в подвале',
    'mobile_menu' => 'Мобильное меню'
));


/* убираем title в логотипе "сайт работает на wordpress" */
add_filter('login_headertext', function () {
    return false;
});
/**
 * Удаление файлов license.txt и readme.html для защиты
 */
if (is_admin() && !defined('DOING_AJAX')) {
    add_action('init', 'remove_license_txt_readme_html');
    function remove_license_txt_readme_html()
    {

        $license_file = ABSPATH . '/license.txt';
        $readme_file = ABSPATH . '/readme.html';

        if (file_exists($license_file) && current_user_can('manage_options')) {

            $deleted = unlink($license_file) && unlink($readme_file);

            if (!$deleted)
                $GLOBALS['readmedel'] = 'Не удалось удалить файлы: license.txt и readme.html из папки `' . ABSPATH . '`. Удалите их вручную!';
            else
                $GLOBALS['readmedel'] = 'Файлы: license.txt и readme.html удалены из из папки `' . ABSPATH . '`.';

            add_action('admin_notices', function () {
                echo '<div class="error is-dismissible"><p>' . $GLOBALS['readmedel'] . '</p></div>';
            });
        }
    }
}
