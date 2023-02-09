jQuery(function ($) {
    function updateCustomSelect(selector, data, callback) {
        $(selector).html('');
        $(selector).closest('.select').find('.select-options').html('');

        $(selector).closest('.filter-item-cement').next().css('display', 'block');
        $(selector).closest('.filter-item-cement').next().css('display', 'block');

        switch (selector) {
            case '.department-select':
                $(selector).closest('.filter-item-cement').removeClass('picked').find('.select-styled').html('Подразделение');

                $('.supervisor-select').closest('.filter-item').removeClass('picked').find('.select-styled').html('ФИО руководителя');
                $('.supervisor-select').closest('.select').find('.select-options').html('');
                $('.supervisor-select').html('');
                break;
            case '.supervisor-select':
                $(selector).closest('.filter-item-cement').removeClass('picked').find('.select-styled').html('ФИО руководителя');
                break;
        }

        if(!jQuery.isEmptyObject(data)) {
            console.log(data)
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
        $('.city-select').on('change', e => {
            const self = $(e.currentTarget);
            const extra1 = $('#extra1').val();
            const param1 = $('#param1').val();
            let data = '';
            if(extra1 == '') {
               data = {
                    value: self.val()
                }
            } else (
                data = {
                value: self.val(),
                'extra1': extra1,
                'param1': param1
                }
            );


            $.ajax ({
                type: 'POST',
                url: "/backend/web/cement-city/departments",
                dataType: "json",
                data: data,
                success: data => updateCustomSelect('.department-select', data, data => {
                    updateCustomSelect('.supervisor-select', {}, data => {
                        self.closest('.filter-item-cement').find('.cement-select-label').css('color', '#000000');
                        console.log('department list updated');
                    });
                    $('.cement-select-label[data-id=1]').css('color', '#000000');
                    $('.cement-select-label[data-id=2]').css('color', '#FF0000');
                    $('.cement-select-label[data-id=3]').css('color', '#FF0000');

                    console.log('department list updated');



                })

            });
        });

        $('.department-select').on('change', e => {
            const self = $(e.currentTarget);

            const extra1 = $('#extra1').val();
            const param1 = $('#param1').val();
            let data = '';
            if(extra1 == '') {
                data = {
                    value: self.val()
                }
            } else (
                data = {
                    value: self.val(),
                    'extra1': extra1,
                    'param1': param1
                }
            );


            $.ajax ({
                type: 'POST',
                url: "/backend/web/cement-city/supervisors",
                dataType: "json",
                data: data,
                success: data => updateCustomSelect('.supervisor-select', data, data => {
                    $('.cement-select-label[data-id=2]').css('color', '#000000');
                    $('.cement-select-label[data-id=3]').css('color', '#FF0000');
                    console.log('supervisor list updated');
                })
            });

            $('.supervisor-select').on('change', e => {
                const self = $(e.currentTarget);

                const selectedItem = self.find('option:selected').html();
                self.closest('.filter-item-cement').find('.cement-select-label').css('color', '#000000');
                $('.valid-form-send').css('visibility', 'visible');

                $('.question-list').fadeIn();
                $('.question-element').fadeIn();

                $('.question-element > div').map((index, item) => {
                    const nameElement = $(item).find('.question-name');
                    console.log(nameElement)
                    const currentName = nameElement.data('origin');
                    const name = currentName.replaceAll(/\*tmpl\#/gi, selectedItem);

                    nameElement.html(name);
                });
            });
        });
    });
});