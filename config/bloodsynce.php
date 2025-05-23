<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BLOODSYNCE Application Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the BLOODSYNCE application.
    |
    */

    // Application name
    'name' => 'BLOODSYNCE',
    
    // Application version
    'version' => '1.0.0',
    
    // Default location (Manila, Philippines)
    'default_location' => [
        'latitude' => 14.5995,
        'longitude' => 121.0365,
        'city' => 'Manila',
        'country' => 'Philippines',
    ],
    
    // Blood types
    'blood_types' => [
        'a-positive' => 'A+',
        'a-negative' => 'A-',
        'b-positive' => 'B+',
        'b-negative' => 'B-',
        'ab-positive' => 'AB+',
        'ab-negative' => 'AB-',
        'o-positive' => 'O+',
        'o-negative' => 'O-',
        'unknown' => 'Unknown',
    ],
    
    // Urgency levels
    'urgency_levels' => [
        'critical' => 'Critical (0-2 hours)',
        'urgent' => 'Urgent (2-6 hours)',
        'moderate' => 'Moderate (6-24 hours)',
    ],
    
    // Notification types
    'notification_types' => [
        'blood_request' => 'Blood Request',
        'donation_reminder' => 'Donation Reminder',
        'thank_you' => 'Thank You',
        'system' => 'System',
    ],
    
    // Donation eligibility (in days)
    'donation_eligibility' => [
        'male' => 90, // 3 months
        'female' => 120, // 4 months
    ],
    
    // Emergency contact
    'emergency_contact' => [
        'phone' => '+63 2 8888 BLOOD (25663)',
        'email' => 'emergency@bloodsynce.com',
    ],
];
