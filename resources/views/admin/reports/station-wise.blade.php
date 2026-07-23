<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Station-wise Report</h2></x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="flex gap-2 mb-4">
                <select name="station_id" class="rounded-md border-gray-300 w-72">
                    <option value="">-- Select Station --</option>
                    @foreach ($stations as $station)
                        <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>{{ $station->station_code }} — {{ $station->station_name }}</option>
                    @endforeach
                </select>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">View</button>
            </form>

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Report ID</th><th>Submitted By</th><th>Designations</th></tr></thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->report_identifier }}</td>
                            <td>{{ $report->user->full_name }}</td>
                            <td>{{ $report->reportDetails->count() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-gray-500">Select a station to view its records.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>