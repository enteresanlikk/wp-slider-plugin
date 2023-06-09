<?php
if (!defined('ABSPATH')) exit;

$post_id = $post->ID;
$link_text = get_post_meta($post_id, 'wp_slider_link_text', true) ?? '';
$link_url = get_post_meta($post_id, 'wp_slider_link_url', true) ?? '';
?>

<table class="form-table wp-slider-metabox">
    <input type="hidden" name="wp_slider_nonce" value="<?= wp_create_nonce('wp_slider_nonce') ?>">
    <tr>
        <th>
            <label for="wp_slider_link_text">
                <?= esc_html_e('Link Text', 'wp-slider') ?>
            </label>
        </th>
        <td>
            <input
                type="text"
                name="wp_slider_link_text"
                id="wp_slider_link_text"
                class="regular-text link-text"
                value="<?= esc_html($link_text) ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="wp_slider_link_url">
                <?= esc_html_e('Link URL', 'wp-slider') ?>
            </label>
        </th>
        <td>
            <input
                    type="text"
                    name="wp_slider_link_url"
                    id="wp_slider_link_url"
                    class="regular-text link-url"
                    value="<?= esc_url($link_url) ?>"
                    required
            >
        </td>
    </tr>
</table>