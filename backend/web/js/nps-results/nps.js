jQuery(function ($) {
    $(document).ready(function () {
        // preloader
        $('.load-wrapper').fadeOut();
    });

    let diapasonItems = document.querySelectorAll('.nps-diapason-box select');

    function checkDiapasone(el) {
        const startVal = parseInt(el[0].value);
        const endVal = parseInt(el[1].value);
        const startItemStatus = el[0].getAttribute('changed');
        const endItemStatus = el[1].getAttribute('changed');
        if (startItemStatus === 'true' && endItemStatus === 'true') {
            if (!isNaN(startVal) && !isNaN(endVal)) {
                if (startVal > endVal) {
                    $('.diapason-error').fadeIn();
                } else {
                    $('.diapason-error').fadeOut();
                }
            } else {
                $('.diapason-error').fadeIn();
            }

        } else {
            return
        }
    }

    $(diapasonItems).on('change', function () {
        this.setAttribute('changed', 'true');
        checkDiapasone(diapasonItems);
    })
});