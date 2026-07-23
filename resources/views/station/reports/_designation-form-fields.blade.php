@if (isset($designations) && $designations->isNotEmpty())
    <div>
        <label class="block text-sm font-medium text-gray-700">Designation / Post <span class="text-red-600">*</span></label>
        <select name="designation_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            <option value="">-- Select Designation --</option>
            @foreach ($designations as $designation)
                <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                    {{ $designation->designation_name }} ({{ $designation->designation_code }})
                </option>
            @endforeach
        </select>
        @error('designation_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
@elseif (isset($designations))
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md px-4 py-3">
        <strong>All designations have been submitted!</strong>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Approved Cadre <span class="text-red-600">*</span></label>
        <input type="number" name="approved_cadre" value="{{ old('approved_cadre', $reportDetail->approved_cadre ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0">
        @error('approved_cadre') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Staff on Duty <span class="text-red-600">*</span></label>
        <input type="number" name="staff_on_duty" value="{{ old('staff_on_duty', $reportDetail->staff_on_duty ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0">
        @error('staff_on_duty') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Vacancies <span class="text-red-600">*</span></label>
        <input type="number" name="vacancies" value="{{ old('vacancies', $reportDetail->vacancies ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="0">
        @error('vacancies') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Relief Inward</label>
        <input type="number" name="relief_inward" value="{{ old('relief_inward', $reportDetail->relief_inward ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="0">
        @error('relief_inward') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Relief Outward</label>
        <input type="number" name="relief_outward" value="{{ old('relief_outward', $reportDetail->relief_outward ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="0">
        @error('relief_outward') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Relief Work Station</label>
        <input type="text" name="relief_work_station" value="{{ old('relief_work_station', $reportDetail->relief_work_station ?? '') }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g., Kandy, Colombo">
        @error('relief_work_station') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Temp Transfer Inward</label>
        <input type="number" name="temp_transfer_inward" value="{{ old('temp_transfer_inward', $reportDetail->temp_transfer_inward ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="0">
        @error('temp_transfer_inward') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Temp Transfer Outward</label>
        <input type="number" name="temp_transfer_outward" value="{{ old('temp_transfer_outward', $reportDetail->temp_transfer_outward ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="0">
        @error('temp_transfer_outward') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Temp Transfer Work Station</label>
        <input type="text" name="temp_transfer_work_station" value="{{ old('temp_transfer_work_station', $reportDetail->temp_transfer_work_station ?? '') }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g., Kandy, Colombo">
        @error('temp_transfer_work_station') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Excess</label>
        <input type="number" name="excess" value="{{ old('excess', $reportDetail->excess ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="0">
        @error('excess') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Foreign Leave / Overseas</label>
        <input type="number" name="foreign_leave_overseas" value="{{ old('foreign_leave_overseas', $reportDetail->foreign_leave_overseas ?? 0) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="0">
        @error('foreign_leave_overseas') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Retirements / Deceased / Resignations / Suspensions</label>
    <textarea name="retirements_details" rows="3" 
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
              placeholder="Enter details in format: Name, Reason, Date (e.g., John Doe, Retired, 2025-01-15)">{{ old('retirements_details', $reportDetail->retirements_details ?? '') }}</textarea>
    @error('retirements_details') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

@if (!isset($designations))
    {{-- This is for edit mode - we don't show designation selection --}}
@endif