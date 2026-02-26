<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassRoom;

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalGuru' => User::where('role', 'guru')->count(),
            'totalOrangtua' => User::where('role', 'orangtua')->count(),
            'totalSiswa' => Student::count(),
            'totalKelas' => ClassRoom::count(),
        ]);
    }
}