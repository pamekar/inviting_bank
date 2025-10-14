<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Make a Transfer') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="#">
                        @csrf
                        <!-- Source Account -->
                        <div>
                            <x-input-label for="source_account" :value="__('From Account')" />
                            <select id="source_account" name="source_account" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach(auth()->user()->accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->account_number }} (₦{{ number_format($account->balance, 2) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Destination Account -->
                        <div class="mt-4">
                            <x-input-label for="destination_account" :value="__('Recipient Account Number')" />
                            <x-text-input id="destination_account" class="block mt-1 w-full" type="text" name="destination_account" required />
                        </div>

                        <!-- Amount -->
                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="bg-brand-purple">
                                {{ __('Continue') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
