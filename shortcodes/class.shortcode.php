<?php

if(!class_exists('WP_Slider_Shortcode')) {
    class WP_Slider_Shortcode {
        public function __construct() {
            add_shortcode('wp_slider', array($this, 'add_shortcode'));
        }

        public function add_shortcode($atts = array(), $content = null, $tag = '') {
            $atts = array_change_key_case((array)$atts, CASE_LOWER);

            extract(shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }

            ob_start();
            require_once(WP_SLIDER_PATH . 'views/shortcode.php');

            wp_enqueue_script('wp-slider-main-script');
            wp_enqueue_style('wp-slider-swiper-style');
            wp_enqueue_style('wp-slider-shortcode-style');

            wp_slider_options();

            return ob_get_clean();
        }
    }
}