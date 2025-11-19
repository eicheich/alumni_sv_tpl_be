<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Career;
use App\Models\Information;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalAlumni = Alumni::count();
        $activeAlumni = Alumni::where('is_active', true)->count();
        $inactiveAlumni = Alumni::where('is_active', false)->count();
        $totalInformation = Information::count();
        $alumniWithCareer = Career::distinct('alumni_id')->count();

        // Alumni by graduation year (get from educational backgrounds)
        $alumniByYear = DB::table('educational_backgrounds')
            ->where('graduation_year', '!=', null)
            ->selectRaw('graduation_year as year, COUNT(DISTINCT alumni_id) as count')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->get();

        // Prepare chart data
        $chartLabels = $alumniByYear->pluck('year')->toArray();
        $chartData = $alumniByYear->pluck('count')->toArray();

        return view('admin.dashboard', compact(
            'totalAlumni',
            'activeAlumni',
            'inactiveAlumni',
            'totalInformation',
            'alumniWithCareer',
            'chartLabels',
            'chartData'
        ));
    }
}
