<?php
/*
 * Plugin Name: WP Slider
 * Version: 1.0.0
 * Author: Bilal Demir
 * Author URI: https://bilaldemir.dev
 * Text Domain: wp-slider
 * Domain Path: /languages
 * Requires at least: 6.2
 */

if (!defined('ABSPATH')) exit;

if(!class_exists('WP_Slider')) {
    class WP_Slider {
        function __construct() {
            $this->define_constans();

            add_action('admin_menu', array($this, 'add_admin_menu'));

            require_once(WP_SLIDER_PATH . 'post-types/class.wp-slider_post-type.php');
            $wp_slider_post_type = new WP_Slider_Post_Type();

            require_once(WP_SLIDER_PATH . 'inc/class.wp-slider_setting.php');
            $wp_slider_settings = new WP_Slider_Settings();
        }

        public function define_constans() {
            define('WP_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('WP_SLIDER_URL', plugin_dir_url(__FILE__));
            define('WP_SLIDER_VERSION', '1.0.0');
        }

        public function activate() {
            update_option('rewrite_rules', '');
        }

        public function deactivate() {
            flush_rewrite_rules();
            unregister_post_type('wp-slider');
        }

        public function uninstall() {

        }

        public function add_admin_menu() {
            /*
             * add_theme_page -> Appearence tab
             * add_options_page -> Setting tab
             */
            add_menu_page(
                __('WP Slider Options', 'wp-slider'),
                __('WP Slider', 'wp-slider'),
                'manage_options',
                'wp-slider-admin',
                array($this, 'admin_settings_page'),
                'dashicons-images-alt2'
            );

            add_submenu_page(
                'wp-slider-admin',
                __('WP Manage Slides', 'wp-slider'),
                __('WP Manage Slides', 'wp-slider'),
                'manage_options',
                'edit.php?post_type=wp-slider',
                null,
                null
            );

            add_submenu_page(
                'wp-slider-admin',
                __('WP Add New Slide', 'wp-slider'),
                __('WP Add New Slide', 'wp-slider'),
                'manage_options',
                'post-new.php?post_type=wp-slider',
                null,
                null
            );
        }

        public function admin_settings_page() {
            require_once(WP_SLIDER_PATH.'views/settings-page.php');
        }
    }
}

if(class_exists('WP_Slider')) {
    register_activation_hook(__FILE__, array('WP_Slider', 'Activate'));
    register_deactivation_hook(__FILE__, array('WP_Slider', 'Deactivate'));
    register_uninstall_hook(__FILE__, array('WP_Slider', 'Uninstall'));

    $wp_slider = new WP_Slider();
}