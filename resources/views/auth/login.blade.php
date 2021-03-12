@extends('layout')

@section('head-tags')
    <title>Вход</title>
@endsection

@section('content')
    <div class="login">
        <div class="container">
            <div class="form-holder">
                <div class="title">
                    Вход
                </div>
                <form class="login-form">
                    @csrf

                    <div class="form-group">
                        <label>Имейл адрес</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="form-group">
                        <label>Парола</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Влез</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("extra-js")
    <script>
        $(function () {
            $(".login-form").validate({
                rules: {
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                // Specify validation error messages
                messages: {
                    email: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                    password: {
                        required: window.getLiveValidationHtml('Полето е задължително!'),
                    },
                },
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent()).find('div').hide().slideDown(300);
                    if (element.hasClass('validation-error')) {
                        element.parent().addClass('validation-error-select');
                    } else {
                        element.parent().removeClass('validation-error-select');
                    }
                },
            });

            $(".login-form").submit(function (e) {
                e.preventDefault();
                if ($(".login-form").valid()) {
                    var form = $(this),
                        formData = form.serialize(),
                        button = $(".login-form button");
                    $.ajax({
                        type: "POST",
                        url: "{{route("auth.check")}}",
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
                            button.html('Влез');
                        },
                        dataType: "json"
                    });
                }
                return false;
            });
        });
    </script>
@endsection
