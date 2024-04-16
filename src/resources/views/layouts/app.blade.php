<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
    <header class="header">
        <h1 class="header__inner">Rese</h1>
        <nav class="header__nav-list">
            <ul class="header__nav-list">
                @if (Auth::check())
                    <form class="logout__form" action="{{ route('logout') }}" method="post">
                    @csrf
                        <button class="logout__button">ログアウト</button>
                    </form>
                </li>
                @endif
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>