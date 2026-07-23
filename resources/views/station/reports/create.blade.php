<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Monthly Details</h2>
    </x-slot>

    <div class="py-8 max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('station.reports.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Year</label>
                    <select name="year" class="mt-1 block w-full rounded-md border-gray-300" required>
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    @error('year') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Month</label>
                    <select name="month" class="mt-1 block w-full rounded-md border-gray-300" required>
                        @foreach ($months as $code => $label)
                            <option value="{{ $code }}" {{ old('month') === $code ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('month') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Continue
                </button>
            </form>
        </div>
    </div>
</x-app-layout>