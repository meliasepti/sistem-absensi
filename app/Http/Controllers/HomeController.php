<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $todayAttendance = Attendance::whereDate('attendance_date', today())->count();
        $totalAttendance = Attendance::count();
        $unlabeledCount = Attendance::whereNull('label')->count();
        
        $query = Attendance::with('user')->latest();

        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        }

        $recentAttendances = $query->take(5)->get();

        $alreadyAbsen = false;
        if (!$user->is_admin) {
            $alreadyAbsen = Attendance::where('user_id', $user->id)
                ->whereDate('attendance_date', today())
                ->exists();
        }

        return view('dashboard', compact(
            'todayAttendance', 
            'totalAttendance', 
            'unlabeledCount', 
            'recentAttendances',
            'alreadyAbsen'
        ));
    }
}