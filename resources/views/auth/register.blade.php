@extends('layout')

@section('head-tags')
    <title>Регистрация</title>
@endsection

@section('content')
    <div class="registration">
        <div class="container">
            <div class="form-holder">
                <div class="title">
                    Регистрация
                </div>
                <form class="register">
                    @csrf
                    <div class="form-group">
                        <label>Име<span>*</span></label>
                        <input type="text" class="form-control" name="name"/>
                    </div>
                    <div class="form-group">
                        <label>Имейл адрес<span>*</span></label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Телефон<span>*</span></label>
                        <input type="number" class="form-control" id="phone" name="phone"/>
                    </div>
                    <div class="form-group">
                        <label>Парола<span>*</span></label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Потвърди парола<span>*</span></label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Регистрирай се</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section("extra-js")
    <script>
        $(function () {
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

            $(".register").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    phone: {
                        required: true,
                        validPhone: true,
                        phoneCode: true,
                        phoneTooShort: true,
                        phoneTooLong: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                    password_confirmation: {
                        equalTo: '#password',
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

            $(".register").submit(function (e) {
                e.preventDefault();
                if ($(".register").valid()) {
                    var form = $(this),
                        formData = form.serialize(),
                        button = $(".register button");
                    $.ajax({
                        type: "POST",
                        url: "{{route("auth.create")}}",
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
                            button.html('Регистрирай се');
                        },
                        dataType: "json"
                    });
                }
                return false;
            });
        });
    </script>
@endsection
