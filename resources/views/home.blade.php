@extends('layout')

@section('head-tags')
    <title>Начало</title>
@endsection

@section('content')
    <div class="home">
        <div class="container">
            @if(Auth::guest())
                <div class="page-nav">
                    <h1>
                        Доверете вашия автомобил на нас!
                    </h1>
                    <h2>
                        При Пешо работим за Вас!
                    </h2>
                </div>
            @elseif(Auth::user()->role == 1)
                <div class="page-nav">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h1>
                                Заявки за ремонт
                            </h1>
                        </div>
                        <div class="col-md-5 text-right">
                            <a href="{{route('add.repair.request')}}" class="btn btn-primary">
                                Добави заявка
                            </a>
                        </div>
                    </div>
                </div>
                @include('partials.repairRequest',['tableInfo'=>$tableInfo])
            @else
                <div class="page-nav">
                    <h1>
                        Вашите коли за ремонт
                    </h1>
                </div>
                @include('partials.repairRequest',['tableInfo'=>$tableInfo])
            @endif

        </div>
    </div>
@endsection

@section("extra-js")
    <script>
        $(function () {
            $('.delete').click(function () {
                $('.loader').stop().fadeIn(250);
                var $this = $(this);
                window.swal.fire({
                    text: 'Сигурни ли сте че искате да изтриете зявката?',
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonText: 'Назад',
                    confirmButtonText: 'Да сигурен съм!',
                }).then((result) => {

                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "{{route("delete.repair.request")}}",
                            data: {"_token": "{{ csrf_token() }}", 'id': $this.attr('data-id')},
                            success: function (data) {
                                window.swal.fire({
                                    text: data.msg,
                                    icon: "success"
                                }).then(function () {
                                    $('.loader').stop().fadeOut(300);
                                    if ($('.custom-table tbody tr').length > 1) {
                                        $this.closest('tr').fadeOut(500, function () {
                                            $(this).remove();
                                            window.fitContent();
                                        });
                                    } else {
                                        $('.table-responsive').append($('<div class="alert alert-info" style="display:none;">Няма намерена ифнормация.</div>'));
                                        $('.custom-table').fadeOut(500, function () {
                                            window.fitContent();
                                            $('.table-responsive .alert').slideDown(500, function () {
                                                window.fitContent();
                                            });
                                        });
                                    }

                                });
                            },
                            error: function (data) {
                                $('.loader').stop().fadeOut(250);
                                window.prepareErrorResponse(data, "Оопс..");
                            },
                            dataType: "json"
                        });
                    } else {
                        $('.loader').stop().fadeOut(250);
                    }
                });
            });

            $('.jsEditStatus').click(function () {
                var $this = $(this);
                $('.loader').stop().fadeIn(250);
                $.ajax({
                    type: "POST",
                    url: "{{route("get.statuses")}}",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (data) {

                        var statusWrapper = document.createElement("div"),
                            statusSelect = document.createElement("select");
                        statusWrapper.classList.add('selectDefault');
                        statusSelect.classList.add('selectpicker');
                        statusSelect.id = "statusSelect";

                        $.each(data, function (key, value) {
                            var option = document.createElement("option");
                            option.value = value.id;
                            option.text = value.label;
                            if ($this.attr('data-statusId') == value.id) {
                                option.setAttribute('selected', 'selected');
                            }
                            statusSelect.appendChild(option);
                        });
                        statusWrapper.appendChild(statusSelect)
                        window.swal.fire({
                            title: "Смени статус на ремонт",
                            html: statusWrapper,
                            onBeforeOpen: () => {
                                $('.selectpicker').selectpicker();
                            },
                            showCancelButton: true,
                            customClass: 'swal-custom',
                            cancelButtonText: 'Назад',
                            confirmButtonText: 'Смени статус',
                        }).then((result) => {
                            if (result.value && statusSelect.options[statusSelect.selectedIndex].value != $this.attr('data-statusId')) {
                                $.ajax({
                                    dataType: "json",
                                    type: "POST",
                                    url: "{{route("repair.request.update.status")}}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        statusId: statusSelect.options[statusSelect.selectedIndex].value,
                                        id: $this.attr('data-id')
                                    },
                                    success: function (data) {
                                        $this.css({
                                            overflow: 'hidden',
                                            position: 'relative',
                                        }).attr('data-statusId', statusSelect.options[statusSelect.selectedIndex].value);

                                        var newStatusHtml = document.createElement("div"),
                                            iconHolder = document.createElement("div"),
                                            statusLabel = document.createElement("div"),
                                            i = document.createElement("i"),
                                            newStatusLabel = statusSelect.options[statusSelect.selectedIndex].text;

                                        newStatusHtml.classList.add('statusLabel');
                                        newStatusHtml.classList.add((newStatusLabel == 'Изчакване' ? 'await' : (newStatusLabel == 'Ремонтиране' ? 'inProcess' : 'completed')));
                                        newStatusHtml.setAttribute('data-toggle', 'tooltip');
                                        newStatusHtml.setAttribute('data-placement', 'top');
                                        newStatusHtml.setAttribute('title', 'Бърза редакция');
                                        newStatusHtml.setAttribute('style', 'position: absolute; left: 260px');

                                        iconHolder.classList.add('iconHolder');
                                        i.classList.add('bx');
                                        i.classList.add((newStatusLabel == 'Изчакване' ? 'bx-hourglass' : (newStatusLabel == 'Ремонтиране' ? 'bx-wrench' : 'bx-check')));
                                        iconHolder.appendChild(i);
                                        newStatusHtml.appendChild(iconHolder);
                                        statusLabel.classList.add('status');
                                        statusLabel.innerText = newStatusLabel;
                                        newStatusHtml.appendChild(statusLabel);
                                        $this.append(newStatusHtml);
                                        window.swal.fire({
                                            text: data.msg,
                                            icon: "success"
                                        }).then(() => {
                                            $('.loader').fadeOut(500);
                                            $this.find('>div').first().css('position', 'relative').animate({
                                                'left': '-200px',
                                            }, 1000, function () {
                                                setTimeout(function () {
                                                    $this.find('>div').first().remove();
                                                }, 300);
                                            });
                                            $this.find('>div').last().animate({
                                                'left': '0px',
                                            }, 1000, function () {
                                                setTimeout(function () {
                                                    $this.find('>div').last().css('position', 'relative').tooltip();
                                                }, 300);
                                            });
                                        });
                                    },
                                    error: function (data) {
                                        window.prepareErrorResponse(data, "{{trans("main.ooops")}}");
                                    },
                                });
                            } else {
                                $('.loader').fadeOut(500);
                            }
                        });
                    },
                    error: function (data) {
                        window.prepareErrorResponse(data, "Оопс..");
                    },
                    dataType: "json"
                });
            });
        });
    </script>
@endsection
