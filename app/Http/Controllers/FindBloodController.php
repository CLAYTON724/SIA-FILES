<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Services\MapService;
use Illuminate\Http\Request;

class FindBloodController extends Controller
{
    /**
     * Show the find blood page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bloodTypes = config('bloodsynce.blood_types');
        $urgencyLevels = config('bloodsynce.urgency_levels');
        
        // Get recent blood requests for emergency section
        $recentRequests = BloodRequest::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('find-blood', compact('bloodTypes', 'urgencyLevels', 'recentRequests'));
    }
    
    /**
     * Handle emergency blood request submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitEmergencyRequest(Request $request)
    {
        $validated = $request->validate([
            'blood_type' => 'required|string|in:' . implode(',', array_keys(config('bloodsynce.blood_types'))),
            'location' => 'required|string|max:255',
            'urgency' => 'required|string|in:' . implode(',', array_keys(config('bloodsynce.urgency_levels'))),
            'requester_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'units_needed' => 'required|integer|min:1|max:10',
        ]);
        
        // Create the blood request
        BloodRequest::create([
            'requester_id' => auth()->id(),
            'blood_type' => $validated['blood_type'],
            'urgency' => $validated['urgency'],
            'location' => $validated['location'],
            'requester_name' => $validated['requester_name'],
            'contact_phone' => $validated['contact_phone'],
            'units_needed' => $validated['units_needed'],
            'description' => 'Emergency blood request submitted via find blood page',
            'status' => 'active',
            'expires_at' => now()->addHours(24),
        ]);
        
        return redirect()->route('find-blood')
            ->with('success', 'Emergency blood request submitted successfully! We will notify compatible donors in your area.');
    }
}
