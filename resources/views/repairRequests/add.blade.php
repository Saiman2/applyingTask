@extends('layout')

@section('head-tags')
    <title>Добави заявка за ремонт</title>
@endsection

@section('content')
    <div class="add-request">
        <div class="container">
            <div class="form-holder">
                <div class="title">
                    Добавяне на зявка за ремонт
                </div>
                <form class="add-request-form" autocomplete="off">
                    @csrf
                    <div class="row userInfoWrapper loaderWrapper">
                        <div class="loader">
                            <div class="lds-ellipsis">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group search">
                                <label>Имейл<span>*</span></label>
                                <input type="email" class="form-control emailInput" name="email"/>
                                <div class="resultsHolder"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Имена<span>*</span></label>
                                <input type="text" class="form-control" name="name"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Телефон<span>*</span></label>
                                <input type="number" class="form-control" id="phone" name="phone"/>
                            </div>
                        </div>
                        <input type="hidden" name="user_id"/>
                        <div class="col-md-6 passwordHolder">
                            <div class="form-group">
                                <label>Парола<span>*</span></label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="col-md-6 passwordHolder">
                            <div class="form-group">
                                <label>Потвърди парола<span>*</span></label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="col-md-12 user-msg" style="display: none;">
                            <div class="alert alert-info">
                                Този потребител не съществува и ще бъде създаден при изпращане на заявката!
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Марка<span>*</span></label>
                                <input type="text" class="form-control" name="brand"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Модел<span>*</span></label>
                                <input type="text" class="form-control" name="model"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Година<span>*</span></label>
                                <input type="number" class="form-control" name="year"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Коментар</label>
                                <textarea class="form-control" name="comment" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Вероятен проблем<span>*</span></label>
                                <textarea class="form-control" name="probable_problem" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Вероятен проблем(според клиента)</label>
                                <textarea class="form-control" name="client_problem_info" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Време за решаване на проблема<span>*</span></label>
                                <div class="form-group">
                                    <input name="time_to_complete" class="form-control datepicker range"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Колко и какви служители ще работят по пролбема<span>*</span></label>
                                <textarea class="form-control" name="employees_required_info" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Коментар до служители</label>
                                <textarea class="form-control" name="employees_comment" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Коментар до клиента</label>
                                <textarea class="form-control" name="user_comment" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Сменени части</label>
                                <textarea class="form-control" name="changed_parts" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Цена за части</label>
                                <input type="number" class="form-control" name="parts_price"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Цена за труд</label>
                                <input type="number" class="form-control" name="labor_price"/>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Изпрати</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("extra-js")
    <script>
        $(function () {
            var typingTimer,
                doneTypingInterval = 200,
                $emailInput = $('.emailInput');
            $emailInput.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTypingUser, doneTypingInterval);
            });

            $emailInput.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            function doneTypingUser() {
                var search = $emailInput.val();
                $.ajax({
                    url: "{{route('search.users')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'search': search
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function (response) {
                        $('.resultsHolder').empty();
                        $("input[name='name']").val('');
                        $('input[name="phone"]').val('');
                        $('input[name="user_id"]').val('');
                        if (Object.keys(response.users).length > 0) {
                            $('.user-msg').slideUp(300);
                            $('.passwordHolder').slideUp(300);
                            $.each(response.users, function (key, value) {
                                $('.resultsHolder').append($('<a data-id="' + value.id + '">' + value.email + '</a>')).slideDown(500);
                            });
                        } else {
                            $('.resultsHolder').stop().slideUp(500);
                            $('.user-msg').slideDown(300);
                            $('.passwordHolder').slideDown(300);
                        }
                        parse();
                    },
                    error: function (data) {
                        window.prepareErrorResponse(data, "Оопс..");
                    }
                });
            }

            var clicked = false;

            function parse() {
                $('.resultsHolder a').click(function () {
                    clicked = true;
                    $('.loader').fadeIn(250);
                    $('.resultsHolder').stop().slideUp(500);
                    $.ajax({
                        type: "POST",
                        url: "{{route("get.user")}}",
                        data: {"_token": "{{ csrf_token() }}", id: $(this).attr('data-id')},
                        success: function (data) {
                            updateUserFields(data);
                        },
                        error: function (data) {
                            window.prepareErrorResponse(data, "Оопс..");
                        },
                        complete: function () {
                            $('.loader').fadeOut(250);
                        },
                        dataType: "json"
                    });
                });
            }

            $('.emailInput').focusin(function () {
                clicked = false;
            }).focusout(function () {
                $('.resultsHolder').stop().slideUp(500);
                if (!clicked && $(this).val()) {
                    if ($('.resultsHolder a').length) {
                        $('.loader').fadeIn(250);
                        $.ajax({
                            type: "POST",
                            url: "{{route("get.user")}}",
                            data: {"_token": "{{ csrf_token() }}", id: $('.resultsHolder a').first().attr('data-id')},
                            success: function (data) {
                                updateUserFields(data);
                            },
                            error: function (data) {
                                window.prepareErrorResponse(data, "Оопс..");
                            },
                            complete: function () {
                                $('.loader').fadeOut(250);
                            },
                            dataType: "json"
                        });
                    } else {
                        $('.user-msg').slideDown(300);
                        $('.passwordHolder').slideDown(300);
                    }
                }
            });

            function updateUserFields(data) {
                $emailInput.val(data.user.email);
                $(".add-request-form").validate().element("input[name='email']");
                $("input[name='name']").val(data.user.name);
                $(".add-request-form").validate().element("input[name='name']");
                $('input[name="phone"]').val(data.user.phone);
                $(".add-request-form").validate().element("input[name='phone']");
                $('input[name="user_id"]').val(data.user.id);
                $(".add-request-form").validate().element("input[name='user_id']");
            }

            var phoneInput = document.querySelector("#phone"),
                iti = window.intlTelInput(phoneInput, {
                    initialCountry: "bg",
                    autoPlaceholder: true,
                    autoHideDialCode: true,
                    formatOnDisplay: true,
                    nationalMode: true,
                    separateDialCode: true,
                });

            jQuery.validator.addMethod("validPhone", function () {
                return !$('#phone').val() ? true : ((iti.getValidationError() == 0 || iti.getValidationError() == 4) && iti.isValidNumber() == false ? false : true);
            }, window.getLiveValidationHtml('Невалиден номер!'));
            jQuery.validator.addMethod("phoneCode", function () {
                return iti.getValidationError() == 1 ? false : true;
            }, window.getLiveValidationHtml('Невалиден код на държавата!'));
            jQuery.validator.addMethod("phoneTooShort", function () {
                return iti.getValidationError() == 2 ? false : true;
            }, window.getLiveValidationHtml('Твърде кратък!'));
            jQuery.validator.addMethod("phoneTooLong", function () {
                return iti.getValidationError() == 3 ? false : true;
            }, window.getLiveValidationHtml('Твърде дълъг!'));

            $(".add-request-form").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    phone: {
                        required: true,
                        validPhone: true,
                        phoneCode: true,
                        phoneTooShort: true,
                        phoneTooLong: true,
                    },
                    password: {
                        required: '#password:visible',
                        minlength: 8,
                    },
                    password_confirmation: {
                        equalTo: '#password',
                    },
                    brand: {
                        required: true,
                    },
                    model: {
                        required: true,
                    },
                    year: {
                        required: true,
                    },
                    time_to_complete: {
                        required: true,
                    },
                    probable_problem: {
                        required: true,
                    },
                    employees_required_info: {
                        required: true,
                    },
                },
                // Specify validation error messages
                messages: {
                    name: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                        minlength: window.getLiveValidationHtml('Минималния брой символи е 3!'),
                        maxlength: window.getLiveValidationHtml('Максималния брой символи е 255!'),
                    },
                    email: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                        email: window.getLiveValidationHtml('Моля, въведете валиден имейл!'),
                    },
                    phone: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    password: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                        minlength: window.getLiveValidationHtml('Минималния брой символи е 8!'),
                    },
                    password_confirmation: {
                        equalTo: window.getLiveValidationHtml('Паролите не съответстват!'),
                    },
                    brand: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    model: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    year: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    time_to_complete: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    probable_problem: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    employees_required_info: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                },
                errorPlacement: function (error, element) {
                    if (element.attr('id') == 'phone') {
                        error.appendTo(element.parent().parent()).find('div').hide().slideDown(300);
                    } else {
                        error.appendTo(element.parent()).find('div').hide().slideDown(300);
                    }

                    if (element.hasClass('validation-error')) {
                        element.parent().addClass('validation-error-select');
                    } else {
                        element.parent().removeClass('validation-error-select');
                    }
                },
            });


            $(".add-request-form").submit(function (e) {
                e.preventDefault();
                if ($(".add-request-form").valid()) {
                    var form = $(this),
                        formData = form.serialize(),
                        button = $(".add-request-form button");
                    $.ajax({
                        type: "POST",
                        url: "{{route("add.repair.request.save")}}",
                        data: formData,
                        beforeSend: function () {
                            button.attr("disabled", 'disabled');
                            button.html('<div class="lds-ellipsis sm"><div></div><div></div><div></div><div></div></div>');
                        },
                        success: function (data) {
                            window.swal.fire({
                                text: data.msg,
                                icon: "success"
                            }).then(function () {
                                window.location.href = "{{route("home")}}";
                            });
                        },
                        error: function (data) {
                            window.prepareErrorResponse(data, "Оопс..");
                        },
                        complete: function () {
                            button.removeAttr("disabled");
                            button.html('Изпрати');
                        },
                        dataType: "json"
                    });
                }
                return false;
            });
        });
    </script>
@endsection
