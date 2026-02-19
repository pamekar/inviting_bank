<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" wire:poll.5s>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Incoming HTTP Requests') }}
            </h2>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Live Updates Active
            </span>
        </div>
    </x-slot>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Path</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Details</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 transition ease-in-out duration-150 cursor-pointer" wire:click="toggleExpand({{ $log->id }})">
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
                                        <td colspan="6" class="px-6 py-4 bg-gray-50 text-sm text-gray-700 border-t border-gray-200">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <h4 class="font-bold mb-2">Request Details</h4>
                                                    <p><strong>Full URL:</strong> {{ $log->url }}</p>
                                                    <p><strong>IP:</strong> {{ $log->ip_address }}</p>
                                                    <p><strong>User Agent:</strong> {{ $log->user_agent }}</p>
                                                    
                                                    @if($log->request_body)
                                                        <div class="mt-2">
                                                            <strong>Payload:</strong>
                                                            <pre class="bg-gray-100 p-2 rounded text-xs overflow-auto max-h-40">{{ json_encode($log->request_body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-bold mb-2">Response Details</h4>
                                                    @if($log->response_body)
                                                        <div class="mt-2">
                                                            <strong>Body:</strong>
                                                            <pre class="bg-gray-100 p-2 rounded text-xs overflow-auto max-h-40">{{ json_encode($log->response_body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
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