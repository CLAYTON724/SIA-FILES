<?php

namespace App\Services;

class MapService
{
    /**
     * Get mock donor data for map display
     */
    public static function getDonorData()
    {
        return [
            [
                'id' => 1,
                'name' => 'Maria Santos',
                'blood_type' => 'A+',
                'location' => 'Makati City',
                'latitude' => 14.5547,
                'longitude' => 121.0244,
                'last_donation' => '2 months ago',
                'available' => true,
                'phone' => '+63 912 345 6789',
            ],
            [
                'id' => 2,
                'name' => 'Juan Dela Cruz',
                'blood_type' => 'O-',
                'location' => 'Quezon City',
                'latitude' => 14.676,
                'longitude' => 121.0437,
                'last_donation' => '5 months ago',
                'available' => true,
                'phone' => '+63 917 123 4567',
            ],
            [
                'id' => 3,
                'name' => 'Ana Reyes',
                'blood_type' => 'B+',
                'location' => 'Pasig City',
                'latitude' => 14.5764,
                'longitude' => 121.0851,
                'last_donation' => '1 month ago',
                'available' => false,
                'phone' => '+63 918 987 6543',
            ],
            [
                'id' => 4,
                'name' => 'Miguel Ramos',
                'blood_type' => 'AB+',
                'location' => 'Taguig City',
                'latitude' => 14.5176,
                'longitude' => 121.0509,
                'last_donation' => '3 months ago',
                'available' => true,
                'phone' => '+63 919 456 7890',
            ],
        ];
    }

    /**
     * Get mock blood bank data for map display
     */
    public static function getBloodBankData()
    {
        return [
            [
                'id' => 1,
                'name' => 'Philippine Red Cross Blood Center',
                'location' => 'Mandaluyong City',
                'latitude' => 14.5794,
                'longitude' => 121.0359,
                'hours' => '8:00 AM - 5:00 PM',
                'phone' => '+63 2 8527 0000',
                'website' => 'https://redcross.org.ph',
                'available_types' => ['A+', 'A-', 'B+', 'O+', 'O-'],
            ],
            [
                'id' => 2,
                'name' => "St. Luke's Medical Center Blood Bank",
                'location' => 'Quezon City',
                'latitude' => 14.6262,
                'longitude' => 121.0185,
                'hours' => '24 hours',
                'phone' => '+63 2 8723 0101',
                'website' => 'https://stlukes.com.ph',
                'available_types' => ['A+', 'AB+', 'B+', 'O+'],
            ],
            [
                'id' => 3,
                'name' => 'Philippine General Hospital Blood Bank',
                'location' => 'Manila',
                'latitude' => 14.5796,
                'longitude' => 120.9826,
                'hours' => '7:00 AM - 7:00 PM',
                'phone' => '+63 2 8554 8400',
                'website' => 'https://pgh.gov.ph',
                'available_types' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            ],
        ];
    }

    /**
     * Calculate distance between two coordinates (in kilometers)
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    /**
     * Filter data by distance from a given point
     */
    public static function filterByDistance($data, $userLat, $userLon, $maxDistance = 50)
    {
        return array_filter($data, function($item) use ($userLat, $userLon, $maxDistance) {
            $distance = self::calculateDistance($userLat, $userLon, $item['latitude'], $item['longitude']);
            return $distance <= $maxDistance;
        });
    }
}
