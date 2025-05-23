@extends('layouts.app')

@section('content')
<div class="flex min-h-screen flex-col">
    <main class="flex-1 bg-gray-50 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold">Interactive Map</h1>
                <p class="text-gray-500">Find blood donors and blood banks near you</p>
            </div>

            <!-- Map Controls -->
            <div class="mb-6 rounded-lg border bg-white p-4 shadow-sm">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex gap-2">
                        <button id="show-all" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                            Show All
                        </button>
                        <button id="show-donors" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            Donors Only
                        </button>
                        <button id="show-banks" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            Blood Banks Only
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <label for="blood-type-filter" class="text-sm font-medium text-gray-700">Filter by Blood Type:</label>
                        <select id="blood-type-filter" class="rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="all">All Types</option>
                            @foreach($bloodTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button id="refresh-map" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                            <path d="M21 3v5h-5"/>
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                            <path d="M3 21v-5h5"/>
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Map Container -->
            <div class="grid gap-8 lg:grid-cols-4">
                <div class="lg:col-span-3">
                    <x-leaflet-map type="both" height="600px" id="main-map" />
                </div>
                
                <!-- Map Legend and Stats -->
                <div class="space-y-6">
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-medium">Map Legend</h3>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500">
                                    <div class="h-2 w-2 rounded-full bg-white"></div>
                                </div>
                                <span class="text-sm">Your Location</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2v6m0 0v14m0-14l4-4m-4 4L8 4"></path>
                                    </svg>
                                </div>
                                <span class="text-sm">Blood Donors</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"></path>
                                        <path d="M1 21h22"></path>
                                        <path d="M7 10.5h10"></path>
                                        <path d="M7 15.5h10"></path>
                                    </svg>
                                </div>
                                <span class="text-sm">Blood Banks</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-medium">Quick Stats</h3>
                        <div class="mt-4 space-y-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-red-600" id="donor-count">4</div>
                                <div class="text-sm text-gray-500">Active Donors</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600" id="bank-count">3</div>
                                <div class="text-sm text-gray-500">Blood Banks</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600" id="available-count">3</div>
                                <div class="text-sm text-gray-500">Available Now</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-medium">Emergency Contact</h3>
                        <div class="mt-4 space-y-3">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">Need urgent help?</p>
                                <a href="tel:{{ config('bloodsynce.emergency_contact.phone') }}" class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    Emergency Hotline
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const showAllBtn = document.getElementById('show-all');
    const showDonorsBtn = document.getElementById('show-donors');
    const showBanksBtn = document.getElementById('show-banks');
    const bloodTypeFilter = document.getElementById('blood-type-filter');
    const refreshBtn = document.getElementById('refresh-map');
    
    let currentMapType = 'both';
    
    // Button click handlers
    showAllBtn.addEventListener('click', function() {
        setActiveButton(showAllBtn);
        currentMapType = 'both';
        reloadMap();
    });
    
    showDonorsBtn.addEventListener('click', function() {
        setActiveButton(showDonorsBtn);
        currentMapType = 'donors';
        reloadMap();
    });
    
    showBanksBtn.addEventListener('click', function() {
        setActiveButton(showBanksBtn);
        currentMapType = 'banks';
        reloadMap();
    });
    
    bloodTypeFilter.addEventListener('change', function() {
        reloadMap();
    });
    
    refreshBtn.addEventListener('click', function() {
        reloadMap();
    });
    
    function setActiveButton(activeBtn) {
        [showAllBtn, showDonorsBtn, showBanksBtn].forEach(btn => {
            btn.classList.remove('bg-red-600', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        });
        
        activeBtn.classList.add('bg-red-600', 'text-white');
        activeBtn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
    }
    
    function reloadMap() {
        // This would trigger a map reload with new parameters
        // For now, we'll just show a loading state
        const loadingElement = document.getElementById('main-map-loading');
        if (loadingElement) {
            loadingElement.style.display = 'flex';
        }
        
        // Simulate reload delay
        setTimeout(() => {
            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
        }, 1000);
    }
});
</script>
@endsection
