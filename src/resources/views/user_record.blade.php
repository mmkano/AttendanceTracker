@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/record.css')}}">
@endsection

@section('content')
<main>
            <div class="atte__content">
            <div class="ttl">
                <div class="name-ttl">
                    <h2>{{ $user->name }}の勤怠記録</h2>
                </div>
                <div class="total">
                <h2>総労働時間 : {{ $totalHoursOverall }}時間{{ $totalMinutesOverall }}分</h2>
                </div>
            </div>
            <div class="date-picker">
                <form method="get" action="{{ route('user.records', ['userId' => $user->id]) }}">
                    <button type="submit" name="change_date" value="previous">＜</button>
                    <input type="month" name="date" value="{{ $date ?? \Carbon\Carbon::now()->format('Y-m') }}" class="date-display">
                    <button type="submit" name="change_date" value="next">＞</button>
                </form>
            </div>
                <table class="attendance-table">
                    <tr>
                        <th>日付</th>
                        <th>勤務開始</th>
                        <th>勤務終了</th>
                        <th>休憩時間</th>
                        <th>勤務時間</th>
                    </tr>
                    @foreach ($records as $record)
                    <tr>
                        <td>{{ $record['date'] }}</td>
                        <td>{{ $record['start_time'] }}</td>
                        <td>{{ $record['end_time'] }}</td>
                        <td>{{ $record['total_break_time'] }}</td>
                        <td>{{ $record['total_work_time'] }}</td>
                    </tr>
                    @endforeach
                </table>
        </div>
        </main>
        <footer>
            <p>Atte, inc.</p>
        </footer>
@endsection
