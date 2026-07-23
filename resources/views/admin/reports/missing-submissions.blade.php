<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Missing Submissions</h2></x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="flex gap-2 mb-4">
                <input type="number" name="year" value="{{ $year }}" class="rounded-md border-gray-300 w-28">
                <input type="text" name="month" value="{{ $month }}" class="rounded-md border-gray-300 w-32">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Filter</button>
            </form>

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Station Code</th><th>Station Name</th><th>Assigned User</th><th>WhatsApp</th></tr></thead>
                <tbody>
                    @forelse ($missingStations as $station)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $station->station_code }}</td>
                            <td>{{ $station->station_name }}</td>
                            <td>{{ $station->user->full_name ?? '— no user registered —' }}</td>
                            <td>{{ $station->user->whatsapp_mobile ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-4 text-gray-500">All stations have submitted for this period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>