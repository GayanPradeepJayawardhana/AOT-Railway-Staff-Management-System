<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(): View
    {
        return view('admin.search.index');
    }

    public function search(Request $request): View|RedirectResponse
    {
        $data = $request->validate([
            'type' => 'required|in:station_code,nic,format',
            'query' => 'required|string',
        ]);

        $results = collect();
        $searchedUser = null;
        $searchType = $data['type'];
        $term = trim($data['query']);

        if ($searchType === 'station_code') {
            $station = Station::where('station_code', strtoupper($term))->first();
            if ($station) {
                $results = MonthlyReport::with(['user'])
                    ->withCount('reportDetails')
                    ->where('station_id', $station->id)
                    ->orderByDesc('year')
                    ->get();
            }

        } elseif ($searchType === 'nic') {
            $searchedUser = User::with('station')->where('nic_number', $term)->first();
            if ($searchedUser) {
                $results = MonthlyReport::withCount('reportDetails')
                    ->where('user_id', $searchedUser->id)
                    ->orderByDesc('year')
                    ->get();
            }

        } elseif ($searchType === 'format') {
            if (!preg_match('/^(\d{4})-([A-Za-z]{3})-([A-Za-z]+)$/', $term, $m)) {
                return back()->withErrors(['query' => 'Format must look like 2026-JAN-BRL.']);
            }
            [$full, $year, $month, $stationCode] = $m;
            $station = Station::where('station_code', strtoupper($stationCode))->first();

            if ($station) {
                $results = MonthlyReport::with(['user', 'reportDetails.designation'])
                    ->where('station_id', $station->id)
                    ->where('year', $year)
                    ->where('month', strtoupper($month))
                    ->get();
            }
        }

        return view('admin.search.results', [
            'searchType' => $searchType,
            'term' => $term,
            'results' => $results,
            'searchedUser' => $searchedUser,
        ]);
    }
}