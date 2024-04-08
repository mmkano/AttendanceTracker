<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/base.css')}}">
    @yield('css')
</head>
<body>
<header class="header">
            <div class="header__inner">
                <a class="header__logo" href="/">
                    Atte
                </a>
                <nav>
                    <ul>
                        <li><a href="#">ホーム</a></li>
                        <li><a href="#">日付一覧</a></li>
                        <li>
                            <form class="logout" action="{{ route('logout') }}" method="post">
                            @csrf
                                <button type="submit">ログアウト</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
    </header>
    @yield('content')
</body>
</html>