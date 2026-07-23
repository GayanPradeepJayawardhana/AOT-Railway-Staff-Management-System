<?php

namespace App\Http\Controllers\Station;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\MonthlyReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    protected array $months = [
        'JAN' => 'January', 'FEB' => 'February', 'MAR' => 'March', 'APR' => 'April',
        'MAY' => 'May', 'JUN' => 'June', 'JUL' => 'July', 'AUG' => 'August',
        'SEP' => 'September', 'OCT' => 'October', 'NOV' => 'November', 'DEC' => 'December',
    ];

    public function index(): View
    {
        $station = Auth::user()->station;

        $reports = MonthlyReport::where('station_id', $station->id)
            ->withCount('reportDetails')
            ->orderByDesc('year')
            ->orderByRaw("FIELD(month,'JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC') DESC")
            ->paginate(15);

        return view('station.reports.index', compact('reports'));
    }

    public function create(): View
    {
        $years = range(now()->year - 1, now()->year + 2);

        return view('station.reports.create', [
            'years' => $years,
            'months' => $this->months,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'year' => 'required|integer|min:2020|max:2100',
            'month' => 'required|string|in:' . implode(',', array_keys($this->months)),
        ]);

        $station = Auth::user()->station;

        $report = MonthlyReport::firstOrCreate(
            [
                'station_id' => $station->id,
                'year' => $data['year'],
                'month' => strtoupper($data['month']),
            ],
            [
                'user_id' => Auth::id(),
                'submission_status' => 'submitted',
            ]
        );

        $report->refresh();

        return redirect()->route('station.reports.show', $report)
            ->with('status', 'You can now add designation records for ' . $report->month_full . ' ' . $report->year . '.');
    }

    public function show(MonthlyReport $monthlyReport): View
    {
        $this->authorizeStationOwnership($monthlyReport);

        $monthlyReport->load(['reportDetails.designation']);

        $submittedIds = $monthlyReport->reportDetails->pluck('designation_id');

        $remainingDesignations = Designation::active()
            ->whereNotIn('id', $submittedIds)
            ->orderBy('sort_order')
            ->get();

        return view('station.reports.show', compact('monthlyReport', 'remainingDesignations'));
    }

    protected function authorizeStationOwnership(MonthlyReport $monthlyReport): void
    {
        if ($monthlyReport->station_id !== Auth::user()->station_id) {
            abort(403);
        }
    }
}