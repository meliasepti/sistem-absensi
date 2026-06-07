<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect setelah login berdasarkan role
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_admin) {
            return redirect()->route('dashboard');
        }

            $alreadyAbsen = \App\Models\Attendance::where('user_id', $user->id)
            ->whereDate('attendance_date', today())
            ->exists();

        if (!$alreadyAbsen) {
            return redirect()->route('attendance.create');
        }

        return redirect()->route('dashboard');
    }
}