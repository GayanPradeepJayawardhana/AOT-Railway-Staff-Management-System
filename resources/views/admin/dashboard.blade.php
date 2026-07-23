<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Admin Dashboard</h2></x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Total Stations</p><p class="text-2xl font-bold">{{ $totalStations }}</p></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Total Users</p><p class="text-2xl font-bold">{{ $totalUsers }}</p></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Submitted ({{ $currentMonth }} {{ $currentYear }})</p><p class="text-2xl font-bold text-green-600">{{ $submittedThisMonth }}</p></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-sm">Pending</p><p class="text-2xl font-bold text-yellow-600">{{ $pendingThisMonth }}</p></div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Recent Submissions</h3>
                <a href="{{ route('admin.reports.missing-submissions') }}" class="text-indigo-600 hover:underline text-sm">View missing submissions</a>
            </div>
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Report ID</th><th>Station</th><th>Submitted By</th><th>Designations</th><th></th></tr></thead>
                <tbody>
                    @foreach ($recentReports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->report_identifier }}</td>
                            <td>{{ $report->station->station_name }}</td>
                            <td>{{ $report->user->full_name }}</td>
                            <td>{{ $report->report_details_count }}</td>
                            <td><a href="{{ route('admin.records.show', $report) }}" class="text-indigo-600 hover:underline">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>