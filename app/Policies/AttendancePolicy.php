<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->is_admin || $user->id === $attendance->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function label(User $user): bool
    {
        return $user->is_admin; // Hanya admin yang boleh label
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->is_admin;
    }
}