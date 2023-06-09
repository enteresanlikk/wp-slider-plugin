<?php

if (!defined('ABSPATH')) exit;

if(!class_exists('WP_Slider_Settings')) {
    class WP_Slider_Settings {
        public static $options;

        public function __construct() {
            self::$options = get_option('wp_slider_settings');

            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init() {
            register_setting(
                'wp_slider_group',
                'wp_slider_settings',
                array($this, 'validate')
            );

            add_settings_section(
                'wp_slider_main_section',
                esc_html__('How does it work?', 'wp-slider'),
                null,
                'wp_slider_page_1'
            );

            add_settings_section(
                'wp_slider_second_section',
                esc_html__('Other Options', 'wp-slider'),
                null,
                'wp_slider_page_2'
            );

            add_settings_field(
                'wp_slider_shortcode',
                esc_html__('Shortcode', 'wp-slider'),
                array($this, 'shortcode_callback'),
                'wp_slider_page_1',
                'wp_slider_main_section'
            );

            add_settings_field(
                'wp_slider_title',
                esc_html__('Slider Title', 'wp-slider'),
                array($this, 'slider_title_callback'),
                'wp_slider_page_2',
                'wp_slider_second_section',
                array(
                    'label_for' => 'wp_slider_title'
                )
            );

            add_settings_field(
                'wp_slider_bullets',
                esc_html__('Display Bullets', 'wp-slider'),
                array($this, 'bullets_callback'),
                'wp_slider_page_2',
                'wp_slider_second_section',
                array(
                    'label_for' => 'wp_slider_bullets'
                )
            );

            add_settings_field(
                'wp_slider_style',
                esc_html__('Slider Style', 'wp-slider'),
                array($this, 'slider_style_callback'),
                'wp_slider_page_2',
                'wp_slider_second_section',
                array(
                    'styles' => array(
                        array(
                            'value' => 'style-1',
                            'text' => 'Style 1'
                        ),
                        array(
                            'value' => 'style-2',
                            'text' => 'Style 2'
                        ),
                    ),
                    'label_for' => 'wp_slider_style'
                )
            );
        }

        public function validate($input) {
            if(!is_array($input)) {
                return;
            }
            if(count($input) == 0) {
                return;
            }
            $output = array();

            foreach($input as $key => $value) {
                switch ($key) {
                    case 'wp_slider_title':
                        if(empty($value)) {
                            add_settings_error(
                                'wp_slider_settings',
                                'wp_slider_title_error',
                                esc_html__('Please, write title', 'wp-slider'),
                                'error'
                            );
                        }
                        $output[$key] = sanitize_text_field($value);
                        break;
                    default:
                        $output[$key] = sanitize_text_field($value);
                        break;
                }
            }

            return $output;
        }

        public function shortcode_callback() { ?>
            <code>[wp_slider]</code>
        <?php }

        public function slider_title_callback() { ?>
            <input
                type="text"
                name="wp_slider_settings[wp_slider_title]"
                id="wp_slider_title"
                value="<?= esc_attr(self::$options['wp_slider_title'] ?? '') ?>"
            >
        <?php }

        public function bullets_callback() { ?>
            <input
                type="checkbox"
                name="wp_slider_settings[wp_slider_bullets]"
                id="wp_slider_bullets"
                value="1"
                <?=
                    checked(
                    1,
                    self::$options['wp_slider_bullets'] ?? 0,
                    false
                    )
                ?>
            >
        <?php }

        public function slider_style_callback($args) { ?>
            <select
                name="wp_slider_settings[wp_slider_style]"
                id="wp_slider_style"
            >
                <?php foreach($args['styles'] as $style): ?>
                    <option
                        value="<?= esc_attr($style['value']) ?>"
                        <?=
                            selected(
                                $style['value'],
                                self::$options['wp_slider_style'] ?? '',
                                false
                            )
                        ?>
                    >
                        <?= esc_html(ucfirst($style['text'])) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php }
    }
}