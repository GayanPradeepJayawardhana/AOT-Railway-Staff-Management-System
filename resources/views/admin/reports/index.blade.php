<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Reports</h2></x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8 grid sm:grid-cols-2 gap-4">
        <a href="{{ route('admin.reports.monthly') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md">Monthly Report</a>
        <a href="{{ route('admin.reports.quarterly') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md">Quarterly Report</a>
        <a href="{{ route('admin.reports.station-wise') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md">Station-wise Report</a>
        <a href="{{ route('admin.reports.user-wise') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md">User-wise Report</a>
        <a href="{{ route('admin.reports.missing-submissions') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md">Missing Submissions</a>
    </div>
</x-app-layout>