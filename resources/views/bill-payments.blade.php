<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pay a Bill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="#">
                        @csrf
                        <!-- Biller -->
                        <div>
                            <x-input-label for="biller" :value="__('Select Biller')" />
                            <select id="biller" name="biller" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option>NEPA</option>
                                <option>LagosWater</option>
                                <option>MTN</option>
                                <option>Airtel</option>
                            </select>
                        </div>

                        <!-- Customer Reference -->
                        <div class="mt-4">
                            <x-input-label for="customer_reference" :value="__('Customer Reference')" />
                            <x-text-input id="customer_reference" class="block mt-1 w-full" type="text" name="customer_reference" required />
                        </div>

                        <!-- Amount -->
                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="bg-brand-purple">
                                {{ __('Pay Bill') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>