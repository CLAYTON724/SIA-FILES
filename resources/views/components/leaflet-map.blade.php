@props(['type' => 'both', 'height' => '400px', 'id' => 'map'])

<div class="relative w-full overflow-hidden rounded-lg border" style="height: {{ $height }}">
    <div id="{{ $id }}" class="h-full w-full"></div>
    
    <!-- Loading overlay -->
    <div id="{{ $id }}-loading" class="absolute inset-0 flex items-center justify-center bg-gray-100">
        <div class="text-center">
            <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
            <p class="mt-2 text-sm text-gray-500">Loading map...</p>
        </div>
    </div>
    
    <!-- Map info panel -->
    <div id="{{ $id }}-info" class="absolute bottom-4 left-4 right-4 rounded-lg bg-white p-3 shadow-lg" style="display: none;">
        <p class="font-medium" id="{{ $id }}-info-title">Loading...</p>
        <p class="text-sm text-gray-500" id="{{ $id }}-info-subtitle">Please wait while we load the map data</p>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapId = '{{ $id }}';
    const mapType = '{{ $type }}';
    const loadingElement = document.getElementById(mapId + '-loading');
    const infoElement = document.getElementById(mapId + '-info');
    const infoTitle = document.getElementById(mapId + '-info-title');
    const infoSubtitle = document.getElementById(mapId + '-info-subtitle');
    
    let map;
    let userLocation = null;
    let markersLayer = L.layerGroup();
    
    // Default center (Manila, Philippines)
    const defaultCenter = [14.5995, 121.0365];
    
    // Initialize map
    function initMap() {
        map = L.map(mapId).setView(defaultCenter, 12);
        
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add markers layer
        markersLayer.addTo(map);
        
        // Get user location
        getUserLocation();
        
        // Load map data
        loadMapData();
    }
    
    // Get user's current location
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    userLocation = [position.coords.latitude, position.coords.longitude];
                    
                    // Add user location marker
                    const userIcon = L.divIcon({
                        className: 'user-location-marker',
                        html: `<div style="background-color: #3b82f6; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                <div style="width: 8px; height: 8px; background-color: white; border-radius: 50%;"></div>
                              </div>`,
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    });
                    
                    L.marker(userLocation, { icon: userIcon })
                        .addTo(markersLayer)
                        .bindPopup('<div class="p-1 text-center"><p class="font-medium">Your Location</p></div>');
                    
                    // Center map on user location
                    map.setView(userLocation, 13);
                },
                function(error) {
                    console.warn('Geolocation error:', error);
                }
            );
        }
    }
    
    // Create custom icon for markers
    function createCustomIcon(color, type) {
        const iconHtml = type === 'donor' 
            ? '<path d="M12 2v6m0 0v14m0-14l4-4m-4 4L8 4"></path>'
            : '<path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"></path><path d="M1 21h22"></path><path d="M7 10.5h10"></path><path d="M7 15.5h10"></path>';
        
        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="background-color: ${color}; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        ${iconHtml}
                    </svg>
                  </div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });
    }
    
    // Load map data from API
    function loadMapData() {
        let apiUrl;
        
        if (mapType === 'donors') {
            apiUrl = '/api/map/donors';
        } else if (mapType === 'banks') {
            apiUrl = '/api/map/blood-banks';
        } else {
            apiUrl = '/api/map/data';
        }
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (mapType === 'both') {
                        addDonorMarkers(data.donors);
                        addBloodBankMarkers(data.blood_banks);
                        updateInfoPanel(data.donors.length + data.blood_banks.length, 'locations');
                    } else if (mapType === 'donors') {
                        addDonorMarkers(data.data);
                        updateInfoPanel(data.count, 'donors');
                    } else if (mapType === 'banks') {
                        addBloodBankMarkers(data.data);
                        updateInfoPanel(data.count, 'blood banks');
                    }
                } else {
                    console.error('Failed to load map data:', data);
                }
            })
            .catch(error => {
                console.error('Error loading map data:', error);
            })
            .finally(() => {
                // Hide loading overlay
                loadingElement.style.display = 'none';
                infoElement.style.display = 'block';
            });
    }
    
    // Add donor markers to map
    function addDonorMarkers(donors) {
        donors.forEach(donor => {
            const icon = createCustomIcon('#dc2626', 'donor');
            const marker = L.marker([donor.latitude, donor.longitude], { icon })
                .addTo(markersLayer);
            
            const popupContent = `
                <div class="p-1">
                    <h3 class="font-medium">${donor.name}</h3>
                    <p class="text-sm text-gray-500">${donor.location}</p>
                    <div class="mt-1 flex items-center gap-1">
                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                            ${donor.blood_type}
                        </span>
                        <span class="text-xs text-gray-500">
                            Last donation: ${donor.last_donation}
                        </span>
                    </div>
                    <button onclick="contactDonor('${donor.phone}')" class="mt-2 w-full rounded bg-red-600 px-2 py-1 text-xs text-white hover:bg-red-700">
                        Contact Donor
                    </button>
                </div>
            `;
            
            marker.bindPopup(popupContent);
        });
    }
    
    // Add blood bank markers to map
    function addBloodBankMarkers(bloodBanks) {
        bloodBanks.forEach(bank => {
            const icon = createCustomIcon('#7c3aed', 'bank');
            const marker = L.marker([bank.latitude, bank.longitude], { icon })
                .addTo(markersLayer);
            
            const typesHtml = bank.available_types.map(type => 
                `<span class="rounded-full bg-red-50 px-1.5 py-0.5 text-xs font-medium text-red-700">${type}</span>`
            ).join(' ');
            
            const popupContent = `
                <div class="p-1">
                    <h3 class="font-medium">${bank.name}</h3>
                    <p class="text-sm text-gray-500">${bank.location}</p>
                    <p class="text-xs text-gray-500">${bank.hours}</p>
                    <div class="mt-1 flex flex-wrap gap-1">
                        ${typesHtml}
                    </div>
                    <div class="mt-2 flex gap-1">
                        <button onclick="callBloodBank('${bank.phone}')" class="flex-1 rounded bg-gray-600 px-2 py-1 text-xs text-white hover:bg-gray-700">
                            Call
                        </button>
                        <button onclick="visitWebsite('${bank.website}')" class="flex-1 rounded bg-red-600 px-2 py-1 text-xs text-white hover:bg-red-700">
                            Website
                        </button>
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent);
        });
    }
    
    // Update info panel
    function updateInfoPanel(count, type) {
        infoTitle.textContent = `${count} ${type} found`;
        infoSubtitle.textContent = `Zoom in or move the map to see more ${type}`;
    }
    
    // Global functions for popup buttons
    window.contactDonor = function(phone) {
        if (phone) {
            window.open(`tel:${phone}`, '_self');
        }
    };
    
    window.callBloodBank = function(phone) {
        if (phone) {
            window.open(`tel:${phone}`, '_self');
        }
    };
    
    window.visitWebsite = function(website) {
        if (website) {
            window.open(website, '_blank');
        }
    };
    
    // Initialize the map
    initMap();
});
</script>
@endpush
