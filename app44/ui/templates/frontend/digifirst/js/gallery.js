$(document).ready(function () {
    sticky();
    $("a.grouped_elements").fancybox();

    $('.services-item').owlCarousel({
        rtl: true,
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        navText: ['<i class="fa fa-chevron-right">', '<i class="fa fa-chevron-left">'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });