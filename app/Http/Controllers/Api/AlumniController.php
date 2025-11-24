<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Get alumni detail by ID
     */
    public function show($id)
    {
        try {
            $alumni = Alumni::with(['user', 'major', 'career'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $alumni,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alumni not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching alumni detail',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
