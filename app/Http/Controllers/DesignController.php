<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedDesign;
use Illuminate\Support\Facades\Auth;

class DesignController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the incoming JSON
        $validated = $request->validate([
            'status' => 'required|string',
            'design_data' => 'required|array',
            'roster_data' => 'nullable|array',
        ]);

        // 2. Save it to the database attached to the logged-in user
        $design = SavedDesign::create([
            'user_id' => Auth::id(),
            'status' => $validated['status'],
            'design_data' => $validated['design_data'],
            'roster_data' => $validated['roster_data'],
        ]);

        // 3. Return a success response back to Javascript
        return response()->json([
            'message' => 'Design saved successfully!',
            'design_id' => $design->id
        ]);
    }
}
