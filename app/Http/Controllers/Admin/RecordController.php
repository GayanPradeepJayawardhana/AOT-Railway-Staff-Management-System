<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\ReportDetail;
use App\Models\Station;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecordController extends Controller
{
    public function index(Request $request): View
    {
        $query = MonthlyReport::with(['station', 'user'])->withCount('reportDetails');

        if ($request->filled('station_id')) {
            $query->where('station_id', $request->input('station_id'));
        }
        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }
        if ($request->filled('month')) {
            $query->where('month', strtoupper($request->input('month')));
        }

        $reports = $query->orderByDesc('year')->orderByDesc('created_at')->paginate(20)->withQueryString();
        $stations = Station::orderBy('station_name')->get();

        return view('admin.records.index', compact('reports', 'stations'));
    }

    public function show(MonthlyReport $monthlyReport): View
    {
        $monthlyReport->load(['station', 'user', 'reportDetails.designation']);

        return view('admin.records.show', compact('monthlyReport'));
    }

    protected function rules(): array
    {
        return [
            'approved_cadre' => 'required|integer|min:0',
            'staff_on_duty' => 'required|integer|min:0',
            'vacancies' => 'required|integer|min:0',
            'relief_inward' => 'nullable|integer|min:0',
            'relief_outward' => 'nullable|integer|min:0',
            'relief_work_station' => 'nullable|string|max:255',
            'temp_transfer_inward' => 'nullable|integer|min:0',
            'temp_transfer_outward' => 'nullable|integer|min:0',
            'temp_transfer_work_station' => 'nullable|string|max:255',
            'excess' => 'nullable|integer|min:0',
            'foreign_leave_overseas' => 'nullable|integer|min:0',
            'retirements_details' => 'nullable|string',
        ];
    }

    public function edit(MonthlyReport $monthlyReport, ReportDetail $reportDetail): View
    {
        $reportDetail->load('designation');

        return view('admin.records.edit', compact('monthlyReport', 'reportDetail'));
    }

    public function update(Request $request, MonthlyReport $monthlyReport, ReportDetail $reportDetail): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $reportDetail->update($data);

        return redirect()->route('admin.records.show', $monthlyReport)->with('status', 'Record updated successfully.');
    }

    public function destroy(MonthlyReport $monthlyReport, ReportDetail $reportDetail): RedirectResponse
    {
        $reportDetail->delete();

        return redirect()->route('admin.records.show', $monthlyReport)->with('status', 'Record deleted successfully.');
    }

    public function destroyReport(MonthlyReport $monthlyReport): RedirectResponse
    {
        $monthlyReport->delete();

        return redirect()->route('admin.records.index')->with('status', 'Monthly report deleted successfully.');
    }
}