<?php
if (!defined('ABSPATH')) exit;

$tab = $_GET['tab'] ?? 'main';
?>

<div class="wrap">
    <h1>
        <?= esc_html(get_admin_page_title()) ?>
    </h1>

    <div class="nav-tab-wrapper">
        <a href="?page=wp-slider-admin&tab=main" class="nav-tab <?= $tab == 'main' ? 'nav-tab-active' : '' ?>">
            Main Options
        </a>
        <a href="?page=wp-slider-admin&tab=other" class="nav-tab <?= $tab == 'other' ? 'nav-tab-active' : '' ?>">
            Other Options
        </a>
    </div>

    <form action="options.php" method="post">
        <?php
            settings_fields('wp_slider_group');
            if($tab == 'main') {
                do_settings_sections('wp_slider_page_1');
            } else if($tab == 'other') {
                do_settings_sections('wp_slider_page_2');
            }
            submit_button();
        ?>
    </form>
</div>