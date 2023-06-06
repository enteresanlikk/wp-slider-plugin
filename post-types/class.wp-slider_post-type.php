<?php

if (!defined('ABSPATH')) exit;

if(!class_exists('WP_Slider_CPT')) {
    class WP_Slider_Post_Type {
        public function __construct() {
            add_action('init', array($this, 'create_post_type'));

            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));

            add_action('save_post', array($this, 'save_post'));

            add_filter('manage_wp-slider_posts_columns', array($this, 'add_columns'));
            add_action('manage_wp-slider_posts_custom_column', array($this, 'add_columns_content'), 10, 2);
            add_filter('manage_edit-wp-slider_sortable_columns', array($this, 'add_sortable_columns'));
        }

        public function create_post_type() {
            register_post_type(
                'wp-slider',
                array(
                    'label' => __('Sliders', 'wp-slider'),
                    'description' => __('Sliders', 'wp-slider'),
                    'labels' => array(
                        'name' => __('Sliders', 'wp-slider'),
                        'singular_name' => __('Slider', 'wp-slider')
                    ),
                    'public' => true,
                    'supports' => array(
                        'title',
                        'editor',
                        'thumbnail',
                        'page-attributes'
                    ),
                    'hierarchical' => true,
                    'show_ui' => true,
                    'show_in_menu' => false,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => true,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true
                )
            );
        }

        public function add_meta_boxes() {
            add_meta_box(
                'wp-slider-meta-box',
                __('Slider Settings', 'wp-slider'),
                array($this, 'add_inner_meta_boxes'),
                'wp-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes($post) {
            require_once(WP_SLIDER_PATH . 'views/wp-slider_metabox.php');
        }

        public function save_post($post_id) {
            if(isset($_POST['wp_slider_nonce'])) {
                if(!wp_verify_nonce($_POST['wp_slider_nonce'],  'wp_slider_nonce')) {
                    return;
                }
            }

            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if(isset($_POST['post_type']) && $_POST['post_type'] == 'wp-slider') {
                if(!current_user_can('edit_page', $post_id)) {
                    return;
                } else if(!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            if(isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_link_text = get_post_meta($post_id, 'wp_slider_link_text', true);
                $new_link_text = sanitize_text_field($_POST['wp_slider_link_text'] ?? '');

                $old_link_url = get_post_meta($post_id, 'wp_slider_link_url', true);
                $new_link_url = esc_url_raw($_POST['wp_slider_link_url'] ?? '#');

                update_post_meta($post_id, 'wp_slider_link_text', $new_link_text, $old_link_text);
                update_post_meta($post_id, 'wp_slider_link_url', $new_link_url, $old_link_url);
            }
        }

        public function add_columns($columns) {
            $columns['wp_slider_link_text'] = esc_html__('Link Text', 'wp-slider');
            $columns['wp_slider_link_url'] = esc_html__('Link URL', 'wp-slider');

            return $columns;
        }

        public function add_columns_content($column, $post_id) {
            switch($column) {
                case 'wp_slider_link_text':
                    echo esc_html(get_post_meta($post_id, 'wp_slider_link_text', true));
                    break;
                case 'wp_slider_link_url':
                    echo esc_url(get_post_meta($post_id, 'wp_slider_link_url', true));
                    break;
            }
        }

        public function add_sortable_columns($columns) {
            $columns['wp_slider_link_text'] = 'wp_slider_link_text';
            $columns['wp_slider_link_url'] = 'wp_slider_link_url';

            return $columns;
        }
    }
}