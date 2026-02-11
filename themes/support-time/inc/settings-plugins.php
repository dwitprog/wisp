<?php

/**
 * Contact form 7
 */
if (in_array('contact-form-7/wp-contact-form-7.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    /**
     * Удаляем оберточный span
     */
    add_filter('wpcf7_form_elements', function ($content) {
        $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
        return $content;
    });
    /**
     * Удаляем стили
     */
    function st_delete_cf7_styles()
    {
        wp_deregister_style('contact-form-7');
    }

    add_action('wp_print_styles', 'st_delete_cf7_styles', 100);

}


/**
 * ACF Pro - Advanced custom fields pro
 */
if (in_array('advanced-custom-fields-pro/acf.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    /**
     * Создаем страницы
     */
    if (function_exists('acf_add_options_page')) {
        // Страница с контактными данными пользователя
        acf_add_options_page(array(
            'page_title' => 'Контактные данные',
            'menu_title' => 'Контакты',
            'menu_slug' => 'st-contacts',
            'capability' => 'edit_posts',
            'position' => 50,
            'icon_url' => 'dashicons-phone',
            'redirect' => false
        ));
        // Страница со счетчиком Яндекс.Метрики
        acf_add_options_page(array(
            'page_title' => 'Код в подвал',
            'menu_title' => 'Код в подвал',
            'menu_slug' => 'st-footer-custom-code',
            'capability' => 'edit_posts',
            'position' => 51,
            'icon_url' => 'dashicons-chart-area',
            'redirect' => false
        ));
        // Слоты записи (занятые даты/время для формы обратной связи)
        acf_add_options_page(array(
            'page_title' => 'Слоты записи (форма обратной связи)',
            'menu_title' => 'Слоты записи',
            'menu_slug' => 'st-booking-slots',
            'capability' => 'edit_posts',
            'position' => 52,
            'icon_url' => 'dashicons-calendar-alt',
            'redirect' => false
        ));
    }

    /**
     * Кастомное поле вывода кода яндекс метрики
     */
    add_action('wp_footer', function () {
        if ($footer_scripts = get_field('st-footer-custom-code', 'option')) {
            echo $footer_scripts;
        }
    });

    /**
     * Группы полей
     */
    if (function_exists('acf_add_local_field_group')):
        // Поля для страницы Код в подвал
        acf_add_local_field_group(array(
            'key' => 'group_60b8e7dd79ad4',
            'title' => 'Вставьте код, который должен находится перед закрывающим тегом ' . htmlspecialchars('</body>'),
            'fields' => array(
                array(
                    'key' => 'field_60b8e7dd8086f',
                    'label' => 'Поле для кода',
                    'name' => 'st-footer-custom-code',
                    'type' => 'textarea',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '100',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => '',
                    'new_lines' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'st-footer-custom-code',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'field',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

    endif;
}

/**
 * Отключаем уведомления об обновлениях у плагинов
 */

function remove_plugin_updates($value)
{
    $plugins_to_disable = [
        "advanced-custom-fields-pro/acf.php",
        "acf-theme-code-pro/acf_theme_code_pro.php",
        "all-in-one-seo-pack-pro/all_in_one_seo_pack.php",
        "aioseo-image-seo/aioseo-image-seo.php",
        "aioseo-index-now/aioseo-index-now.php",
        "aioseo-link-assistant/aioseo-link-assistant.php",
        "aioseo-local-business/aioseo-local-business.php",
        "aioseo-news-sitemap/aioseo-news-sitemap.php",
        "aioseo-redirects/aioseo-redirects.php",
        "aioseo-rest-api/aioseo-rest-api.php",
        "aioseo-video-sitemap/aioseo-video-sitemap.php",
        "all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php",
        "wp-rocket/wp-rocket.php",
        "wordfence/wordfence.php",
        "wordfence-activator/wordfence-activator.php",
        "advanced-database-cleaner-pro/advanced-db-cleaner.php",
        "admin-menu-editor-pro/menu-editor.php",
        "ame-branding-add-on/ame-branding-add-on.php",
        "wp-toolbar-editor/load.php",
        "memberpress/memberpress.php",
        "wpcode-premium/wpcode.php",
        "wpdiscuz/class.WpdiscuzCore.php",
        "acf-extended-pro/acf-extended.php",
        "wpdiscuz-frontend-moderation/class.wpDiscuzFrontEndModeration.php",
    ];

    if (isset($value) && is_object($value)) {
        foreach ($plugins_to_disable as $plugin) {
            if (isset($value->response[$plugin])) {
                unset($value->response[$plugin]);
            }
        }
    }

    return $value;
}

add_filter("site_transient_update_plugins", "remove_plugin_updates");
