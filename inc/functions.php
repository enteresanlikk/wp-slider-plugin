<?php

if(!function_exists('get_the_thumbnail_placeholder_image')) {
    function get_the_thumbnail_placeholder_image() {
        return '<img src="' . WP_SLIDER_URL . 'assets/images/placeholder.jpg" alt="Placeholder" class="wp-slider__image">';
    }
}

if(!function_exists('the_placeholder_image')) {
    function the_thumbnail_placeholder_image() {
        echo get_the_thumbnail_placeholder_image();
    }
}

if(!function_exists('wp_slider_options')) {
    function wp_slider_options() {
        $show_bullets = isset(WP_Slider_Settings::$options['wp_slider_bullets']) && WP_Slider_Settings::$options['wp_slider_bullets'] == '1' ? 'true' : 'false';

        wp_enqueue_script(
            'wp-slider-options-script',
            'https://cdn.jsdelivr.net/npm/swiper@9.3.2/swiper-bundle.min.js',
            array(
                'jquery'
            ),
            WP_SLIDER_VERSION,
            true
        );
        wp_localize_script(
            'wp-slider-options-script',
            'WP_SLIDER_OPTIONS',
            array(
                'show_bullets' => $show_bullets
            )
        );
    }
}