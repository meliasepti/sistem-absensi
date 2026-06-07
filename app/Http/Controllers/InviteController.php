<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function index()
    {
        $invites = Invite::with('invitedBy')->latest()->paginate(15);
        return view('admin.invites.index', compact('invites'));
    }

    public function create()
    {
        return view('admin.invites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Buat User langsung
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        // Simpan data invite untuk tracking
        Invite::create([
            'name' => $request->name,
            'email' => $request->email,
            'token' => Str::random(64),
            'invited_by' => auth()->id(),
        ]);

        return redirect()->route('invites.index')
            ->with('success', "Akun untuk {$request->name} berhasil dibuat. Email: {$request->email} | Password: {$request->password}");
    }

    public function edit(Invite $invite)
    {
        return view('admin.invites.edit', compact('invite'));
    }

    public function update(Request $request, Invite $invite)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $invite->id,
        ]);

        $invite->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('invites.index')
            ->with('success', 'Undangan berhasil diperbarui');
    }

    public function destroy(Invite $invite)
    {
        $invite->delete();
        return redirect()->route('invites.index')
            ->with('success', 'Undangan berhasil dihapus');
    }
}