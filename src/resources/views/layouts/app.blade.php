<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
    <header class="header">
        <h1 class="header__inner">Atte</h1>
        <nav class="header__nav-list">
            <ul class="header__nav-list">
                @if (Auth::check())
                <li class="header__nav-item"><a href="{{ route('index') }}">ホーム</a></li>
                <li class="header__nav-item"><a href="{{ route('attendance') }}">日付一覧</a></li>
                <li class="header__nav-item">
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

    <footer>
        <div class="footer__inner">Atte, inc.</div>
    </footer>
</body>

</html>