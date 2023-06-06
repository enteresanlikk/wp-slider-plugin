<?php
if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1>
        <?= esc_html(get_admin_page_title()) ?>
    </h1>

    <form action="options.php" method="post">
        <?php
            settings_fields('wp_slider_group');
            do_settings_sections('wp_slider_page_1');
            do_settings_sections('wp_slider_page_2');
            submit_button();
        ?>
    </form>
</div>