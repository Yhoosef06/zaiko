<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function storeReferences(Request $request)
    {
        $request->validate([
            'location' => 'required',
            'prepared_by' => 'required',
            'verified_by' => 'required',
            'noted_by' => 'required',
            'approved_by' => 'required',
            'role_1' => 'required',
            'role_2' => 'required',
            'role_3' => 'required',
            'role_4' => 'required',
        ]);

        Reference::create([
            'location' => $request->location,
            'prepared_by' => $request->prepared_by,
            'verified_by' => $request->verified_by,
            'noted_by' => $request->noted_by,
            'approved_by' => $request->approved_by,
            'role_1' => $request->role_1,
            'role_2' => $request->role_2,
            'role_3' => $request->role_3,
            'role_4' => $request->role_4,
        ]);

        return response()->json([
            'success' => 'Saved successfully.',
        ], 200);
    }

    public function getReferences(Request $request)
    {
        $locationId = $request->location;
        $references = Reference::where('location', '=', $locationId)->get();
        
        $data = $references;

        return response()->json($data);
    }
}
