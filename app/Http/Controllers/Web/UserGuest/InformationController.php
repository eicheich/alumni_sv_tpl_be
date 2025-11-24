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
        $query = Information::with(['category', 'imageContents']);

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
        $categories = InformationCategory::all();

        return view('information.index', compact('informations', 'categories'));
    }

    public function show($id)
    {
        $information = Information::with(['category', 'imageContents'])
            ->findOrFail($id);

        $relatedInformations = Information::where('category_id', $information->information_category_id)
            ->where('id', '!=', $id)
            ->take(3)
            ->get();

        return view('information.show', compact('information', 'relatedInformations'));
    }
}
