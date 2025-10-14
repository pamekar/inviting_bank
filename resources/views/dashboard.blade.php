<x-app-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Header -->
            <div class="mb-8 flex justify-between items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="text-right">
                    <h1 class="text-2xl font-bold text-gray-800">Hello, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-500">Welcome back to your dashboard.</p>
                </div>
            </div>

            <!-- Main Balance Card -->
            <div class="bg-gradient-to-br from-purple-600 to-indigo-600 text-white p-6 rounded-2xl shadow-lg mb-8">
                <p class="text-sm opacity-75">Total Balance</p>
                <p class="text-4xl font-bold mt-2">₦{{ number_format(auth()->user()->accounts()->sum('balance'), 2) }}</p>
                <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="opacity-75">Income</p>
                        <p class="font-semibold">₦{{ number_format(auth()->user()->accounts()->first()?->transactions()->where('type', 'deposit')->sum('amount'), 2) }}</p>
                    </div>
                    <div>
                        <p class="opacity-75">Expenses</p>
                        <p class="font-semibold">₦{{ number_format(auth()->user()->accounts()->first()?->transactions()->where('type', '!=', 'deposit')->sum('amount'), 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-4 gap-4 text-center mb-8">
                <a href="{{ route('transfers') }}" class="bg-white p-4 rounded-2xl shadow hover:shadow-lg transition-shadow">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full w-12 h-12 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5l-3 3m0 0l-3-3m3 3V8"></path></svg>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-gray-700">Send</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-2xl shadow hover:shadow-lg transition-shadow">
                    <div class="bg-green-100 text-green-600 rounded-full w-12 h-12 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-gray-700">Deposit</p>
                </a>
                <a href="{{ route('bill-payments') }}" class="bg-white p-4 rounded-2xl shadow hover:shadow-lg transition-shadow">
                    <div class="bg-yellow-100 text-yellow-600 rounded-full w-12 h-12 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-gray-700">Bills</p>
                </a>
                <a href="{{ route('statistics') }}" class="bg-white p-4 rounded-2xl shadow hover:shadow-lg transition-shadow">
                    <div class="bg-blue-100 text-blue-600 rounded-full w-12 h-12 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-gray-700">More</p>
                </a>
            </div>

            <!-- Recent Transactions -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Recent Transactions</h2>
                    <a href="{{ route('transactions') }}" class="text-sm font-semibold text-indigo-600">View All</a>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow">
                    <ul class="divide-y divide-gray-200">
                        @forelse(auth()->user()->accounts()->first()?->transactions()->latest()->take(5)->get()??[] as $transaction)
                            <li class="py-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-100 mr-4">
                                        <!-- Placeholder Icon -->
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-lg @if($transaction->type === 'deposit') text-green-500 @else text-red-500 @endif">
                                    {{ $transaction->type === 'deposit' ? '+' : '-' }}₦{{ number_format($transaction->amount, 2) }}
                                </p>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-500">No transactions yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
