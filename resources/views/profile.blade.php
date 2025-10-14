<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg text-gray-800">Security Settings</h3>

                    <div class="mt-6">
                        <h4 class="font-semibold text-md text-gray-800">Two-Factor Authentication</h4>
                        <div class="mt-4">
                            @if(auth()->user()->twoFactorAuth && auth()->user()->twoFactorAuth->is_enabled)
                                <p class="text-green-500">2FA is enabled.</p>
                                <a href="{{ route('2fa.disable') }}" class="text-red-500">Disable 2FA</a>
                            @else
                                <p class="text-red-500">2FA is disabled.</p>
                                <a href="{{ route('2fa.setup') }}" class="text-green-500">Enable 2FA</a>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-md text-gray-800">Transaction PIN</h4>
                        <div class="mt-4">
                            <p>You have not set a transaction PIN.</p>
                            <a href="#" class="text-green-500">Set PIN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
