<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enable Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Scan the QR code below with your authenticator app, then enter the code to verify.</p>

                    <div class="mt-4">
                        {!! $qr_code_url !!}
                    </div>

                    <form method="POST" action="{{ route('2fa.verify') }}">
                        @csrf
                        <input type="hidden" name="secret" value="{{ $secret }}">

                        <div class="mt-4">
                            <x-label for="code" :value="__('Code')" />
                            <x-input id="code" class="block mt-1 w-full" type="text" name="code" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Verify') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
