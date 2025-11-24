<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;
use App\Models\OutstandingAlumni;
use Illuminate\Http\Request;

class OutstandingAlumniController extends Controller
{
    public function index()
    {
        $outstandingAlumni = OutstandingAlumni::with([
            'alumni.user',
            'alumni.major',
            'alumni.educationalBackgrounds'
        ])->latest()->get();

        return view('outstanding-alumni.index', compact('outstandingAlumni'));
    }

    public function show($encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404);
        }

        $outstandingAlumni = OutstandingAlumni::with([
            'alumni.user',
            'alumni.major',
            'alumni.educationalBackgrounds',
            'alumni.careers'
        ])->findOrFail($id);

        return view('outstanding-alumni.show', compact('outstandingAlumni'));
    }
}
