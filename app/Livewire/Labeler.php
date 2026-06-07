<?php

namespace App\Livewire;

use App\Models\Attendance;
use Livewire\Component;

class Labeler extends Component
{
    public $attendance = null;
    public $message = '';

    public function mount()
    {
        $this->loadNextImage();
    }

    public function loadNextImage()
    {
        $this->attendance = Attendance::whereNull('label')->with('user')->oldest()->first();
    }

    public function label($label)
    {
        if (!$this->attendance) {
            return;
        }

        $this->attendance->update([
            'label' => $label,
            'labeled_by' => auth()->id(),
            'labeled_at' => now(),
        ]);

        $this->message = '✅ Berhasil dilabeli sebagai ' . ucfirst($label);
        $this->loadNextImage();
    }

    public function render()
    {
        return view('livewire.labeler');
    }
}
