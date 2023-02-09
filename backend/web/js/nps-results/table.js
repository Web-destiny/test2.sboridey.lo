$('.open-comment').on('click', function () {
    let currentRow = $(this).closest('tr');
    let commentField = currentRow.next();
    if ($(commentField).hasClass('comment-row')) {
        $(commentField).toggleClass('open');
        $(this).toggleClass('opened');
        if ($(commentField).hasClass('open')) {
            $(commentField).fadeIn();
        } else {
            $(commentField).fadeOut();
        }
    } else return
});