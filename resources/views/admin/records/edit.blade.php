<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit {{ $reportDetail->designation->designation_name }}</h2></x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.records.update', [$monthlyReport, $reportDetail]) }}" class="space-y-4">
                @csrf @method('PUT')
                @include('station.reports._designation-form-fields')
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Update</button>
                <a href="{{ route('admin.records.show', $monthlyReport) }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
            </form>
        </div>
    </div>
</x-app-layout>