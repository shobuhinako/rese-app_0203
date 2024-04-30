<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</head>

<body>

<header class="header">
    <button class="hamburger-menu" id="js-hamburger-menu">
        <span class="hamburger-menu__bar"></span>
        <span class="hamburger-menu__bar"></span>
        <span class="hamburger-menu__bar"></span>
    </button>
    <nav class="navigation">
        <ul class="navigation__list">
            <li class="navigation__list-item"><a href="#" class="navigation__link">Home</a></li>
            @if(Auth::check())
            <li class="navigation__list-item">
                <form class="navigation__link" action="{{ route('logout') }}" method="post">
                @csrf
                    <button class="logout__button">Logout</button>
                </form>
            </li>
            <li class="navigation__list-item"><a href="{{ route('mypage') }}" class="navigation__link">Mypage</a></li>
            @else
            <li class="navigation__list-item"><a href="{{ route('register') }}" class="navigation__link">Registration</a></li>
            <li class="navigation__list-item"><a href="{{ route('login') }}" class="navigation__link">Login</a></li>
            @endif
        </ul>
    </nav>
    <div class="logo">Rese</div>
</header>


    <main>
        @yield('content')
    </main>

<script>
    $(function () {
        $('#js-hamburger-menu, .navigation__link').on('click', function () {
        $('.navigation').slideToggle(500)
        $('.hamburger-menu').toggleClass('hamburger-menu--open')
        });
    });
</script>

</body>

</html>