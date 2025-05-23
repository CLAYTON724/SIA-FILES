@extends('layouts.app')

@section('content')
<div class="flex min-h-screen flex-col">
    <main class="flex-1 bg-gray-50">
        <section class="bg-gradient-to-b from-red-50 to-white py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                        Find <span class="text-red-600">Blood</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600">
                        Search for blood donors and blood banks in your area. Get connected instantly.
                    </p>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                
                @if(session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Emergency Request Card -->
                <div class="mb-8 rounded-lg border border-red-200 bg-red-50 p-6">
                    <div class="mb-4">
                        <h2 class="flex items-center gap-2 text-xl font-bold text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                            </svg>
                            Emergency Blood Request
                        </h2>
                        <p class="text-red-600">
                            Need blood urgently? Submit an emergency request to notify all compatible donors in your area.
                        </p>
                    </div>
                    
                    <form action="{{ route('find-blood.emergency') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label for="emergency-blood-type" class="block text-sm font-medium text-gray-700 mb-1">Blood Type Needed</label>
                                <select id="emergency-blood-type" name="blood_type" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                    <option value="" disabled selected>Select type</option>
                                    @foreach($bloodTypes as $key => $label)
                                        @if($key !== 'unknown')
                                            <option value="{{ $key }}" {{ old('blood_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('blood_type')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="emergency-location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input id="emergency-location" name="location" type="text" placeholder="Enter location" required value="{{ old('location') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                @error('location')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="emergency-urgency" class="block text-sm font-medium text-gray-700 mb-1">Urgency Level</label>
                                <select id="emergency-urgency" name="urgency" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                    <option value="" disabled selected>Select urgency</option>
                                    @foreach($urgencyLevels as $key => $label)
                                        <option value="{{ $key }}" {{ old('urgency') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('urgency')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="emergency-units" class="block text-sm font-medium text-gray-700 mb-1">Units Needed</label>
                                <select id="emergency-units" name="units_needed" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                    <option value="" disabled selected>Select units</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('units_needed') == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'unit' : 'units' }}</option>
                                    @endfor
                                </select>
                                @error('units_needed')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="emergency-name" class="block text-sm font-medium text-gray-700 mb-1">Requester Name</label>
                                <input id="emergency-name" name="requester_name" type="text" placeholder="Full name" required value="{{ old('requester_name', auth()->user()->full_name ?? '') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                @error('requester_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="emergency-phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                                <input id="emergency-phone" name="contact_phone" type="tel" placeholder="Phone number" required value="{{ old('contact_phone', auth()->user()->phone ?? '') }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                @error('contact_phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full rounded-md bg-red-600 px-4 py-3 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 md:w-auto md:px-8">
                                Submit Emergency Request
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Search Section -->
                <div class="grid gap-8 lg:grid-cols-4">
                    <div class="lg:col-span-1">
                        <div class="rounded-lg border bg-white p-6 shadow-sm">
                            <h3 class="mb-4 flex items-center gap-2 text-lg font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                </svg>
                                Search Filters
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="blood-type-filter" class="block text-sm font-medium text-gray-700 mb-1">Blood Type</label>
                                    <select id="blood-type-filter" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                        <option value="all">Any blood type</option>
                                        @foreach($bloodTypes as $key => $label)
                                            @if($key !== 'unknown')
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="location-filter" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <select id="location-filter" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                        <option value="all">All locations</option>
                                        <option value="manila">Manila</option>
                                        <option value="quezon">Quezon City</option>
                                        <option value="makati">Makati</option>
                                        <option value="pasig">Pasig</option>
                                        <option value="taguig">Taguig</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="distance-filter" class="block text-sm font-medium text-gray-700 mb-1">Distance (km)</label>
                                    <select id="distance-filter" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                        <option value="all">Any distance</option>
                                        <option value="5">Within 5 km</option>
                                        <option value="10">Within 10 km</option>
                                        <option value="25">Within 25 km</option>
                                        <option value="50">Within 50 km</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="availability-filter" class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                                    <select id="availability-filter" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                        <option value="all">All</option>
                                        <option value="available">Available now</option>
                                        <option value="scheduled">Scheduled availability</option>
                                    </select>
                                </div>
                                
                                <div class="flex gap-2">
                                    <button id="reset-filters" class="flex-1 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                        Reset
                                    </button>
                                    <button id="apply-filters" class="flex-1 rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        <div class="rounded-lg border bg-white p-6 shadow-sm">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-medium">Search Results</h2>
                                    <p class="text-sm text-gray-600">Find blood donors and blood banks near you</p>
                                </div>
                                <div class="flex gap-2">
                                    <button id="list-view-btn" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                        List View
                                    </button>
                                    <button id="map-view-btn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                        Map View
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                    <input id="search-input" type="text" placeholder="Search by name, location, or blood type..." class="w-full rounded-md border border-gray-300 pl-10 pr-4 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                                </div>
                            </div>

                            <!-- Tabs -->
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex" aria-label="Tabs">
                                    <button id="donors-tab" class="w-1/2 border-b-2 border-red-500 py-4 px-1 text-center text-sm font-medium text-red-600">
                                        Blood Donors
                                    </button>
                                    <button id="banks-tab" class="w-1/2 border-b-2 border-transparent py-4 px-1 text-center text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                        Blood Banks
                                    </button>
                                </nav>
                            </div>
                            
                            <div class="mt-4">
                                <!-- List View -->
                                <div id="list-view" class="block">
                                    <div id="donors-content" class="space-y-4">
                                        <!-- Donor results will be loaded here -->
                                        <div class="text-center py-8">
                                            <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
                                            <p class="mt-2 text-sm text-gray-500">Loading donors...</p>
                                        </div>
                                    </div>
                                    
                                    <div id="banks-content" class="hidden space-y-4">
                                        <!-- Blood bank results will be loaded here -->
                                        <div class="text-center py-8">
                                            <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
                                            <p class="mt-2 text-sm text-gray-500">Loading blood banks...</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Map View -->
                                <div id="map-view" class="hidden">
                                    <x-leaflet-map type="both" height="500px" id="search-map" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const listViewBtn = document.getElementById('list-view-btn');
    const mapViewBtn = document.getElementById('map-view-btn');
    const listView = document.getElementById('list-view');
    const mapView = document.getElementById('map-view');
    const donorsTab = document.getElementById('donors-tab');
    const banksTab = document.getElementById('banks-tab');
    const donorsContent = document.getElementById('donors-content');
    const banksContent = document.getElementById('banks-content');
    const resetFiltersBtn = document.getElementById('reset-filters');
    const applyFiltersBtn = document.getElementById('apply-filters');
    
    // View toggle functionality
    listViewBtn.addEventListener('click', function() {
        listViewBtn.classList.add('bg-red-600', 'text-white');
        listViewBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
        
        mapViewBtn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        mapViewBtn.classList.remove('bg-red-600', 'text-white');
        
        listView.classList.remove('hidden');
        mapView.classList.add('hidden');
    });
    
    mapViewBtn.addEventListener('click', function() {
        mapViewBtn.classList.add('bg-red-600', 'text-white');
        mapViewBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
        
        listViewBtn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        listViewBtn.classList.remove('bg-red-600', 'text-white');
        
        mapView.classList.remove('hidden');
        listView.classList.add('hidden');
    });
    
    // Tab functionality
    donorsTab.addEventListener('click', function() {
        donorsTab.classList.add('border-red-500', 'text-red-600');
        donorsTab.classList.remove('border-transparent', 'text-gray-500');
        
        banksTab.classList.add('border-transparent', 'text-gray-500');
        banksTab.classList.remove('border-red-500', 'text-red-600');
        
        donorsContent.classList.remove('hidden');
        banksContent.classList.add('hidden');
    });
    
    banksTab.addEventListener('click', function() {
        banksTab.classList.add('border-red-500', 'text-red-600');
        banksTab.classList.remove('border-transparent', 'text-gray-500');
        
        donorsTab.classList.add('border-transparent', 'text-gray-500');
        donorsTab.classList.remove('border-red-500', 'text-red-600');
        
        banksContent.classList.remove('hidden');
        donorsContent.classList.add('hidden');
    });
    
    // Filter functionality
    resetFiltersBtn.addEventListener('click', function() {
        document.getElementById('blood-type-filter').value = 'all';
        document.getElementById('location-filter').value = 'all';
        document.getElementById('distance-filter').value = 'all';
        document.getElementById('availability-filter').value = 'all';
        document.getElementById('search-input').value = '';
        loadResults();
    });
    
    applyFiltersBtn.addEventListener('click', function() {
        loadResults();
    });
    
    // Load results function
    function loadResults() {
        const bloodType = document.getElementById('blood-type-filter').value;
        const location = document.getElementById('location-filter').value;
        const distance = document.getElementById('distance-filter').value;
        const availability = document.getElementById('availability-filter').value;
        const search = document.getElementById('search-input').value;
        
        // Show loading state
        donorsContent.innerHTML = `
            <div class="text-center py-8">
                <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
                <p class="mt-2 text-sm text-gray-500">Loading donors...</p>
            </div>
        `;
        
        banksContent.innerHTML = `
            <div class="text-center py-8">
                <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
                <p class="mt-2 text-sm text-gray-500">Loading blood banks...</p>
            </div>
        `;
        
        // Simulate API call - replace with actual API calls
        setTimeout(() => {
            loadDonors();
            loadBloodBanks();
        }, 1000);
    }
    
    function loadDonors() {
        // Mock donor data - replace with actual API call
        donorsContent.innerHTML = `
            <div class="rounded-lg border p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                            <span class="text-lg font-bold text-red-600">A+</span>
                        </div>
                        <div>
                            <h3 class="font-medium">Maria Santos</h3>
                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Makati City (1.2 km)
                            </div>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs">
                                    Last donation: 2 months ago
                                </span>
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">
                                    Available
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </button>
                        <button class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </button>
                        <button class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                            View Profile
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function loadBloodBanks() {
        // Mock blood bank data - replace with actual API call
        banksContent.innerHTML = `
            <div class="rounded-lg border p-4">
                <div class="flex flex-col space-y-4 md:flex-row md:items-start md:justify-between md:space-y-0">
                    <div>
                        <h3 class="font-medium">Philippine Red Cross Blood Center</h3>
                        <div class="mt-1 flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            Mandaluyong City (2.3 km)
                        </div>
                        <div class="mt-1 flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12,6 12,12 16,14"></polyline>
                            </svg>
                            8:00 AM - 5:00 PM
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">Available blood types:</p>
                            <div class="mt-1 flex flex-wrap gap-1">
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700">A+</span>
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700">A-</span>
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700">B+</span>
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700">O+</span>
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700">O-</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            Call
                        </button>
                        <button class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15,3 21,3 21,9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Website
                        </button>
                        <button class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Initial load
    loadResults();
});
</script>
@endsection
