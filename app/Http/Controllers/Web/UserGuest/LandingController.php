<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\OutstandingAlumni;
use App\Models\Information;
use App\Models\Career;
use App\Models\EducationalBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{

    public function index()
    {
        $totalAlumni = Alumni::count();
        $totalOutstandingAlumni = OutstandingAlumni::count();

        // Total informasi
        $allowedVisibility = [0];
        if (Auth::guard('alumni')->check() || Auth::guard('admin')->check()) {
            $allowedVisibility[] = 1;
        }
        $totalInformation = Information::where('is_archive', 0)
            ->whereHas('category', function ($q) use ($allowedVisibility) {
                $q->whereIn('visibility', $allowedVisibility);
            })
            ->count();

        // Total tahun berdiri (dari tahun lulus tertua)
        $oldestGraduationYear = EducationalBackground::min('graduation_year');
        $yearsSinceFounded = $oldestGraduationYear ? (date('Y') - $oldestGraduationYear) : 10;

        // Total perusahaan partner (unique company names)
        $totalPartnerCompanies = Career::distinct('company_name')->count('company_name');

        // Total alumni berkarir (yang memiliki data karir)
        $totalWorkingAlumni = Alumni::whereHas('careers')->count();

        // Tingkat kepuasan alumni (hardcoded untuk saat ini, bisa ditambahkan survey system nanti)
        $satisfactionRate = 92;

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
            ->where('is_archive', 0)
            ->whereHas('category', function ($q) use ($allowedVisibility) {
                $q->whereIn('visibility', $allowedVisibility);
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('landing', compact(
            'totalAlumni',
            'totalOutstandingAlumni',
            'totalInformation',
            'yearsSinceFounded',
            'totalPartnerCompanies',
            'totalWorkingAlumni',
            'satisfactionRate',
            'outstandingAlumni',
            'latestInformation'
        ));
    }
}
