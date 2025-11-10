<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\InformationCategory;
use Database\Factories\GeneralInformationFactory;
use Illuminate\Http\Request;

class GeneralInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informationCategories = InformationCategory::all();
        $information = Information::with('category')->get();
        return view('admin.information.index', compact('informationCategories', 'information'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:information_categories,name',
        ]);

        try {
            InformationCategory::create([
                'name' => $request->name,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create category. Please try again.'])->withInput();
        }

        return redirect()->route('admin.information.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
}
