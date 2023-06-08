(function($) {
    $(document).ready(function() {
        new Swiper('.swiper', {
            spaceBetween: 40,
            loop: true,
            pagination: {
                enabled: WP_SLIDER_OPTIONS.show_bullets == 'true',
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    });
})(jQuery);