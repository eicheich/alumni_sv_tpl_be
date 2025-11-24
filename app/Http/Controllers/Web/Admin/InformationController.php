<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\InformationCategory;
use App\Models\InformationImageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Information::with('category');

        // Search by title or content
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $informations = $query->paginate(10);
        $informationCategories = InformationCategory::all();
        return view('admin.information.index', compact('informationCategories', 'informations'));
    }

    public function storeInformation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'information_category_id' => 'required|exists:information_categories,id',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_archive' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('information_category_id'),
            'content' => $request->input('content'),
            'is_archive' => $request->has('is_archive') ? 1 : 0,
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
            $information = Information::create($data);

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $imagePath = $file->store('information/gallery', 'public');
                    InformationImageContent::create([
                        'information_id' => $information->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }
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
        $information = Information::with(['category', 'imageContents'])->findOrFail($id);
        return view('admin.information.show', compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editInformation($id)
    {
        $information = Information::with('imageContents')->findOrFail($id);
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
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_archive' => 'nullable|boolean',
        ]);

        $information = Information::findOrFail($id);

        $data = [
            'title' => $request->input('title'),
            'category_id' => $request->input('information_category_id'),
            'content' => $request->input('content'),
            'is_archive' => $request->has('is_archive') ? 1 : 0,
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

        if ($request->hasFile('gallery_images')) {
            try {
                foreach ($request->file('gallery_images') as $file) {
                    $imagePath = $file->store('information/gallery', 'public');
                    InformationImageContent::create([
                        'information_id' => $information->id,
                        'image_path' => $imagePath,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Gallery images upload failed: ' . $e->getMessage());
                return back()->withErrors(['gallery_images' => 'Failed to upload gallery images.'])->withInput();
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
            $information = Information::with('imageContents')->findOrFail($id);

            // Delete associated gallery images
            foreach ($information->imageContents as $image) {
                // Delete file from storage
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            // Delete cover image if exists
            if ($information->cover_image && Storage::disk('public')->exists($information->cover_image)) {
                Storage::disk('public')->delete($information->cover_image);
            }

            $information->delete();
            return redirect()->route('admin.information.index')->with('success', 'Informasi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete information: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete information. Please try again.']);
        }
    }

    /**
     * Store gallery images for information.
     */
    public function storeGallery(Request $request)
    {
        $request->validate([
            'information_id' => 'required|exists:information,id',
            'gallery_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $uploaded = 0;
            foreach ($request->file('gallery_images') as $file) {
                $imagePath = $file->store('information/gallery', 'public');
                InformationImageContent::create([
                    'information_id' => $request->information_id,
                    'image_path' => $imagePath,
                ]);
                $uploaded++;
            }

            return redirect()->back()->with('success', "{$uploaded} gambar berhasil diupload.");
        } catch (\Exception $e) {
            Log::error('Gallery upload failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal mengupload gambar.']);
        }
    }

    /**
     * Delete gallery image.
     */
    public function deleteGallery($id)
    {
        try {
            $image = InformationImageContent::findOrFail($id);

            // Delete file from storage
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();

            return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gallery delete failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus gambar.']);
        }
    }
}
