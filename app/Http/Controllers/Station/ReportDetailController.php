<?php

namespace App\Http\Controllers\Station;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReport;
use App\Models\ReportDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReportDetailController extends Controller
{
    protected function rules(): array
    {
        return [
            'designation_id' => 'required|exists:designations,id',
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

    public function store(Request $request, MonthlyReport $monthlyReport): RedirectResponse
    {
        $this->authorizeStationOwnership($monthlyReport);

        $data = $request->validate($this->rules() + [
            'designation_id' => [
                'required',
                'exists:designations,id',
                Rule::unique('report_details', 'designation_id')->where('monthly_report_id', $monthlyReport->id),
            ],
        ]);

        // Create the report detail
        $reportDetail = $monthlyReport->reportDetails()->create($data);

        // Update the report status if it was draft
        if ($monthlyReport->submission_status === 'draft') {
            $monthlyReport->update(['submission_status' => 'submitted']);
        }

        return redirect()->route('station.reports.show', $monthlyReport)
            ->with('status', 'Designation record for "' . $reportDetail->designation->designation_name . '" added successfully.');
    }

    public function show(MonthlyReport $monthlyReport, ReportDetail $reportDetail): View
    {
        $this->authorizeStationOwnership($monthlyReport);
        $this->authorizeBelongsToReport($monthlyReport, $reportDetail);

        $reportDetail->load('designation');

        return view('station.designations.show', compact('monthlyReport', 'reportDetail'));
    }

    public function edit(MonthlyReport $monthlyReport, ReportDetail $reportDetail): View
    {
        $this->authorizeStationOwnership($monthlyReport);
        $this->authorizeBelongsToReport($monthlyReport, $reportDetail);

        return view('station.designations.edit', compact('monthlyReport', 'reportDetail'));
    }

    public function update(Request $request, MonthlyReport $monthlyReport, ReportDetail $reportDetail): RedirectResponse
    {
        $this->authorizeStationOwnership($monthlyReport);
        $this->authorizeBelongsToReport($monthlyReport, $reportDetail);

        $data = $request->validate($this->rules());
        unset($data['designation_id']); // Designation cannot be changed on edit

        $reportDetail->update($data);

        return redirect()->route('station.reports.show', $monthlyReport)
            ->with('status', 'Designation record updated successfully.');
    }

    protected function authorizeStationOwnership(MonthlyReport $monthlyReport): void
    {
        if ($monthlyReport->station_id !== Auth::user()->station_id) {
            abort(403);
        }
    }

    protected function authorizeBelongsToReport(MonthlyReport $monthlyReport, ReportDetail $reportDetail): void
    {
        if ($reportDetail->monthly_report_id !== $monthlyReport->id) {
            abort(404);
        }
    }
}