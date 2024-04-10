@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/code.css')}}">
@endsection

@section('content')
    <main>
        <div class="code__content">
        <h2 id="codeTitle">認証コード</h2>
        <p>認証コードは以下のメールアドレスに送信されました<br><strong>{{ $email }}</strong></p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="codeForm" action="{{ route('auth.code') }}" method="post">
            @csrf
            <label for="auth_code">認証コード（数字６桁）</label>
            <input id="auth_code" type="text" class="form-control" name="auth_code" required autofocus>
            <button type="submit" class="submit">認証する</button>
        </form>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="sub" action="{{ route('resend.code') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-link">認証コードを再送する</button>
        </form>
    </div>
    </main>

    <footer>
        <p>Atte, inc.</p>
    </footer>
@endsection