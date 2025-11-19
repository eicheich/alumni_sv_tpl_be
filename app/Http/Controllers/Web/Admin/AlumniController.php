<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\EducationalBackground;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $major = Major::all();
        $alumni = Alumni::with('user')->get();
        return view('admin.alumni.index', compact('alumni', 'major'));
    }


    public function addAlumni(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'major_id' => 'required|exists:majors,id',
            'nim' => 'required|string|max:50|unique:alumnis',
            'photo_profile' => 'nullable|image|max:2048',
            'generation' => 'nullable|integer',
        ]);
        if (!$validate) {
            return back()->withErrors($validate)->withInput();
        }
        // prsess image
        $photoPath = null;
        if ($request->hasFile('photo_profile')) {
            $photoPath = $request->file('photo_profile')->store('photo_profiles', 'public');
        }
       DB::beginTransaction();
       try {
           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,
               'photo_profile' => $photoPath,
               'password' => bcrypt('temporarypassword'),
              ]);
            Alumni::create([
               'user_id' => $user->id,
               'nim' => $request->nim,
               'major_id' => $request->major_id,
               'is_active' => false,
           ]);
           EducationalBackground::create([
               'alumni_id' => $user->alumni->id,
               'generation' => $request->generation,
               'institution_name' => 'IPB University',
               'major' => 'Teknologi Rekayasa Perangkat Lunak',
               'degree' => 'Diploma 4',
               'faculty' => 'Sekolah Vokasi',
           ]);
           DB::commit();
       } catch (\Exception $e) {
           DB::rollBack();
           return back()->withErrors(['error' => 'Failed to add alumni: ' . $e->getMessage()])->withInput();
       }
         return redirect()->route('admin.alumni.index')->with('success', 'Alumni added successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumni $alumni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumni $alumni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumni $alumni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumni $alumni)
    {
        //
    }
}
