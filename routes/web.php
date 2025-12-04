<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomAllocationController;
use App\Http\Controllers\StudentController;
use App\Http\controllers\MpesaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Resources
    Route::resource('hostels', HostelController::class);
    Route::resource('rooms', RoomController::class);
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::match(['put', 'patch'], '/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Room Allocation
    Route::get('/allocations', [RoomAllocationController::class, 'index'])->name('allocations.index');
    Route::get('/allocations/create', [RoomAllocationController::class, 'create'])->name('allocations.create');
    Route::post('/allocations', [RoomAllocationController::class, 'store'])->name('allocations.store');
    Route::delete('/allocations/{bed}', [RoomAllocationController::class, 'destroy'])->name('allocations.destroy');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/hostel-summary', [ReportController::class, 'hostelSummary'])->name('hostel-summary');
        Route::get('/room-occupancy', [ReportController::class, 'roomOccupancy'])->name('room-occupancy');
        Route::get('/student-allocation', [ReportController::class, 'studentAllocation'])->name('student-allocation');
        Route::get('/hostel-summary/pdf', [ReportController::class, 'exportHostelSummaryPdf'])->name('hostel-summary.pdf');
    });
});

Route::get('/check-orphan-rooms', function () {
    $orphanRooms = \App\Models\Room::whereDoesntHave('hostel')->get();
    if ($orphanRooms->isEmpty()) {
        return 'No orphan rooms found.';
    }
    return $orphanRooms;
});

Route::post('/mpesa/stk/push', [MpesaController::class, 'initiateStkPush'])->name('mpesa.stkpush');

require __DIR__.'/auth.php';
