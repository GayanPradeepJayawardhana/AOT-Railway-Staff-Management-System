<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Show Added Records</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Report ID</th>
                        <th>Period</th>
                        <th>Designations</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->report_identifier }}</td>
                            <td>{{ $report->month_full }} {{ $report->year }}</td>
                            <td>{{ $report->report_details_count }}</td>
                            <td><a href="{{ route('station.reports.show', $report) }}" class="text-indigo-600 hover:underline">View</a></td>
                            <td><a href="{{ route('station.reports.show', $report) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-4 text-gray-500">No records submitted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $reports->links() }}</div>
        </div>
    </div>
</x-app-layout>