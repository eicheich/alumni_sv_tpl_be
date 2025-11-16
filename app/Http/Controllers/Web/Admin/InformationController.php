<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\InformationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informationCategories = InformationCategory::all();
        $informations = Information::with('informationCategory')->get();
        return view('admin.information.index', compact('informationCategories', 'informations'));
    }

    public function storeInformation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'information_category_id' => 'required|exists:information_categories,id',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('information_category_id'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('photo')) {
            try {
                $photoPath = $request->file('photo')->store('information', 'public');
                $data['cover_image'] = $photoPath;
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return back()->withErrors(['photo' => 'Failed to upload photo.'])->withInput();
            }
        }

        try {
            Information::create($data);
        } catch (\Exception $e) {
            Log::error('Failed to create information: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add information. Please try again.'])->withInput();
        }

        return redirect()->back()->with('success', 'Informasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $information = Information::with('informationCategory')->findOrFail($id);
        return view('admin.information.show', compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editInformation($id)
    {
        $information = Information::findOrFail($id);
        $informationCategories = InformationCategory::all();
        return view('admin.information.edit', compact('information', 'informationCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateInformation(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'information_category_id' => 'required|exists:information_categories,id',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $information = Information::findOrFail($id);

        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('information_category_id'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('photo')) {
            try {
                $photoPath = $request->file('photo')->store('information', 'public');
                $data['cover_image'] = $photoPath;
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return back()->withErrors(['photo' => 'Failed to upload photo.'])->withInput();
            }
        }

        try {
            $information->update($data);
        } catch (\Exception $e) {
            Log::error('Failed to update information: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update information. Please try again.'])->withInput();
        }

        return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteInformation($id)
    {
        try {
            $information = Information::findOrFail($id);
            $information->delete();
            return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete information: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete information. Please try again.']);
        }
    }
}
