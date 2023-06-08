<?php
if (!defined('ABSPATH')) exit;

$options = array(
    'post_type' => 'wp-slider',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'post__in' => $id,
    'orderby' => $orderby
);
$query = new WP_Query($options);

if($query->have_posts()): ?>
    <?php
        $title = esc_html(!empty($content) ? $content : WP_Slider_Settings::$options['wp_slider_title']);

        $style = esc_attr(WP_Slider_Settings::$options['wp_slider_style'] ?? 'default');
    ?>
    <h3>
        <?= $title ?>
    </h3>
    <div class="wp-slider swiper <?= $style ?>">
        <div class="swiper-wrapper">
            <?php while($query->have_posts()): ?>
                <?php
                    $query->the_post();

                    $id = get_the_ID();

                    $link_text = esc_html(get_post_meta($id, 'wp_slider_link_text', true));
                    $link_url = esc_attr(get_post_meta($id, 'wp_slider_link_url', true));
                ?>
                <div class="wp-slider__slide swiper-slide">
                    <?php
                        if(has_post_thumbnail()):
                            the_post_thumbnail('full', array('class' => 'wp-slider__image'));
                        else:
                            the_thumbnail_placeholder_image();
                        endif;
                    ?>
                    <div class="wp-slider__content">
                        <div class="wp-slider__title">
                            <?php the_title(); ?>
                        </div>
                        <div class="wp-slider__description">
                            <?php the_content(); ?>
                        </div>

                        <?php if(!empty($link_text) && !empty($link_url)): ?>
                            <a href="<?= $link_url ?>" class="wp-slider__link">
                                <?= $link_text ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>

        <div class="wp-slider__pagination swiper-pagination"></div>

        <div class="wp-slider__prev swiper-button-prev"></div>
        <div class="wp-slider__next swiper-button-next"></div>
    </div>
<?php endif; ?>