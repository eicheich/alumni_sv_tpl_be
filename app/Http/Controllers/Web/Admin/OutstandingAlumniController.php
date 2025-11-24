<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\OutstandingAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutstandingAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OutstandingAlumni::with(['alumni', 'alumni.user', 'alumni.major']);

        // Search by name or reward title
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('alumni', function ($q) use ($search) {
                $q->whereHas('user', function ($userQ) use ($search) {
                    $userQ->where('name', 'like', "%{$search}%");
                });
            })->orWhere('reward_title', 'like', "%{$search}%");
        }

        $outstandingAlumni = $query->paginate(10);

        // Get list of alumni for dropdown (those not already in outstanding alumni)
        $existingIds = OutstandingAlumni::pluck('alumni_id')->toArray();
        $availableAlumni = Alumni::with(['user', 'major'])
            ->whereNotIn('id', $existingIds)
            ->get();

        return view('admin.outstanding-alumni.index', compact('outstandingAlumni', 'availableAlumni'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alumni_id' => 'required|exists:alumnis,id',
            'award_title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            OutstandingAlumni::create($validated);
            DB::commit();
            return redirect()->route('admin.outstanding-alumni.index')->with('success', 'Alumni berprestasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan alumni berprestasi: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $outstandingAlumni = OutstandingAlumni::with(['alumni', 'alumni.user', 'alumni.major'])->findOrFail($id);
        return view('admin.outstanding-alumni.edit', compact('outstandingAlumni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $outstandingAlumni = OutstandingAlumni::findOrFail($id);

        $validated = $request->validate([
            'award_title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $outstandingAlumni->update($validated);
            DB::commit();
            return redirect()->route('admin.outstanding-alumni.index')->with('success', 'Alumni berprestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui alumni berprestasi: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        try {
            $outstandingAlumni = OutstandingAlumni::findOrFail($id);
            $outstandingAlumni->delete();
            return redirect()->route('admin.outstanding-alumni.index')->with('success', 'Alumni berprestasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus alumni berprestasi: ' . $e->getMessage()]);
        }
    }
}
