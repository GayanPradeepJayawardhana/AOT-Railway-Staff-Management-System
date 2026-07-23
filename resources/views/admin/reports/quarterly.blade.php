<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Quarterly Report — Q{{ $quarter }} {{ $year }}</h2></x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="flex gap-2 mb-4">
                <input type="number" name="year" value="{{ $year }}" class="rounded-md border-gray-300 w-28">
                <select name="quarter" class="rounded-md border-gray-300">
                    @for ($q = 1; $q <= 4; $q++)
                        <option value="{{ $q }}" {{ $quarter == $q ? 'selected' : '' }}>Q{{ $q }}</option>
                    @endfor
                </select>
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Filter</button>
            </form>

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Station</th><th>Cadre</th><th>On Duty</th><th>Vacancies</th><th>Excess</th><th>Foreign Leave</th></tr></thead>
                <tbody>
                    @forelse ($summaries as $s)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $s->station->station_name }}</td>
                            <td>{{ $s->total_approved_cadre }}</td>
                            <td>{{ $s->total_staff_on_duty }}</td>
                            <td>{{ $s->total_vacancies }}</td>
                            <td>{{ $s->total_excess }}</td>
                            <td>{{ $s->total_foreign_leave }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-4 text-gray-500">No data for this quarter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>