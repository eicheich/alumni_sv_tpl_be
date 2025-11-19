<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\OutstandingAlumni;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{

    public function index()
    {
        $totalAlumni = Alumni::count();
        $totalOutstandingAlumni = OutstandingAlumni::count();

        // Get outstanding alumni dengan eager loading
        $outstandingAlumni = OutstandingAlumni::with([
            'alumni.user',
            'alumni.major',
            'alumni.educationalBackgrounds'
        ])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get latest information
        $latestInformation = Information::with('category')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('landing', compact(
            'totalAlumni',
            'totalOutstandingAlumni',
            'outstandingAlumni',
            'latestInformation'
        ));
    }
}
