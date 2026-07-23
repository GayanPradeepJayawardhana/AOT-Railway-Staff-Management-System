<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected array $months = [
        'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC',
    ];

    public function index(): View
    {
        return view('admin.reports.index');
    }

    public function monthly(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $month = strtoupper($request->input('month', now()->format('M')));

        $reports = MonthlyReport::with(['station', 'user', 'reportDetails'])
            ->where('year', $year)
            ->where('month', $month)
            ->get();

        return view('admin.reports.monthly', compact('reports', 'year', 'month'));
    }

    public function quarterly(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $quarter = (int) $request->input('quarter', ceil(now()->month / 3));

        $quarterMonths = array_slice($this->months, ($quarter - 1) * 3, 3);

        $summaries = MonthlyReport::query()
            ->select('station_id')
            ->selectRaw('SUM(rd_totals.approved_cadre) as total_approved_cadre')
            ->selectRaw('SUM(rd_totals.staff_on_duty) as total_staff_on_duty')
            ->selectRaw('SUM(rd_totals.vacancies) as total_vacancies')
            ->selectRaw('SUM(rd_totals.relief_inward) as total_relief_inward')
            ->selectRaw('SUM(rd_totals.relief_outward) as total_relief_outward')
            ->selectRaw('SUM(rd_totals.temp_transfer_inward) as total_temp_inward')
            ->selectRaw('SUM(rd_totals.temp_transfer_outward) as total_temp_outward')
            ->selectRaw('SUM(rd_totals.excess) as total_excess')
            ->selectRaw('SUM(rd_totals.foreign_leave_overseas) as total_foreign_leave')
            ->joinSub(
                DB::table('report_details')->select(
                    'monthly_report_id', 'approved_cadre', 'staff_on_duty', 'vacancies',
                    'relief_inward', 'relief_outward', 'temp_transfer_inward',
                    'temp_transfer_outward', 'excess', 'foreign_leave_overseas'
                ),
                'rd_totals',
                'rd_totals.monthly_report_id',
                '=',
                'monthly_reports.id'
            )
            ->where('year', $year)
            ->whereIn('month', $quarterMonths)
            ->groupBy('station_id')
            ->with('station')
            ->get();

        return view('admin.reports.quarterly', compact('summaries', 'year', 'quarter'));
    }

    public function stationWise(Request $request): View
    {
        $stations = Station::orderBy('station_name')->get();
        $reports = collect();

        if ($request->filled('station_id')) {
            $reports = MonthlyReport::with(['user', 'reportDetails'])
                ->where('station_id', $request->input('station_id'))
                ->orderByDesc('year')
                ->get();
        }

        return view('admin.reports.station-wise', compact('stations', 'reports'));
    }

    public function userWise(Request $request): View
    {
        $reports = collect();
        $user = null;

        if ($request->filled('nic_number')) {
            $user = User::with('station')->where('nic_number', $request->input('nic_number'))->first();
            if ($user) {
                $reports = MonthlyReport::with('reportDetails')
                    ->where('user_id', $user->id)
                    ->orderByDesc('year')
                    ->get();
            }
        }

        return view('admin.reports.user-wise', compact('reports', 'user'));
    }

    public function missingSubmissions(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $month = strtoupper($request->input('month', now()->format('M')));

        $submittedStationIds = MonthlyReport::where('year', $year)
            ->where('month', $month)
            ->pluck('station_id');

        $missingStations = Station::where('status', 'active')
            ->whereNotIn('id', $submittedStationIds)
            ->with('user')
            ->orderBy('station_name')
            ->get();

        return view('admin.reports.missing-submissions', compact('missingStations', 'year', 'month'));
    }
}