<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Search Results for "{{ $term }}"</h2></x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if ($searchedUser ?? false)
            <div class="bg-white rounded-lg shadow p-6 mb-4 text-sm">
                <p><strong>Name:</strong> {{ $searchedUser->full_name }}</p>
                <p><strong>Station:</strong> {{ $searchedUser->station->station_name ?? '—' }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Report ID</th><th>Designations</th><th></th></tr></thead>
                <tbody>
                    @forelse ($results as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->report_identifier }}</td>
                            <td>{{ $report->report_details_count ?? $report->reportDetails->count() }}</td>
                            <td><a href="{{ route('admin.records.show', $report) }}" class="text-indigo-600 hover:underline">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-gray-500">No results found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>