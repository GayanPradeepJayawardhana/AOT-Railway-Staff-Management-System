<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Monthly Report</h2></x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="flex gap-2 mb-4">
                <input type="number" name="year" value="{{ $year }}" class="rounded-md border-gray-300 w-28">
                <input type="text" name="month" value="{{ $month }}" class="rounded-md border-gray-300 w-32">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Filter</button>
            </form>

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Station</th><th>Submitted By</th><th>Designations</th><th></th></tr></thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->station->station_name }}</td>
                            <td>{{ $report->user->full_name }}</td>
                            <td>{{ $report->reportDetails->count() }}</td>
                            <td><a href="{{ route('admin.records.show', $report) }}" class="text-indigo-600 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-4 text-gray-500">No submissions for this period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>