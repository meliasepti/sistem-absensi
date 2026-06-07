<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'labeledBy'])->latest();

        if ($request->date) {
            $query->whereDate('attendance_date', $request->date);
        }
        if ($request->label) {
            $query->where('label', $request->label);
        }
        if (auth()->user()->is_admin && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->paginate(15)->withQueryString();

        $stats = Attendance::selectRaw('
            attendance_date,
            COUNT(*) as total,
            SUM(CASE WHEN label = "good" THEN 1 ELSE 0 END) as good,
            SUM(CASE WHEN label = "spoof" THEN 1 ELSE 0 END) as spoof,
            SUM(CASE WHEN label = "abnormal" THEN 1 ELSE 0 END) as abnormal
        ')
        ->groupBy('attendance_date')
        ->orderBy('attendance_date', 'desc')
        ->limit(30)
        ->get();

        $totalUsers = User::count();
        $todayCount = Attendance::whereDate('attendance_date', today())->count();

        return view('attendance.index', compact('attendances', 'stats', 'totalUsers', 'todayCount'));
    }

    public function create()
    {
        return view('attendance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $image = Image::make($request->file('photo'))
            ->resize(800, null, fn($c) => $c->aspectRatio())
            ->encode('jpg', 85);

        $filename = auth()->id() . '_' . time() . '.jpg';
        $path = "attendances/{$filename}";

        Storage::disk('public')->put($path, $image->stream());

        Attendance::create([
            'user_id' => auth()->id(),
            'image_path' => $path,
            'attendance_date' => now()->toDateString(),
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Absensi berhasil dicatat!');
    }

    public function labeler()
    {
        $attendance = Attendance::whereNull('label')
            ->with('user')
            ->oldest()
            ->first();

        return view('attendance.labeler', compact('attendance'));
    }

    public function label(Request $request, Attendance $attendance)
    {
        $request->validate(['label' => 'required|in:good,spoof,abnormal']);

        $attendance->update([
            'label' => $request->label,
            'labeled_by' => auth()->id(),
            'labeled_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Attendance $attendance)
    {
        if (Storage::disk('public')->exists($attendance->image_path)) {
            Storage::disk('public')->delete($attendance->image_path);
        }
        $attendance->delete();

        return back()->with('success', 'Data dihapus.');
    }
}