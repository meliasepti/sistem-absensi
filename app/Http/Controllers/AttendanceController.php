<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AttendanceController extends Controller
{
    public function create()
    {
        $already = Attendance::where('user_id', auth()->id())
            ->whereDate('attendance_date', today())
            ->exists();

        if ($already) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        return view('attendance.create');
    }

    public function store(Request $request)
    {
        $already = Attendance::where('user_id', auth()->id())
            ->whereDate('attendance_date', today())
            ->exists();

        if ($already) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda sudah absen hari ini.');
        }

        $photoData = $request->photo;

        if (str_contains($photoData, 'data:image')) {
            // Dari Kamera (Base64)
            $photoData = explode(',', $photoData)[1];
            $imageContent = base64_decode($photoData);
        } else {
            // Dari File Upload
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120'
            ]);
            $imageContent = file_get_contents($request->file('photo')->getRealPath());
        }

        $filename = auth()->id() . '_' . time() . '.jpg';
        $path = "attendances/{$filename}";

        Storage::disk('public')->put($path, $imageContent);

        Attendance::create([
            'user_id' => auth()->id(),
            'image_path' => $path,
            'attendance_date' => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Absensi berhasil dicatat! 📸');
    }

    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'labeledBy'])->latest();

        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        }
        if ($request->filled('label')) {
            $query->where('label', $request->label);
        }

        $attendances = $query->paginate(15)->withQueryString();

        $totalUsers = \App\Models\User::count();
        $todayCount = Attendance::whereDate('attendance_date', today())->count();

        return view('attendance.index', compact(
            'attendances', 
            'totalUsers', 
            'todayCount'
        ));
    }
}