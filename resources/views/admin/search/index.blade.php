<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Search</h2></x-slot>

    <div class="py-8 max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.search.search') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Search By</label>
                    <select name="type" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="station_code">Station Code (e.g. BRL)</option>
                        <option value="nic">User NIC</option>
                        <option value="format">Submission Format (e.g. 2026-JAN-BRL)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Query</label>
                    <input type="text" name="query" class="mt-1 block w-full rounded-md border-gray-300" required>
                    @error('query') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Search</button>
            </form>
        </div>
    </div>
</x-app-layout>