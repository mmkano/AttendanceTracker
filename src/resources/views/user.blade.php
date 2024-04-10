@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css')}}">
@endsection

@section('content')
        <main>
            <div class="atte__content">
            <div class="search-form" >
            <form action="{{ url('users') }}" method="GET">
                <div class="form-group">
                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="名前を入力">
                </div>
                <button type="submit" class="btn btn-primary">検索</button>
            </form>
        </div>

                <table class="attendance-table">
                    <tr>
                        <th>名前</th>
                        <th>勤務表</th>
                    </tr>

                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td><a href="" class="user_btn">勤怠表</a></td>
                    </tr>
                    </tr>
                    @endforeach
                </table>
                <div class="pagination">
                    {{ $users->links('vendor.pagination.simple-custom') }}
                </div>
        </div>
        </main>

        <footer>
            <p>Atte, inc.</p>
        </footer>
@endsection