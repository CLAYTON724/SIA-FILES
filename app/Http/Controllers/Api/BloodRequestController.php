<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodRequestController extends Controller
{
    /**
     * Get all blood requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = BloodRequest::query();
        
        // Filter by blood type
        if ($request->has('blood_type')) {
            $query->where('blood_type', $request->blood_type);
        }
        
        // Filter by urgency
        if ($request->has('urgency')) {
            $query->where('urgency', $request->urgency);
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to active requests only
            $query->where('status', 'active');
        }
        
        $requests = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'requests' => $requests,
        ]);
    }
    
    /**
     * Create a new blood request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'blood_type' => 'required|string|max:10',
            'urgency' => 'required|string|in:critical,urgent,moderate',
            'location' => 'required|string|max:255',
            'requester_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'units_needed' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        $bloodRequest = BloodRequest::create([
            'requester_id' => $user->id,
            'blood_type' => $validated['blood_type'],
            'urgency' => $validated['urgency'],
            'location' => $validated['location'],
            'requester_name' => $validated['requester_name'],
            'contact_phone' => $validated['contact_phone'],
            'units_needed' => $validated['units_needed'],
            'description' => $validated['description'] ?? null,
            'status' => 'active',
            'expires_at' => now()->addDays(1), // Expires in 24 hours by default
        ]);
        
        return response()->json([
            'message' => 'Blood request created successfully',
            'request' => $bloodRequest,
        ], 201);
    }
    
    /**
     * Get a specific blood request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        
        return response()->json([
            'request' => $bloodRequest,
        ]);
    }
    
    /**
     * Update a blood request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        
        // Check if the authenticated user is the requester
        if (Auth::id() !== $bloodRequest->requester_id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $validated = $request->validate([
            'urgency' => 'sometimes|string|in:critical,urgent,moderate',
            'location' => 'sometimes|string|max:255',
            'contact_phone' => 'sometimes|string|max:20',
            'units_needed' => 'sometimes|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'sometimes|string|in:active,fulfilled,cancelled',
        ]);
        
        $bloodRequest->update($validated);
        
        return response()->json([
            'message' => 'Blood request updated successfully',
            'request' => $bloodRequest,
        ]);
    }
}
