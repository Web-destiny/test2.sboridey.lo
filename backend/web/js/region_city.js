jQuery(function ($) {
    function updateCustomSelect(selector, data, callback) {
        $(selector).html('');
        $(selector).closest('.select').find('.select-options').html('');

        switch (selector) {
            case '.city-select':

                $(selector).closest('.filter-item-cement').removeClass('picked').find('.select-styled').html('Подразделение');

                $('.city-select').closest('.select').find('.select-options').html('');
                $('.city-select').html('');
                break;
        }

        if(!jQuery.isEmptyObject(data)) {
            data.map(({id, name}) => {
                $(selector).append(`<option value="${id}">${name}</option>`);
                $(selector).closest('.select').find('.select-options').append(`<li rel="${id}">${name}</li>`);
            });
        }

        if (callback) {
            callback(data);
        }
    }


    $(document).ready(function () {
        const selectCityLabel = $('#signupform-city option:first-child').text();

        $('.region-select').on('change', e => {
            const self = $(e.currentTarget);
            let data = {
                value: self.val()
            };

            $.ajax ({
                type: 'GET',
                url: "/site/cities",
                dataType: "json",
                data: data,
                success: data => updateCustomSelect('.city-select', data, data => {
                    console.log('cities list updated');

                    $('.city-select').closest('.select').find('.select-styled').html(data?.[0]?.name || selectCityLabel);
                })

            });
        });

        $('#signupform-profession').on('change', e => {
            const self = $(e.currentTarget);
            const showComment = 'show comment';
            let data = {
                value: self.val()
            };

            $.ajax ({
                type: 'GET',
                url: "/site/professin-visibility",
                dataType: "json",
                data: data,
                success: function( data ) {
                    if(data.hasOwnProperty('extra1') && data.extra1 == showComment) {
                        $('#signupform-profession_comment').css('display', 'block');
                    } else {
                        $('#signupform-profession_comment').val('');
                        $('#signupform-profession_comment').css('display', 'none');
                    }
                }

            });

        });


    });
});