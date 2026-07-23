<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $monthlyReport->report_identifier }} — {{ $monthlyReport->month_full }} {{ $monthlyReport->year }}
            </h2>
            <span class="text-sm bg-gray-100 px-3 py-1 rounded-full">
                Status: {{ ucfirst($monthlyReport->submission_status ?? 'Draft') }}
            </span>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Success/Status Message --}}
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        {{-- Add Designation Form --}}
        @if ($remainingDesignations->isNotEmpty())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold mb-2 text-lg">Add Designation Record</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Select a designation from the dropdown below and fill in the staff details for this period.
                    <br><span class="text-yellow-600">Remaining: {{ $remainingDesignations->count() }} designation(s) to submit.</span>
                </p>
                
                <form method="POST" action="{{ route('station.designations.store', $monthlyReport) }}" class="space-y-4">
                    @csrf
                    @include('station.reports._designation-form-fields', ['designations' => $remainingDesignations])
                    
                    <div class="flex items-center justify-end pt-4">
                        <a href="{{ route('station.reports.index') }}" class="text-gray-600 hover:underline mr-4">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-black px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                            Submit Designation Record
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3">
                <strong>✅ All designations have been submitted for this period!</strong>
                <p class="mt-1">You can go back to the <a href="{{ route('station.reports.index') }}" class="underline font-medium">records list</a> or create a <a href="{{ route('station.reports.create') }}" class="underline font-medium">new report</a>.</p>
            </div>
        @endif

        {{-- Submitted Records Table --}}
        <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Submitted Records</h3>
                <span class="text-sm text-gray-600">{{ $monthlyReport->reportDetails->count() }} record(s) submitted</span>
            </div>
            
            @if ($monthlyReport->reportDetails->isNotEmpty())
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="py-2 pr-2">#</th>
                            <th class="py-2 pr-2">Designation</th>
                            <th class="pr-2 text-center">Cadre</th>
                            <th class="pr-2 text-center">On Duty</th>
                            <th class="pr-2 text-center">Vacancies</th>
                            <th class="pr-2 text-center">Excess</th>
                            <th class="pr-2 text-center">Foreign Leave</th>
                            <th colspan="2" class="pr-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyReport->reportDetails as $index => $detail)
                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-2 pr-2 text-center">{{ $index + 1 }}</td>
                                <td class="py-2 pr-2 font-medium">{{ $detail->designation->designation_name }}</td>
                                <td class="py-2 pr-2 text-center">{{ $detail->approved_cadre }}</td>
                                <td class="py-2 pr-2 text-center">{{ $detail->staff_on_duty }}</td>
                                <td class="py-2 pr-2 text-center">{{ $detail->vacancies }}</td>
                                <td class="py-2 pr-2 text-center">{{ $detail->excess ?? 0 }}</td>
                                <td class="py-2 pr-2 text-center">{{ $detail->foreign_leave_overseas ?? 0 }}</td>
                                <td class="py-2 pr-2 text-center">
                                    <a href="{{ route('station.designations.show', [$monthlyReport, $detail]) }}" class="text-indigo-600 hover:underline">View</a>
                                </td>
                                <td class="py-2 text-center">
                                    <a href="{{ route('station.designations.edit', [$monthlyReport, $detail]) }}" class="text-indigo-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p class="text-lg">No designation records submitted yet.</p>
                    <p class="text-sm mt-1">Use the form above to add your first designation record.</p>
                </div>
            @endif
        </div>

        {{-- Navigation Links --}}
        <div class="flex flex-wrap justify-between gap-4">
            <a href="{{ route('station.reports.index') }}" class="text-indigo-600 hover:underline">
                ← Back to Records List
            </a>
            <a href="{{ route('station.reports.create') }}" class="text-indigo-600 hover:underline">
                + Create New Report
            </a>
        </div>
    </div>
</x-app-layout>