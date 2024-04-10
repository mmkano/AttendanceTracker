<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;
use Carbon\Carbon;

class TimecardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        $attendanceToday = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();
        $lastBreak = $attendanceToday ? $attendanceToday->breakTimes->sortByDesc('break_start_time')->first() : null;
        $isLastBreakEnded = $lastBreak ? (bool)$lastBreak->break_end_time : true;

        return view('index', compact('attendanceToday','isLastBreakEnded'));
        }

        public function handleAction(Request $request){
            $user = Auth::user();
            $today = now()->format('Y-m-d');
            $now = now();

            if ($request->has('work_action')) {
                $action = $request->input('work_action');
                if ($action == 'start_time') {
                    $exists = Attendance::where('user_id', $user->id)->whereDate('date', $today)->exists();
                    if (!$exists) {
                        Attendance::create([
                            'user_id' => $user->id,
                            'date' => $today,
                            'start_time' => $now,
                        ]);
                    }
                }elseif ($action == 'end_time') {
                    $attendance = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();
                    if ($attendance && !$attendance->end_time) {
                        $attendance->update(['end_time' => $now]);
                    }
                }
            }

            if ($request->has('break_action')) {
                $action = $request->input('break_action');
                $attendance = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();
                if ($attendance) {
                    if ($action == 'start_time') {
                        BreakTime::create([
                            'attendance_id' => $attendance->id,
                            'break_start_time' => $now->format('Y-m-d H:i:s'),
                        ]);
                    }elseif ($action == 'end_time') {
                        $breakTime = BreakTime::where('attendance_id', $attendance->id)->latest('break_start_time')->first();
                        if ($breakTime && !$breakTime->break_end_time) {
                            $breakTime->update(['break_end_time' => $now->format('Y-m-d H:i:s')]);
                        }
                    }
                }
            }
            return back();
        }

        public function showDailyAttendance(Request $request){
            $date = $request->input('date', Carbon::today()->toDateString());

            if ($request->has('change_date')) {
                $date = Carbon::createFromFormat('Y-m-d', $date);
                if ($request->input('change_date') === 'previous') {
                    $date = $date->subDay();
                } elseif ($request->input('change_date') === 'next') {
                    $date = $date->addDay();
                }
                $date = $date->toDateString();
            }

            if ($date == Carbon::today()->toDateString() && !$request->has('date')) {
                $query = Attendance::with(['user', 'breakTimes']);
            } else {
                $query = Attendance::with(['user', 'breakTimes'])->whereDate('date', $date);
            }

            $dailyAttendances = $query->paginate(5)->withQueryString();

            $dailyAttendances->getCollection()->transform(function ($attendance) {
                $totalBreakMinutes = $attendance->breakTimes->sum(function ($break) {
                return Carbon::parse($break->break_start_time)->diffInMinutes($break->break_end_time);
                });
                $workMinutes = $attendance->end_time ? Carbon::parse($attendance->start_time)->diffInMinutes($attendance->end_time) : 0;
                $totalWorkMinutes = $workMinutes - $totalBreakMinutes;
                return [
                    'user_name' => $attendance->user->name,
                    'start_time' => Carbon::parse($attendance->start_time)->format('H:i:s'),
                    'end_time' => $attendance->end_time ? Carbon::parse($attendance->end_time)->format('H:i:s') : '---',
                    'total_break_time' => sprintf('%02d:%02d:00', intdiv($totalBreakMinutes, 60), $totalBreakMinutes % 60),
                    'total_work_time' => sprintf('%02d:%02d:00', intdiv($totalWorkMinutes, 60), $totalWorkMinutes % 60),
                ];
            });
            return view('attendance_daily', compact('dailyAttendances', 'date'));
        }

        public function listUsers(Request $request){
            $search = $request->input('search');

            if (!empty($search)) {
                $users = User::where('name', 'like', '%' . $search . '%')->paginate(5);
            } else {
                $users = User::paginate(5);
            }

            return view('user', ['users' => $users]);
        }
}
