<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please enter the 6-digit OTP code that was sent to your email.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.verify-otp') }}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <!-- OTP Code -->
        <div>
            <x-input-label for="otp" :value="__('OTP Code')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <x-primary-button>
                {{ __('Verify OTP') }}
            </x-primary-button>

            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                {{ __('Request new OTP') }}
            </a>
        </div>
    </form>
</x-guest-layout>
