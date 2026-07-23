<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Station Dashboard — {{ $station->station_name }} ({{ $station->station_code }})</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if ($pending)
            <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-md px-4 py-3">
                Monthly Report Pending — {{ $currentMonth }} {{ $currentYear }} has not been submitted yet.
            </div>
        @else
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3">
                {{ $currentMonth }} {{ $currentYear }} report submitted ({{ $currentReport->reportDetails()->count() }} designations recorded).
            </div>
        @endif

        <div class="grid sm:grid-cols-2 gap-6">
            <a href="{{ route('station.reports.create') }}" class="block bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                <h3 class="text-lg font-semibold mb-1">Add Details</h3>
                <p class="text-gray-600 text-sm">Submit monthly staff information for a Year/Month.</p>
            </a>
            <a href="{{ route('station.reports.index') }}" class="block bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                <h3 class="text-lg font-semibold mb-1">Show Added Records</h3>
                <p class="text-gray-600 text-sm">View and edit previously submitted records.</p>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Recent Submissions</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Period</th>
                        <th>Designations Submitted</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentReports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->month_full }} {{ $report->year }}</td>
                            <td>{{ $report->report_details_count }}</td>
                            <td><a href="{{ route('station.reports.show', $report) }}" class="text-indigo-600 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-gray-500">No submissions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>