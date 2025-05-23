@extends('layouts.app')

@section('content')
<div class="flex min-h-screen flex-col">
    <main class="flex-1 bg-gray-50 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Dashboard</h1>
                    <p class="text-gray-500">Find blood donors and blood banks near you</p>
                </div>
                <div class="flex gap-2">
                    <button id="map-view-btn" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                        Map View
                    </button>
                    <button id="list-view-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        List View
                    </button>
                    <a href="{{ route('map') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Full Map
                    </a>
                </div>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <div class="md:col-span-2">
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <div class="mb-4">
                            <h2 class="text-lg font-medium">Search</h2>
                            <p class="text-sm text-gray-600">Find blood donors and blood banks near you</p>
                        </div>
                        <div class="space-y-4">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                                <input type="text" placeholder="Search by location, blood type, or name..." class="w-full rounded-md border border-gray-300 pl-10 pr-4 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                            </div>
                            
                            <!-- Search Filters -->
                            <div class="rounded-lg border p-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-medium">Filters</h3>
                                    <button id="toggle-filters" class="inline-flex items-center text-sm font-medium text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m18 15-6-6-6 6"/>
                                        </svg>
                                        Hide
                                    </button>
                                </div>
                                
                                <div id="filters-content" class="mt-4 grid gap-4 md:grid-cols-2">
                                    <!-- Blood Type Filter -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700">Blood Type</label>
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="blood-type-{{ $type }}" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                    <label for="blood-type-{{ $type }}" class="text-sm font-normal">{{ $type }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <!-- Location Filter -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700">Location</label>
                                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                            <option value="">Select location</option>
                                            <option value="current">Current location</option>
                                            <option value="manila">Manila</option>
                                            <option value="quezon">Quezon City</option>
                                            <option value="makati">Makati</option>
                                            <option value="cebu">Cebu City</option>
                                            <option value="davao">Davao City</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Apply Filters Button -->
                                    <div class="md:col-span-2 flex justify-end gap-2">
                                        <button class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                            Reset
                                        </button>
                                        <button class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                            Apply Filters
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs -->
                            <div>
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex" aria-label="Tabs">
                                        <button id="donors-tab" class="border-red-500 text-red-600 w-1/2 border-b-2 py-4 px-1 text-center text-sm font-medium">
                                            Blood Donors
                                        </button>
                                        <button id="banks-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/2 border-b-2 py-4 px-1 text-center text-sm font-medium">
                                            Blood Banks
                                        </button>
                                    </nav>
                                </div>
                                
                                <div class="mt-4">
                                    <!-- Map/List View Container -->
                                    <div id="map-container" class="block">
                                        <x-leaflet-map type="both" height="400px" id="dashboard-map" />
                                    </div>
                                    
                                    <!-- List View Container -->
                                    <div id="list-container" class="hidden space-y-4">
                                        @foreach($nearbyRequests as $request)
                                        <div class="rounded-lg border p-4">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-start space-x-4">
                                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                                        <span class="text-lg font-bold text-red-600">{{ $request->blood_type }}</span>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-medium">{{ $request->requester_name }}</h3>
                                                        <div class="mt-1 flex items-center text-sm text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                                <circle cx="12" cy="10" r="3"></circle>
                                                            </svg>
                                                            {{ $request->location }}
                                                        </div>
                                                        <div class="mt-2 flex flex-wrap gap-2">
                                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs">
                                                                Units needed: {{ $request->units_needed }}
                                                            </span>
                                                            <span class="inline-flex items-center rounded-full bg-{{ $request->urgency == 'critical' ? 'red' : ($request->urgency == 'urgent' ? 'amber' : 'green') }}-100 px-2 py-1 text-xs text-{{ $request->urgency == 'critical' ? 'red' : ($request->urgency == 'urgent' ? 'amber' : 'green') }}-800">
                                                                {{ ucfirst($request->urgency) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a href="tel:{{ $request->contact_phone }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                                        </svg>
                                                        <span class="sr-only">Call</span>
                                                    </a>
                                                    <a href="{{ route('requests.show', $request->id) }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-medium">Your Profile</h2>
                        <div class="mt-4 flex flex-col items-center space-y-4 text-center">
                            <div class="relative h-20 w-20 rounded-full bg-red-100">
                                <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-2xl font-bold text-red-600">
                                    {{ Auth::user()->blood_type }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium">{{ Auth::user()->full_name }}</h3>
                                <p class="text-sm text-gray-500">{{ Auth::user()->city }}, {{ Auth::user()->province }}</p>
                            </div>
                            <div class="grid w-full grid-cols-2 gap-2 text-center">
                                <div class="rounded-lg bg-gray-100 p-2">
                                    <p class="text-xs text-gray-500">Last Donation</p>
                                    <p class="font-medium">{{ Auth::user()->last_donation ? Auth::user()->last_donation->diffForHumans() : 'Never' }}</p>
                                </div>
                                <div class="rounded-lg bg-gray-100 p-2">
                                    <p class="text-xs text-gray-500">Total Donations</p>
                                    <p class="font-medium">{{ Auth::user()->total_donations }}</p>
                                </div>
                            </div>
                            <div class="w-full space-y-2">
                                <a href="{{ route('profile') }}" class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                    Edit Profile
                                </a>
                                <a href="{{ route('donations.new') }}" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                    Record Donation
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg border bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-medium">Nearby Requests</h2>
                        <div class="mt-4 space-y-4">
                            @foreach($nearbyRequests->take(2) as $request)
                            <div class="rounded-lg border p-3">
                                <div class="flex justify-between">
                                    <div class="font-medium">{{ $request->blood_type }} Blood Needed</div>
                                    <div class="text-sm font-medium text-{{ $request->urgency == 'critical' ? 'red' : ($request->urgency == 'urgent' ? 'amber' : 'green') }}-600">
                                        {{ ucfirst($request->urgency) }}
                                    </div>
                                </div>
                                <div class="mt-1 text-sm text-gray-500">{{ $request->location }}</div>
                                <div class="mt-2 flex justify-between">
                                    <div class="text-xs text-gray-500">{{ rand(1, 10) }}.{{ rand(1, 9) }} km away</div>
                                    <a href="{{ route('requests.show', $request->id) }}" class="text-xs text-red-600 hover:underline">
                                        View details
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapViewBtn = document.getElementById('map-view-btn');
    const listViewBtn = document.getElementById('list-view-btn');
    const mapContainer = document.getElementById('map-container');
    const listContainer = document.getElementById('list-container');
    const toggleFiltersBtn = document.getElementById('toggle-filters');
    const filtersContent = document.getElementById('filters-content');
    const donorsTab = document.getElementById('donors-tab');
    const banksTab = document.getElementById('banks-tab');
    
    // Toggle between map and list view
    mapViewBtn.addEventListener('click', function() {
        mapViewBtn.classList.add('bg-red-600', 'text-white');
        mapViewBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
        
        listViewBtn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        listViewBtn.classList.remove('bg-red-600', 'text-white');
        
        mapContainer.classList.remove('hidden');
        listContainer.classList.add('hidden');
    });
    
    listViewBtn.addEventListener('click', function() {
        listViewBtn.classList.add('bg-red-600', 'text-white');
        listViewBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
        
        mapViewBtn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        mapViewBtn.classList.remove('bg-red-600', 'text-white');
        
        listContainer.classList.remove('hidden');
        mapContainer.classList.add('hidden');
    });
    
    // Toggle filters
    toggleFiltersBtn.addEventListener('click', function() {
        filtersContent.classList.toggle('hidden');
        
        if (filtersContent.classList.contains('hidden')) {
            toggleFiltersBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
                Show
            `;
        } else {
            toggleFiltersBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m18 15-6-6-6 6"/>
                </svg>
                Hide
            `;
        }
    });
    
    // Tab switching
    donorsTab.addEventListener('click', function() {
        donorsTab.classList.add('border-red-500', 'text-red-600');
        donorsTab.classList.remove('border-transparent', 'text-gray-500');
        
        banksTab.classList.add('border-transparent', 'text-gray-500');
        banksTab.classList.remove('border-red-500', 'text-red-600');
    });
    
    banksTab.addEventListener('click', function() {
        banksTab.classList.add('border-red-500', 'text-red-600');
        banksTab.classList.remove('border-transparent', 'text-gray-500');
        
        donorsTab.classList.add('border-transparent', 'text-gray-500');
        donorsTab.classList.remove('border-red-500', 'text-red-600');
    });
});
</script>
@endsection
