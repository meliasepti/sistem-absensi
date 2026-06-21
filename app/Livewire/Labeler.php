<?php

namespace App\Livewire;

use App\Models\Attendance;
use Livewire\Component;

class Labeler extends Component
{
    public $attendance = null;
    public $selectedLabel = null;
    public $filterDate = '';
    public $totalLabeled = 0;
    public $totalQueue = 0;
    public $progressPercentage = 0;

    protected $queryString = [
        'filterDate' => ['except' => '']
    ];

    public function mount()
    {
        $this->filterDate = request()->query('filterDate', now()->toDateString());
        $this->loadData();
    }

    public function updatedFilterDate($value)
    {
        $this->filterDate = $value;
        $this->selectedLabel = null;
        $this->loadData();
    }

    public function loadData()
    {
        $queryBase = Attendance::query();

        if ($this->filterDate) {
            $queryBase->whereDate('attendance_date', $this->filterDate);
        }

        $this->totalLabeled = (clone $queryBase)->whereNotNull('label')->count();
        $this->totalQueue   = (clone $queryBase)->count();

        $this->progressPercentage = $this->totalQueue > 0
            ? round(($this->totalLabeled / $this->totalQueue) * 100, 1)
            : 0;

        $this->attendance = (clone $queryBase)
            ->whereNull('label')
            ->with('user')
            ->oldest()
            ->first();

        $this->selectedLabel = null;
    }

    public function selectLabel($label)
    {
        $allowedLabels = ['good', 'spoof', 'abnormal'];
        if (!in_array($label, $allowedLabels)) return;
        $this->selectedLabel = $label;
    }

    public function saveAndNext()
    {
        if (!$this->attendance || !$this->selectedLabel) {
            return;
        }

        Attendance::where('id', $this->attendance->id)->update([
            'label'      => $this->selectedLabel,
            'labeled_by' => auth()->id(),
            'labeled_at' => now(),
        ]);

        $this->loadData();
    }

    public function skipImage()
    {
        if (!$this->attendance) {
            return;
        }

        $skippedId = $this->attendance->id;

        $this->loadData();

        if ($this->attendance && $this->attendance->id === $skippedId) {
            $this->attendance = null;
        }
    }

    public function render()
    {
        return view('livewire.labeler');
    }
}