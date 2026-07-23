<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">{{ $monthlyReport->report_identifier }} — {{ $monthlyReport->station->station_name }}</h2></x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2 pr-2">Designation</th><th class="pr-2">Cadre</th><th class="pr-2">On Duty</th>
                        <th class="pr-2">Vacancies</th><th class="pr-2">Excess</th><th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyReport->reportDetails as $detail)
                        <tr class="border-b last:border-0">
                            <td class="py-2 pr-2">{{ $detail->designation->designation_name }}</td>
                            <td class="pr-2">{{ $detail->approved_cadre }}</td>
                            <td class="pr-2">{{ $detail->staff_on_duty }}</td>
                            <td class="pr-2">{{ $detail->vacancies }}</td>
                            <td class="pr-2">{{ $detail->excess }}</td>
                            <td><a href="{{ route('admin.records.edit', [$monthlyReport, $detail]) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                            <td>
                                <form method="POST" action="{{ route('admin.records.destroy', [$monthlyReport, $detail]) }}" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>