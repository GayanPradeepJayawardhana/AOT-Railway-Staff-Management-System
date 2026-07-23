<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">All Records</h2></x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="flex flex-wrap gap-2 mb-4">
                <select name="station_id" class="rounded-md border-gray-300">
                    <option value="">All Stations</option>
                    @foreach ($stations as $station)
                        <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>{{ $station->station_code }} — {{ $station->station_name }}</option>
                    @endforeach
                </select>
                <input type="number" name="year" value="{{ request('year') }}" placeholder="Year" class="rounded-md border-gray-300 w-28">
                <input type="text" name="month" value="{{ request('month') }}" placeholder="Month (e.g. JAN)" class="rounded-md border-gray-300 w-40">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Filter</button>
            </form>

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Report ID</th><th>Station</th><th>Submitted By</th><th>Designations</th><th colspan="2"></th></tr></thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->report_identifier }}</td>
                            <td>{{ $report->station->station_name }}</td>
                            <td>{{ $report->user->full_name }}</td>
                            <td>{{ $report->report_details_count }}</td>
                            <td><a href="{{ route('admin.records.show', $report) }}" class="text-indigo-600 hover:underline">View</a></td>
                            <td>
                                <form method="POST" action="{{ route('admin.records.destroy-report', $report) }}" onsubmit="return confirm('Delete this entire report?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $reports->links() }}</div>
        </div>
    </div>
</x-app-layout>