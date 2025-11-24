<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\InformationCategory;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index(Request $request)
    {
        $query = Information::with(['category', 'imageContents'])
            ->where('is_archive', 0)
            ->whereHas('category', function ($q) {
                $q->where('visibility', 0); // 0 = alumni & guest
            });

        // Filter by category if provided
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $informations = $query->paginate(9);
        $categories = InformationCategory::where('visibility', 0)->get(); // Only show categories visible to guests

        return view('information.index', compact('informations', 'categories'));
    }

    public function show($encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404);
        }

        $information = Information::with(['category', 'imageContents'])
            ->where('is_archive', 0)
            ->whereHas('category', function ($q) {
                $q->where('visibility', 0);
            })
            ->findOrFail($id);

        $relatedInformations = Information::where('category_id', $information->category_id)
            ->where('id', '!=', $id)
            ->where('is_archive', 0)
            ->whereHas('category', function ($q) {
                $q->where('visibility', 0);
            })
            ->take(3)
            ->get();

        return view('information.show', compact('information', 'relatedInformations'));
    }
}
