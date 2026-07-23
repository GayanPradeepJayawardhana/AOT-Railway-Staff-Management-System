<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">User-wise Report</h2></x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="flex gap-2 mb-4">
                <input type="text" name="nic_number" value="{{ request('nic_number') }}" placeholder="NIC Number" class="rounded-md border-gray-300 w-64">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">View</button>
            </form>

            @if ($user ?? false)
                <p class="mb-4 text-sm"><strong>{{ $user->full_name }}</strong> — {{ $user->station->station_name ?? '—' }}</p>
            @endif

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Report ID</th><th>Designations</th></tr></thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $report->report_identifier }}</td>
                            <td>{{ $report->reportDetails->count() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="py-4 text-gray-500">Enter an NIC number to view records.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>