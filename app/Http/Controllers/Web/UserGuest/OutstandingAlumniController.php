<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;
use App\Models\OutstandingAlumni;
use Illuminate\Http\Request;

class OutstandingAlumniController extends Controller
{
    public function show($id)
    {
        $outstandingAlumni = OutstandingAlumni::with([
            'alumni.user',
            'alumni.major',
            'alumni.educationalBackgrounds',
            'alumni.careers'
        ])->findOrFail($id);

        return view('outstanding-alumni.show', compact('outstandingAlumni'));
    }
}
