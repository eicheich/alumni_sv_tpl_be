<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformationCategory;
use Illuminate\Http\Request;

class InformationCategoryController extends Controller
{
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
            return back()->withErrors(['error' => 'Category creation failed. Please try again.'])->withInput();
        }

        return redirect()->route('admin.information.index')->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $request->validate([
            'name' => 'required|string|max:255|unique:information_categories,name,' . $id,
        ]);

        $category = InformationCategory::findOrFail($id);
        try {
            $category->update([
                'name' => $request->name,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Category update failed. Please try again.'])->withInput();
        }

        return redirect()->route('admin.information.index')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $category = InformationCategory::findOrFail($id);
        try {
            $category->delete();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Category deletion failed. Please try again.']);
        }

        return redirect()->route('admin.information.index')->with('success', 'Category deleted successfully.');
    }
}
