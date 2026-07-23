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

        // Check if report already exists
        $existingReport = MonthlyReport::where('station_id', $station->id)
            ->where('year', $data['year'])
            ->where('month', strtoupper($data['month']))
            ->first();

        if ($existingReport) {
            return redirect()->route('station.reports.show', $existingReport)
                ->with('status', 'Report already exists for this period. You can add more designations.');
        }

        // Create new report
        $report = MonthlyReport::create([
            'station_id' => $station->id,
            'user_id' => Auth::id(),
            'year' => $data['year'],
            'month' => strtoupper($data['month']),
            'submission_status' => 'draft', // Changed from 'submitted' to 'draft'
        ]);

        $report->refresh(); // This will load the report_identifier and month_full from DB trigger

        return redirect()->route('station.reports.show', $report)
            ->with('status', 'Report created for ' . $report->month_full . ' ' . $report->year . '. You can now add designation records.');
    }

    public function show(MonthlyReport $monthlyReport): View
    {
        $this->authorizeStationOwnership($monthlyReport);

        $monthlyReport->load(['reportDetails.designation']);

        // Get all active designations
        $allDesignations = Designation::active()
            ->orderBy('sort_order')
            ->get();

        // Get IDs of already submitted designations for this report
        $submittedIds = $monthlyReport->reportDetails->pluck('designation_id')->toArray();

        // Get remaining designations (not yet submitted)
        $remainingDesignations = $allDesignations->filter(function ($designation) use ($submittedIds) {
            return !in_array($designation->id, $submittedIds);
        });

        return view('station.reports.show', compact('monthlyReport', 'remainingDesignations'));
    }

    protected function authorizeStationOwnership(MonthlyReport $monthlyReport): void
    {
        if ($monthlyReport->station_id !== Auth::user()->station_id) {
            abort(403, 'You are not authorized to access this report.');
        }
    }
}