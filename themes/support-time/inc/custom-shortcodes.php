<?php
/***************************************************************
 * Шорткод вывода файлов и виджетов [st-code f="f.php"]
 ****************************************************************/

/**
 * Шорткод вывода файлов и виджетов [st-code f="f.php"]
 * @param string $attr
 * @return false|string
 */
function st_shortcode_get_file($attr = '')
{
    extract(shortcode_atts(array('f'), $attr));

    $fileName = $attr['f'];

    if (empty($fileName)) {
        return 'Не указан главный атрибут f="file.php"';
    }
    $ext = explode('.', $fileName);
    if (empty($ext[1]) || !in_array($ext[1], array('html', 'php'))) {
        return 'Используйте только файлы следующих форматов: .html или .php';
    }

    $file = get_template_directory() . '/my-get-files/' . $fileName;

    if (!file_exists($file)) return 'Файл по ' . $fileName . ' найден';

    ob_start();
    require $file;
    return ob_get_clean();

}

add_shortcode('st-code', 'st_shortcode_get_file');

/**
 * [CF7] Шорткоды кастомных полей
 */
if (in_array('contact-form-7/wp-contact-form-7.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    function st_pol_cod_cf7_func()
    {
        return '
            <div class="items-soglasie">
                <div class="custom-checkbox">
                    <input type="checkbox"
                       class="custom-checkbox_input"
                       name="accessInput"
                       id="accessInput"
                    >
                    <label class="custom-checkbox_label align-items-start"
                           for="accessInput">
                         <p class="color-grey mb-0">Отправляя форму, вы соглашаетесь с 
                        <a href="/politika-konfidencialnosti/" class="color-default" target="_blank">политикой конфиденциальности</a></p>
                    </label>
                </div>
            </div>
        ';
    }

    wpcf7_add_form_tag('politiki', 'st_pol_cod_cf7_func');
}

/**
 * [ACF] Шорткод вывода контактов
 */
if (in_array('advanced-custom-fields-pro/acf.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    function st_site_info_shortcode($attrs): string
    {
        $fields = [
            'email' => 'email',
            'email_text' => 'email',
            'phone' => 'phone',
            'phone_text' => 'phone',
            'whatsapp' => 'whatsapp',
            'whatsapp_text' => 'whatsapp',
            'instagram' => 'instagram',
            'instagram_text' => 'instagram',
            'telegram' => 'telegram',
            'telegram_text' => 'telegram',
        ];

        // Получаем значения полей
        $values = [];
        foreach ($fields as $key => $field_name) {
            $values[$key] = get_field($field_name, 'option');
            $values[$key . '_text'] = get_field($field_name, 'option'); // Для текстовых версий
        }

        // Определяем атрибут
        $attr = !empty($attrs) ? $attrs[0] : '';

        if (empty($attr) || !isset($values[$attr])) {
            return 'Укажите правильный атрибут (email, phone, whatsapp, etc.)';
        }

        switch ($attr) {
            case 'email':
                return '<a class="color-default" href="mailto:' . esc_attr($values[$attr]) . '">' . esc_html($values[$attr]) . '</a>';

            case 'phone':
                $clean_phone = preg_replace('/[^0-9]/', '', $values[$attr]);
                return '<a class="color-default" href="tel:' . esc_attr($clean_phone) . '">' . esc_html($values[$attr]) . '</a>';

            case 'email_text':
            case 'phone_text':
            case 'whatsapp_text':
            case 'instagram_text':
            case 'telegram_text':
                return esc_html($values[$attr]);

            default:
                return 'Неверный атрибут. Доступные: email, phone, whatsapp, instagram, telegram';
        }
    }

    add_shortcode('site_info', 'st_site_info_shortcode');
}
