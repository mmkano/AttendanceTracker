<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;

class TimecardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        $attendanceToday = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();

        return view('index', compact('attendanceToday'));
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
                    }
                }
            }
            return back();
        }
}
