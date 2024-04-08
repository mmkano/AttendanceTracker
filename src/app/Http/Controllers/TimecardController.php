<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class TimecardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        $attendanceToday = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();

        return view('index', compact('attendanceToday'));
        }
}
