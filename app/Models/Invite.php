<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = ['name', 'email', 'token',  'invited_by'];

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}