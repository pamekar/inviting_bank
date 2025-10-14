<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @foreach(auth()->user()->accounts as $account)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-lg text-gray-800">{{ $account->account_number }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($account->type) }} Account</p>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">₦{{ number_format($account->balance, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>