<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


Route::get('/otp', [OtpController::class, 'index'])->name('otp.index');
Route::post('/otp/send', [OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'otp_verified'])->group(function () {
    Route::prefix('admin')->middleware('role:admin')->group(function () {

        // Dashboard Admin (Kita ganti closure function jadi Controller biar rapi)
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardAdminController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('guru', \App\Http\Controllers\Admin\GuruController::class);

        Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);
        Route::resource('orangtua', \App\Http\Controllers\Admin\OrangtuaController::class);
        Route::post('/kelas/{id}/add-student', [\App\Http\Controllers\Admin\KelasController::class, 'addStudent'])->name('kelas.addStudent');
        Route::delete('/kelas/{id}/remove-student/{studentId}', [\App\Http\Controllers\Admin\KelasController::class, 'removeStudent'])->name('kelas.removeStudent');
        Route::post('/guru/import', [\App\Http\Controllers\Admin\GuruController::class, 'import'])->name('guru.import');

        Route::post('/siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'import'])->name('siswa.import');
    });
});

Route::middleware(['auth', 'otp_verified'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware(['auth', 'otp_verified', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Guru\DashboardGuruController::class, 'index'])
        ->name('dashboard');

    Route::resource('materi', \App\Http\Controllers\Guru\MateriController::class);
    Route::get('/monitoring-jurnal', [\App\Http\Controllers\Guru\MonitoringController::class, 'index'])
        ->name('monitoring.index');

    Route::get('/monitoring-jurnal/harian', [\App\Http\Controllers\Guru\MonitoringController::class, 'daily'])
        ->name('monitoring.daily');

    Route::get('/monitoring-jurnal/siswa/{studentId}', [\App\Http\Controllers\Guru\MonitoringController::class, 'studentDetail'])
        ->name('monitoring.student');

    Route::get('/monitoring-jurnal/siswa/{studentId}/harian', [\App\Http\Controllers\Guru\MonitoringController::class, 'studentDetailDaily'])->name('monitoring.student.daily');

    Route::get('/monitoring-jurnal/export-excel', [\App\Http\Controllers\Guru\MonitoringController::class, 'exportExcel'])->name('monitoring.export');

    Route::get('/monitoring-jurnal/siswa/{studentId}/export-excel', [\App\Http\Controllers\Guru\MonitoringController::class, 'exportExcelSiswa'])->name('monitoring.student.export');
});

Route::middleware(['auth', 'otp_verified', 'role:orangtua'])->prefix('orangtua')->name('orangtua.')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\Orangtua\DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/materi/{id}', [\App\Http\Controllers\Orangtua\DashboardController::class, 'show'])
        ->name('materi.show');

    // Kirim Feedback
    Route::post('/materi/{id}/feedback', [\App\Http\Controllers\Orangtua\DashboardController::class, 'storeFeedback'])
        ->name('materi.feedback');

    Route::get('/anak/{id}/materi', [\App\Http\Controllers\Orangtua\DashboardController::class, 'listMateri'])
        ->name('anak.materi');

    Route::get('/feedback-saya', [\App\Http\Controllers\Orangtua\DashboardController::class, 'historyFeedback'])
        ->name('feedback.index');

    Route::get('/anak/{studentId}/jurnal', [\App\Http\Controllers\Orangtua\JurnalController::class, 'index'])
        ->name('jurnal.index');

    Route::post('/anak/{studentId}/jurnal', [\App\Http\Controllers\Orangtua\JurnalController::class, 'store'])
        ->name('jurnal.store');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/ubah-password', [\App\Http\Controllers\PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/ubah-password', [\App\Http\Controllers\PasswordController::class, 'update'])->name('password.update');
});

require __DIR__ . '/auth.php';
