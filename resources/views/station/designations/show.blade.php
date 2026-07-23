<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $reportDetail->designation->designation_name }} — {{ $monthlyReport->report_identifier }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6 space-y-2 text-sm">
            <p><strong>Approved Cadre:</strong> {{ $reportDetail->approved_cadre }}</p>
            <p><strong>Staff on Duty:</strong> {{ $reportDetail->staff_on_duty }}</p>
            <p><strong>Vacancies:</strong> {{ $reportDetail->vacancies }}</p>
            <p><strong>Relief Inward/Outward:</strong> {{ $reportDetail->relief_inward }} / {{ $reportDetail->relief_outward }} ({{ $reportDetail->relief_work_station }})</p>
            <p><strong>Temp Transfer Inward/Outward:</strong> {{ $reportDetail->temp_transfer_inward }} / {{ $reportDetail->temp_transfer_outward }} ({{ $reportDetail->temp_transfer_work_station }})</p>
            <p><strong>Excess:</strong> {{ $reportDetail->excess }}</p>
            <p><strong>Foreign Leave/Overseas:</strong> {{ $reportDetail->foreign_leave_overseas }}</p>
            <p><strong>Retirements/Resignations:</strong> {{ $reportDetail->retirements_details ?: '—' }}</p>
            <a href="{{ route('station.reports.show', $monthlyReport) }}" class="text-indigo-600 hover:underline">Back</a>
        </div>
    </div>
</x-app-layout>