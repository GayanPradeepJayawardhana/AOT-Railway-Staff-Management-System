<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\Station;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $currentYear = now()->year;
        $currentMonth = strtoupper(now()->format('M'));

        $totalStations = Station::where('status', 'active')->count();
        $totalUsers = User::whereHas('role', fn ($q) => $q->where('role_slug', 'station_user'))->count();

        $submittedThisMonth = MonthlyReport::where('year', $currentYear)
            ->where('month', $currentMonth)
            ->distinct('station_id')
            ->count('station_id');

        $pendingThisMonth = $totalStations - $submittedThisMonth;

        $recentReports = MonthlyReport::with(['station', 'user'])
            ->withCount('reportDetails')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalStations', 'totalUsers', 'submittedThisMonth', 'pendingThisMonth',
            'currentYear', 'currentMonth', 'recentReports'
        ));
    }
}