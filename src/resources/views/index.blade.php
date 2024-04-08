@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
        <main>
            <div class="atte__content">
                <h2>{{ Auth::user()->name }}さんお疲れ様です！</h2>
            <form action="{{ route('timecard.action') }}" method="post">
                @csrf
                <button type="submit" name="work_action" value="start_time" class="card" {{ $attendanceToday && is_null($attendanceToday->end_time) ? 'disabled' : '' }}>勤務開始</button>
                <button type="submit" name="work_action" value="end_time" class="card" {{ !$attendanceToday || !is_null($attendanceToday->end_time) ? 'disabled' : '' }}>勤務終了</button>
                <button type="submit" name="break_action" value="start_time" class="card" {{ !$attendanceToday || !is_null($attendanceToday->end_time) || !$isLastBreakEnded ? 'disabled' : '' }}>休憩開始</button>
                <button type="submit" name="break_action" value="end_time" class="card" {{ !$attendanceToday || $isLastBreakEnded ? 'disabled' : '' }}>休憩終了</button>
            </form>
        </div>
        </main>
        <footer>
            <p>Atte, inc.</p>
        </footer>
@endsection