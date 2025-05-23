<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MapService;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Get donor data for map display
     */
    public function getDonors(Request $request)
    {
        $donors = MapService::getDonorData();
        
        // Filter by blood type if provided
        if ($request->has('blood_type') && $request->blood_type) {
            $donors = array_filter($donors, function($donor) use ($request) {
                return strtolower($donor['blood_type']) === strtolower($request->blood_type);
            });
        }
        
        // Filter by availability if provided
        if ($request->has('available_only') && $request->available_only === 'true') {
            $donors = array_filter($donors, function($donor) {
                return $donor['available'] === true;
            });
        }
        
        // Filter by distance if user location is provided
        if ($request->has('user_lat') && $request->has('user_lon') && $request->has('max_distance')) {
            $donors = MapService::filterByDistance(
                $donors, 
                $request->user_lat, 
                $request->user_lon, 
                $request->max_distance
            );
        }
        
        return response()->json([
            'success' => true,
            'data' => array_values($donors), // Re-index array
            'count' => count($donors)
        ]);
    }
    
    /**
     * Get blood bank data for map display
     */
    public function getBloodBanks(Request $request)
    {
        $bloodBanks = MapService::getBloodBankData();
        
        // Filter by blood type if provided
        if ($request->has('blood_type') && $request->blood_type) {
            $bloodBanks = array_filter($bloodBanks, function($bank) use ($request) {
                return in_array($request->blood_type, $bank['available_types']);
            });
        }
        
        // Filter by distance if user location is provided
        if ($request->has('user_lat') && $request->has('user_lon') && $request->has('max_distance')) {
            $bloodBanks = MapService::filterByDistance(
                $bloodBanks, 
                $request->user_lat, 
                $request->user_lon, 
                $request->max_distance
            );
        }
        
        return response()->json([
            'success' => true,
            'data' => array_values($bloodBanks), // Re-index array
            'count' => count($bloodBanks)
        ]);
    }
    
    /**
     * Get both donors and blood banks for map display
     */
    public function getMapData(Request $request)
    {
        $donors = MapService::getDonorData();
        $bloodBanks = MapService::getBloodBankData();
        
        // Apply filters if provided
        if ($request->has('blood_type') && $request->blood_type) {
            $donors = array_filter($donors, function($donor) use ($request) {
                return strtolower($donor['blood_type']) === strtolower($request->blood_type);
            });
            
            $bloodBanks = array_filter($bloodBanks, function($bank) use ($request) {
                return in_array($request->blood_type, $bank['available_types']);
            });
        }
        
        return response()->json([
            'success' => true,
            'donors' => array_values($donors),
            'blood_banks' => array_values($bloodBanks),
            'center' => [
                'latitude' => config('bloodsynce.default_location.latitude'),
                'longitude' => config('bloodsynce.default_location.longitude')
            ]
        ]);
    }
}
