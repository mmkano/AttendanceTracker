@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
    <main>
        <div class="login__content">
        <h2 id="loginTitle">ログイン</h2>
            <form id="loginForm" action="/login" method="post">
                @csrf
                    <input type="email" name="email" id="email" placeholder="メースアドレス" value="{{ old('email') }}">
                            @error('email')
                            {{ $message }}
                            @enderror

                    <input type="password" name="password" id="password" placeholder="パスワード">
                            @error('password')
                            {{ $message }}
                            @enderror

                    <button type="submit">ログイン</button>
            </form>
            <div class="sub">
                    アカウントをお持ちでない方はこちらから<br>
                    <a href="{{ route('register') }}">会員登録</a>
            </div>
    </div>
    </main>

    <footer>
        <p>Atte, inc.</p>
    </footer>
@endsection
