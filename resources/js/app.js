$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    window.swal = Swal.mixin({
        focusCancel: true,
    });


    window.fitContent = function () {
        var screenHeight = $(window).outerHeight(),
            header = $('.header').outerHeight(),
            mainContent = $('.main-content').outerHeight(),
            footerHeight = $('.footer').outerHeight(),
            totalElementHeight = header + mainContent + footerHeight;

        if (totalElementHeight < screenHeight) {
            var margin = Math.abs(screenHeight - totalElementHeight);
            if (margin < 80) {
                margin = 80;
            }
            $('.footer').animate({marginTop: margin + "px"}, 0);
        } else {
            $('.footer').animate({marginTop: '80px'}, 0);
        }

    };

    $(window).resize(function () {
        fitContent();
    });
    setTimeout(function () {
        fitContent();
    }, 46);

    window.prepareErrorResponse = function (response, title, text = null, type = 'error') {
        var errors = null,
            errorMessage = "";

        try {
            errors = JSON.parse(response.responseText);
            for (var m in errors) {
                console.log(errors[m]);
                if (typeof errors[m] === 'object') {
                    $.each(errors[m], function (key, value) {
                        errorMessage += value;
                    });
                } else {
                    errorMessage += errors[m];
                }
            }
        } catch (error) {
            errorMessage = 'Нещо се обърка. Моля опитайте по-късно.';
        }

        window.swal.fire({
            title: title,
            html: text ? text : errorMessage,
            icon: type
        });
    };

    window.getLiveValidationHtml = function (text) {
        return "<div class='box-icon'><i class='bx bx-error-circle'></i></i><div class='box-label'>" + text + "</div></div>"
    }

    $('.datepicker').focusin(function () {

        var default_format = 'DD.MM.YYYY',
            attr_format = $(this).attr('data-format');

        if (typeof attr_format !== typeof undefined && attr_format !== false) {
            default_format = attr_format;
        }
        var datepicker_options = {
            locale: {
                format: default_format,
                cancelLabel: 'Изчисти',
                "applyLabel": 'Приложи',
                "fromLabel": 'От',
                "toLabel": 'До',
                "customRangeLabel": 'Ръчно зададен',
                "weekLabel": "С",
                "daysOfWeek": [
                    'Нед.',
                    'Пон.',
                    'Вт.',
                    'Ср.',
                    'Четв.',
                    'Пет.',
                    'Съб.'
                ],
                "monthNames": [
                    'Януари',
                    'Февруари',
                    'Март',
                    'Април',
                    'Май',
                    'Юни',
                    'Юли',
                    'Август',
                    'Септември',
                    'Октомври',
                    'Ноември',
                    'Декември'
                ],
                "firstDay": 1,
            },
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
        };

        if ($(this).hasClass('clock')) {
            datepicker_options.timePicker = true;
            datepicker_options.timePicker24Hour = true;
            datepicker_options.timePickerSeconds = true;
            datepicker_options.locale.format = default_format + ' HH:mm:ss';
        } else if ($(this).hasClass('range')) {
            datepicker_options.singleDatePicker = false;
            datepicker_options.showDropdowns = false;
            datepicker_options.ranges = {};
            datepicker_options.ranges['Днес'] = [moment(), moment()];
            // datepicker_options.ranges['Вчера'] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
            // datepicker_options.ranges['Последните 7 дни'] = [moment().subtract(6, 'days'), moment()];
            // datepicker_options.ranges['Последните 30 дни'] = [moment().subtract(29, 'days'), moment()];
            datepicker_options.ranges['Този месец'] = [moment().startOf('month'), moment().endOf('month')];
            // datepicker_options.ranges['Последния месец'] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
            datepicker_options.opens = 'left';
        }
        var isInstanced = $(this).attr('data-instance');
        if (typeof isInstanced == 'undefined') {
            $(this).daterangepicker(datepicker_options).attr('data-instance', true);
        }
    });

    $('.datepicker').on('apply.daterangepicker', function (ev, picker) {
        var default_format = 'DD.MM.YYYY',
            attr_format = $(this).attr('data-format');

        if (typeof attr_format !== typeof undefined && attr_format !== false) {
            default_format = attr_format;
        }

        var val = picker.startDate.format(default_format);
        if ($(this).hasClass('clock')) {
            val = picker.startDate.format(default_format + ' HH:mm:ss');
        } else if ($(this).hasClass('range')) {
            val = picker.startDate.format(default_format) + ' - ' + picker.endDate.format(default_format);
        }
        $(this).val(val);
    });

    $('.datepicker').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});
