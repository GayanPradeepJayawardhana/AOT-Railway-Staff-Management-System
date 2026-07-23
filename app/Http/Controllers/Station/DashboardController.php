<?php

namespace App\Http\Controllers\Station;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $station = $user->station;

        $currentYear = now()->year;
        $currentMonth = strtoupper(now()->format('M'));

        $currentReport = MonthlyReport::where('station_id', $station->id)
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->first();

        $recentReports = MonthlyReport::where('station_id', $station->id)
            ->withCount('reportDetails')
            ->orderByDesc('year')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('station.dashboard', [
            'station' => $station,
            'currentReport' => $currentReport,
            'currentYear' => $currentYear,
            'currentMonth' => $currentMonth,
            'recentReports' => $recentReports,
            'pending' => is_null($currentReport),
        ]);
    }
}