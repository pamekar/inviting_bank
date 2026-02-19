<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\RequestLog;
use Livewire\Attributes\Layout;

class RequestMonitor extends Component
{
    public $expanded = [];

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.request-monitor', [
            'logs' => RequestLog::latest()->take(50)->get(),
        ]);
    }
}
