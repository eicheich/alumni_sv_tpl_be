<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Career;
use App\Models\Information;
use App\Models\OutstandingAlumni;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistics - ambil dari user yang role nya alumni
        $totalAlumni = User::whereHas('alumni')->count();
        $totalInformation = Information::count();
        $totalOutstandingAlumni = OutstandingAlumni::count();

        // Alumni by angkatan (batch year)
        $alumniByAngkatan = Alumni::selectRaw('angkatan, COUNT(*) as count')
            ->whereNotNull('angkatan')
            ->groupBy('angkatan')
            ->orderBy('angkatan')
            ->get();

        // Prepare chart data
        $chartLabels = $alumniByAngkatan->pluck('angkatan')->toArray();
        $chartData = $alumniByAngkatan->pluck('count')->toArray();

        return view('admin.dashboard', compact(
            'totalAlumni',
            'totalInformation',
            'totalOutstandingAlumni',
            'chartLabels',
            'chartData'
        ));
    }
}
