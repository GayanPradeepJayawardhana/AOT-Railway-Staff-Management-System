<x-guest-layout>
    <!-- Full-Screen Background Container -->
    <!-- REPLACE 'your-image-url.jpg' with your actual background image asset e.g. {{ asset('images/bg.jpg') }} -->
    <div class="relative min-h-screen flex flex-col justify-between items-center bg-cover bg-center bg-no-repeat" style="background-image: url('your-image-url.jpg');">
        
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-xs"></div>

        <!-- Header / Logo -->
        <header class="relative z-10 pt-8">
            <a href="/" class="flex items-center gap-3 bg-[#ebae34] px-6 py-2.5 rounded-full shadow-xl">
                <div class="p-1.5 bg-black rounded-full">
                    <svg class="w-5 h-5 text-[#ebae34]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xl font-black tracking-wider text-black uppercase">StaffMS</span>
            </a>
        </header>

        <!-- Main Form Content -->
        <main class="relative z-10 w-full max-w-md px-6 py-12">
            <!-- Bright Glassmorphism Card -->
            <div class="bg-white/85 backdrop-blur-md border border-white/60 rounded-3xl p-8 shadow-2xl text-left">
                
                <!-- Title -->
                <h2 class="text-2xl font-black text-black text-center mb-6">
                    Account Login
                </h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- NIC Number -->
                    <div>
                        <label class="block font-bold text-sm text-black mb-1">
                            NIC Number
                        </label>

                        <input
                            class="block w-full px-4 py-2.5 rounded-full border border-gray-300 text-black font-semibold placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ebae34] focus:border-transparent transition"
                            type="text"
                            name="nic_number"
                            value="{{ old('nic_number') }}"
                            placeholder="Enter your NIC"
                            required
                            autofocus>

                        @error('nic_number')
                            <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label class="block font-bold text-sm text-black mb-1">
                            Password
                        </label>

                        <input
                            class="block w-full px-4 py-2.5 rounded-full border border-gray-300 text-black font-semibold placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ebae34] focus:border-transparent transition"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-4 text-xs font-bold text-black">
                        <label class="inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-[#ebae34] focus:ring-[#ebae34]">
                            <span class="ms-2">Remember Me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a 
                                class="underline hover:text-gray-700 transition"
                                href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-center">
                        <button 
                            type="submit"
                            style="background-color: #ebae34;"
                            class="px-8 py-2.5 rounded-full font-bold text-sm text-black hover:brightness-105 shadow-md shadow-[#ebae34]/30 transition duration-200 active:scale-[0.98] text-center min-w-[120px]">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 pb-6 text-center">
            <p class="text-xs font-bold text-black drop-shadow-sm">
                &copy; {{ date('Y') }} Staff Management System. All rights reserved.
            </p>
        </footer>

    </div>
</x-guest-layout>