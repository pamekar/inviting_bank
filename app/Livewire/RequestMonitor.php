<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\RequestLog;
use Livewire\Attributes\Layout;

class RequestMonitor extends Component
{
    public $expanded = [];
    public $search = '';

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
    }

    public function updateLogs()
    {
        // This method is called by wire:poll to refresh the component state
    }

    public function clearLogs()
    {
        RequestLog::truncate();
        $this->expanded = [];
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = RequestLog::latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('url', 'like', '%' . $this->search . '%')
                  ->orWhere('method', 'like', '%' . $this->search . '%')
                  ->orWhere('status_code', 'like', '%' . $this->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $this->search . '%');
            });
        }

        $logs = $query->take(50)->get();

        // Calculate metrics
        $metrics = [
            'total_24h' => RequestLog::where('created_at', '>=', now()->subDay())->count(),
            'avg_duration' => (int) RequestLog::where('created_at', '>=', now()->subDay())->avg('duration_ms'),
            'error_rate' => RequestLog::where('created_at', '>=', now()->subDay())
                ->where('status_code', '>=', 500)
                ->count(),
        ];

        return view('livewire.request-monitor', [
            'logs' => $logs,
            'metrics' => $metrics,
        ]);
    }
}
