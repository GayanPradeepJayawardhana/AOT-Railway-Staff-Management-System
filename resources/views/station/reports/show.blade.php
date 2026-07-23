<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $monthlyReport->report_identifier }} — {{ $monthlyReport->month_full }} {{ $monthlyReport->year }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if ($remainingDesignations->isNotEmpty())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold mb-4">Add Designation Record</h3>
                <form method="POST" action="{{ route('station.designations.store', $monthlyReport) }}" class="space-y-4">
                    @csrf
                    @include('station.reports._designation-form-fields', ['designations' => $remainingDesignations])
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Submit
                    </button>
                </form>
            </div>
        @else
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3">
                All designations have been submitted for this period.
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
            <h3 class="font-semibold mb-4">Submitted Records</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2 pr-2">Designation</th>
                        <th class="pr-2">Cadre</th>
                        <th class="pr-2">On Duty</th>
                        <th class="pr-2">Vacancies</th>
                        <th class="pr-2">Relief In/Out</th>
                        <th class="pr-2">Temp In/Out</th>
                        <th class="pr-2">Excess</th>
                        <th class="pr-2">Foreign Leave</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($monthlyReport->reportDetails as $detail)
                        <tr class="border-b last:border-0">
                            <td class="py-2 pr-2">{{ $detail->designation->designation_name }}</td>
                            <td class="pr-2">{{ $detail->approved_cadre }}</td>
                            <td class="pr-2">{{ $detail->staff_on_duty }}</td>
                            <td class="pr-2">{{ $detail->vacancies }}</td>
                            <td class="pr-2">{{ $detail->relief_inward }}/{{ $detail->relief_outward }}</td>
                            <td class="pr-2">{{ $detail->temp_transfer_inward }}/{{ $detail->temp_transfer_outward }}</td>
                            <td class="pr-2">{{ $detail->excess }}</td>
                            <td class="pr-2">{{ $detail->foreign_leave_overseas }}</td>
                            <td><a href="{{ route('station.designations.show', [$monthlyReport, $detail]) }}" class="text-indigo-600 hover:underline">View</a></td>
                            <td><a href="{{ route('station.designations.edit', [$monthlyReport, $detail]) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="py-4 text-gray-500">No designation records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>