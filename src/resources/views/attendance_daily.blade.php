@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css')}}">
@endsection

@section('content')
        <main>
            <div class="atte__content">
                <div class="date-picker">
                    <form method="get" action="{{ route('attendance_daily') }}">
                        <button type="submit" name="change_date" value="previous">＜</button>
                        <input type="date" name="date" value="{{ $date }}" class="date-display">
                        <button type="submit" name="change_date" value="next">＞</button>
                    </form>
                </div>

                <table class="attendance-table">
                    <tr>
                        <th>名前</th>
                        <th>勤務開始</th>
                        <th>勤務終了</th>
                        <th>休憩時間</th>
                        <th>勤務時間</th>
                    </tr>
                    @foreach ($dailyAttendances as $attendance)
                    <tr>
                        <td>{{ $attendance['user_name'] }}</td>
                        <td>{{ $attendance['start_time'] }}</td>
                        <td>{{ $attendance['end_time'] }}</td>
                        <td>{{ $attendance['total_break_time'] }}</td>
                        <td>{{ $attendance['total_work_time'] }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </main>
        <footer>
            <p>Atte, inc.</p>
        </footer>
@endsection