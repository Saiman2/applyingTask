<!DOCTYPE html>
<html lang="bg">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name='viewport' content='width=device-width'/>
    @yield('head-tags')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/public.css?v=' . filemtime(public_path("css/public.css"))) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . filemtime(public_path("css/app.css"))) }}">
</head>

<body>
<div class="outer-wrap">
    <header class="header">
        <nav class="main-nav">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <ul class="clearfix">
                            <li class="item {{addActive('home')}}">
                                <a class="brand" href="#">При Пешо</a>
                            </li>
                            <li class="item {{addActive('home')}}">
                                <a href="{{route('home')}}">Начало</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-right">
                        <ul class="clearfix">
                            @if(Auth::guest())
                                <li class="item {{addActive('auth.login')}}">
                                    <a href="{{route('auth.login')}}">Вход</a>
                                </li>
                                <li class="item {{addActive('auth.register')}}">
                                    <a href="{{route('auth.register')}}">Регистрация</a>
                                </li>
                            @else
                                <li class="item">
                                    <a href="{{route('auth.logout')}}">Изход</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="rights">
                © 2021 - {{ date("Y") . ' Всички права запазени'}}
            </div>
        </div>
    </footer>
</div>
<script src="{{ asset('js/public.js?v=' . filemtime(public_path("js/public.js")))}}"></script>
@yield("extra-js")
<script>
    $(function () {

    });
</script>
</body>
</html>
