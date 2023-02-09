jQuery(function ($) {
    $(document).ready(function () {
        //width of scroling line
        function setScrollWisth() {
            var s = $(window).scrollTop(),
                d = $(document).height(),
                c = $(window).height();
            var scrollPercent = Math.round((s / (d - c)) * 100);
            if ($('.progress-bar .proggres')) {
                $('.progress-bar .proggres').css('width', scrollPercent + '%');
            }
        }
        setScrollWisth();
        //when page is scrolled
        $(window).scroll(function () {
            setScrollWisth();
        });
        // preloader
        $('.load-wrapper').fadeOut();
        //animation
        AOS.init();

        // carousel
        if ($(window).width() < 992 & $(window).width() > 420) {
            stopPriceCarusel();
            startPriceCarusel();
        }
        if ($(window).width() <= 420) {
            startBenefitsCarusel();
            stopPriceCarusel();
            startDottedPriceCarusel();
        } else {
            $('.benefits-list').addClass('off');
            // stopPriceCarusel();
        }
    });
});


// Init or disable carusel on window resize
$(window).resize(function () {
    if ($(window).width() > 992) {
        stopPriceCarusel();
    }
    if ($(window).width() < 992 && $(window).width() > 420) {
        startPriceCarusel();
    }
    if ($(window).width() <= 420) {
        startBenefitsCarusel();
        stopPriceCarusel();
        startDottedPriceCarusel();
    } else {
        stopBenefitsCarusel();
    }
});

function startBenefitsCarusel() {
    $('.benefits .benefits-list').owlCarousel({
        items: 1,
        loop: true,
        center: true,
        dots: true,
    });
}

function stopBenefitsCarusel() {
    var owl = $('.benefits-list');
    owl.trigger('destroy.owl.carousel');
    owl.addClass('off');
}


function startPriceCarusel() {
    $('.price .price-row').owlCarousel({
        items: 2,
        loop: true,
        center: true,
    });
}

function startDottedPriceCarusel() {
    $('.price .price-row').owlCarousel({
        items: 1,
        loop: true,
        center: true,
        dots: true,
    });
}

function stopPriceCarusel() {
    var owl = $('.price .price-row');
    owl.trigger('destroy.owl.carousel');
    owl.addClass('off');
}


let toTopBtn = $('#to-top-button');

$(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
        toTopBtn.addClass('show');
    } else {
        toTopBtn.removeClass('show');
    }
});

toTopBtn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({
        scrollTop: 0
    }, '300');
});