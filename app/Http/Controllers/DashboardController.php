<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $nearbyRequests = BloodRequest::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard', compact('user', 'notifications', 'nearbyRequests'));
    }
    
    /**
     * Show the user's donations.
     *
     * @return \Illuminate\View\View
     */
    public function donations()
    {
        $user = Auth::user();
        $donations = Donation::where('user_id', $user->id)
            ->orderBy('donation_date', 'desc')
            ->get();
            
        return view('donations.index', compact('donations'));
    }
    
    /**
     * Show the form to record a new donation.
     *
     * @return \Illuminate\View\View
     */
    public function newDonation()
    {
        return view('donations.create');
    }
    
    /**
     * Store a new donation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'donation_date' => 'required|date',
            'location' => 'required|string|max:255',
            'units' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        Donation::create([
            'user_id' => $user->id,
            'donation_date' => $validated['donation_date'],
            'location' => $validated['location'],
            'units' => $validated['units'],
            'notes' => $validated['notes'] ?? null,
        ]);
        
        return redirect()->route('donations')
            ->with('success', 'Donation recorded successfully!');
    }
    
    /**
     * Show the user's blood requests.
     *
     * @return \Illuminate\View\View
     */
    public function requests()
    {
        $user = Auth::user();
        $requests = BloodRequest::where('requester_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('requests.index', compact('requests'));
    }
    
    /**
     * Show a specific blood request.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showRequest($id)
    {
        $request = BloodRequest::findOrFail($id);
        
        return view('requests.show', compact('request'));
    }
}
