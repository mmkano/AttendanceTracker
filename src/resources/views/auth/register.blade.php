@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')
<main>
        <div class="register__content">
        <h2 id="registerTitle">会員登録</h2>
            <form id="registerForm" action="/register" method="post">
                @csrf
                <input type="text" name="name" id="name" placeholder="名前" value="{{ old('name') }}">
                    <p class="register-form__error-message">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </p>
                <input type="email" name="email" id="email" placeholder="メースアドレス" value="{{ old('email') }}">
                    <p class="register-form__error-message">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                <input type="password" name="password" id="password" placeholder="パスワード" >
                    <p class="register-form__error-message">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </p>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="確認用パスワード">
                    <p class="register-form__error-message">
                        @error('password_confirmation')
                        {{ $message }}
                        @enderror
                    </p>

                <button type="submit">会員登録</button>
            </form>
            <div class="login-link">
                アカウントをお持ちの方はこちらから<br>
                <a href="{{ route('login') }}">ログイン</a>
            </div>
    </div>
    </main>

    <footer>
        <p>Atte, inc.</p>
    </footer>
@endsection