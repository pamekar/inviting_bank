<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8"
     wire:poll.5s="updateLogs"
     x-data="{ lastUpdate: '' }"
     x-init="console.log('Request Monitor: Dashboard initialized');"
     @logs-updated.window="console.log('Request Monitor: Logs refreshed at ' + $event.detail.timestamp + '. Total logs in DB: ' + $event.detail.count); lastUpdate = $event.detail.timestamp">
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Incoming HTTP Requests') }}
                </h2>
                <div wire:loading class="ml-4">
                    <svg class="animate-spin h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button wire:click="clearLogs"
                        onclick="confirm('Are you sure you want to clear all HTTP logs?') || event.stopImmediatePropagation()"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Clear Logs
                </button>
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Live Updates Active
                </span>
            </div>
        </div>
    </x-slot>

    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Requests (24h)</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $metrics['total_24h'] }}</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Avg. Response Time</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $metrics['avg_duration'] }}ms</dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Server Errors (5xx)</dt>
                <dd class="mt-1 text-3xl font-semibold text-red-600">{{ $metrics['error_rate'] }}</dd>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="mb-4 px-4 sm:px-6 lg:px-8">
            <input type="text" wire:model.live.debounce.300ms="search"
                   placeholder="Search logs (URL, Method, Status, IP)..."
                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
        </div>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Time
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Method
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Path
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Details</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition ease-in-out duration-150 cursor-pointer"
                                wire:click="toggleExpand({{ $log->id }})">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->created_at->format('H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $log->method === 'GET' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $log->method === 'POST' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $log->method === 'PUT' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $log->method === 'DELETE' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ !in_array($log->method, ['GET', 'POST', 'PUT', 'DELETE']) ? 'bg-gray-100 text-gray-800' : '' }}
                                        ">
                                            {{ $log->method }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" title="{{ $log->url }}">
                                    {{ Str::limit(parse_url($log->url, PHP_URL_PATH), 40) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $log->status_code >= 200 && $log->status_code < 300 ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $log->status_code >= 300 && $log->status_code < 400 ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $log->status_code >= 400 && $log->status_code < 500 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $log->status_code >= 500 ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ $log->status_code }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->duration_ms }}ms
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                        {{ in_array($log->id, $expanded) ? 'Collapse' : 'Expand' }}
                                    </a>
                                </td>
                            </tr>
                            @if(in_array($log->id, $expanded))
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-4 bg-gray-50 text-sm text-gray-700 border-t border-gray-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="font-bold mb-2">Request Details</h4>
                                                <p><strong>Full URL:</strong> {{ $log->url }}</p>
                                                <p><strong>IP:</strong> {{ $log->ip_address }}</p>
                                                <p><strong>User Agent:</strong> {{ $log->user_agent }}</p>

                                                @if($log->request_body)
                                                    <div class="mt-2">
                                                        <strong>Payload:</strong>
                                                        <pre
                                                            class="bg-gray-100 p-2 rounded text-xs overflow-auto max-h-40">{{ json_encode($log->request_body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold mb-2">Response Details</h4>
                                                @if($log->response_body)
                                                    <div class="mt-2">
                                                        <strong>Body:</strong>
                                                        <pre
                                                            class="bg-gray-100 p-2 rounded text-xs overflow-auto max-h-40">{{ json_encode($log->response_body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                    </div>
                                                @else
                                                    <p class="text-gray-500 italic">No response body captured.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    No requests logged yet. Waiting for traffic...
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
