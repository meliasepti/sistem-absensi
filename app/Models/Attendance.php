<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id', 'image_path', 'attendance_date', 'label', 'labeled_by', 'labeled_at'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'labeled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function labeledBy()
    {
        return $this->belongsTo(User::class, 'labeled_by');
    }
}