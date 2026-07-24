<x-guest-layout>
    <div class="mb-7 text-center">
        <p class="text-xs font-bold uppercase tracking-[0.18em] text-black">Secure access</p>
        <h1 class="mt-2 text-2xl font-extrabold text-black">Sign in to StaffMS</h1>
        <p class="mt-2 text-sm text-black">Use your staff credentials to continue.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="nic_number" :value="__('NIC Number')" />
            <x-text-input id="nic_number" class="mt-1 block w-full" type="text" name="nic_number" :value="old('nic_number')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nic_number')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between text-sm font-semibold">
            <label for="remember" class="inline-flex items-center">
                <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-black focus:ring-[#ebae34]">
                <span class="ms-2">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="underline underline-offset-4">Forgot password?</a>
            @endif
        </div>
        <x-primary-button class="w-full justify-center">{{ __('Log in') }}</x-primary-button>
    </form>
</x-guest-layout>
