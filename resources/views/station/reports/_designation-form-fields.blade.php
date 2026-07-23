@if (isset($designations))
    <div>
        <label class="block text-sm font-medium text-gray-700">Designation / Post</label>
        <select name="designation_id" class="mt-1 block w-full rounded-md border-gray-300" required>
            <option value="">-- Select --</option>
            @foreach ($designations as $designation)
                <option value="{{ $designation->id }}">{{ $designation->designation_name }}</option>
            @endforeach
        </select>
        @error('designation_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
@endif

<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Approved Cadre</label>
        <input type="number" name="approved_cadre" value="{{ old('approved_cadre', $reportDetail->approved_cadre ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Staff on Duty</label>
        <input type="number" name="staff_on_duty" value="{{ old('staff_on_duty', $reportDetail->staff_on_duty ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Vacancies</label>
        <input type="number" name="vacancies" value="{{ old('vacancies', $reportDetail->vacancies ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
    </div>
</div>

<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Relief Inward</label>
        <input type="number" name="relief_inward" value="{{ old('relief_inward', $reportDetail->relief_inward ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Relief Outward</label>
        <input type="number" name="relief_outward" value="{{ old('relief_outward', $reportDetail->relief_outward ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Relief Work Station</label>
        <input type="text" name="relief_work_station" value="{{ old('relief_work_station', $reportDetail->relief_work_station ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
</div>

<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Temp Transfer Inward</label>
        <input type="number" name="temp_transfer_inward" value="{{ old('temp_transfer_inward', $reportDetail->temp_transfer_inward ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Temp Transfer Outward</label>
        <input type="number" name="temp_transfer_outward" value="{{ old('temp_transfer_outward', $reportDetail->temp_transfer_outward ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Temp Transfer Work Station</label>
        <input type="text" name="temp_transfer_work_station" value="{{ old('temp_transfer_work_station', $reportDetail->temp_transfer_work_station ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Excess</label>
        <input type="number" name="excess" value="{{ old('excess', $reportDetail->excess ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Foreign Leave / Overseas</label>
        <input type="number" name="foreign_leave_overseas" value="{{ old('foreign_leave_overseas', $reportDetail->foreign_leave_overseas ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Retirements / Deceased / Resignations / Suspensions</label>
    <textarea name="retirements_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Name, reason, date">{{ old('retirements_details', $reportDetail->retirements_details ?? '') }}</textarea>
</div>