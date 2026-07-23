<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Station\DashboardController;
use App\Http\Controllers\Station\MonthlyReportController;
use App\Http\Controllers\Station\ReportDetailController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Generic entry point — sends the user to the right dashboard
    Route::get('/dashboard', function () {
        return Auth::user()->isSuperAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('station.dashboard');
    })->name('dashboard');

    // ===================== STATION USER =====================
    Route::middleware(['role:station_user'])
        ->prefix('station')
        ->name('station.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::get('/reports', [MonthlyReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/create', [MonthlyReportController::class, 'create'])->name('reports.create');
            Route::post('/reports', [MonthlyReportController::class, 'store'])->name('reports.store');
            Route::get('/reports/{monthlyReport}', [MonthlyReportController::class, 'show'])->name('reports.show');

            Route::post('/reports/{monthlyReport}/designations', [ReportDetailController::class, 'store'])->name('designations.store');
            Route::get('/reports/{monthlyReport}/designations/{reportDetail}', [ReportDetailController::class, 'show'])->name('designations.show');
            Route::get('/reports/{monthlyReport}/designations/{reportDetail}/edit', [ReportDetailController::class, 'edit'])->name('designations.edit');
            Route::put('/reports/{monthlyReport}/designations/{reportDetail}', [ReportDetailController::class, 'update'])->name('designations.update');
        });

    // ===================== SUPER ADMIN =====================
    Route::middleware(['role:super_admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
            Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.update-password');

            Route::get('/records', [RecordController::class, 'index'])->name('records.index');
            Route::get('/records/{monthlyReport}', [RecordController::class, 'show'])->name('records.show');
            Route::delete('/records/{monthlyReport}', [RecordController::class, 'destroyReport'])->name('records.destroy-report');
            Route::get('/records/{monthlyReport}/designations/{reportDetail}/edit', [RecordController::class, 'edit'])->name('records.edit');
            Route::put('/records/{monthlyReport}/designations/{reportDetail}', [RecordController::class, 'update'])->name('records.update');
            Route::delete('/records/{monthlyReport}/designations/{reportDetail}', [RecordController::class, 'destroy'])->name('records.destroy');

            Route::get('/search', [SearchController::class, 'index'])->name('search.index');
            Route::post('/search', [SearchController::class, 'search'])->name('search.search');

            Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/monthly', [AdminReportController::class, 'monthly'])->name('reports.monthly');
            Route::get('/reports/quarterly', [AdminReportController::class, 'quarterly'])->name('reports.quarterly');
            Route::get('/reports/station-wise', [AdminReportController::class, 'stationWise'])->name('reports.station-wise');
            Route::get('/reports/user-wise', [AdminReportController::class, 'userWise'])->name('reports.user-wise');
            Route::get('/reports/missing-submissions', [AdminReportController::class, 'missingSubmissions'])->name('reports.missing-submissions');
        });

    // ===================== PROFILE =====================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
