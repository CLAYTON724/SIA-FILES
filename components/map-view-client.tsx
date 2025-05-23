"use client"

import { useEffect, useState } from "react"
import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet"
import L from "leaflet"
import { Button } from "@/components/ui/button"

// Fix Leaflet icon issues
const fixLeafletIcon = () => {
  // Fix the default icon issue in Leaflet
  delete L.Icon.Default.prototype._getIconUrl
  L.Icon.Default.mergeOptions({
    iconRetinaUrl: "https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png",
    iconUrl: "https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png",
    shadowUrl: "https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png",
  })
}

// Custom icons
const createCustomIcon = (color: string, type: "donor" | "bank") => {
  return L.divIcon({
    className: "custom-icon",
    html: `<div style="background-color: ${color}; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              ${
                type === "donor"
                  ? '<path d="M12 2v6m0 0v14m0-14l4-4m-4 4L8 4"></path>'
                  : '<path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"></path><path d="M1 21h22"></path><path d="M7 10.5h10"></path><path d="M7 15.5h10"></path>'
              }
            </svg>
          </div>`,
    iconSize: [30, 30],
    iconAnchor: [15, 15],
  })
}

// Mock data for donors
const donorData = [
  {
    id: 1,
    name: "Maria Santos",
    bloodType: "A+",
    location: "Makati City",
    position: [14.5547, 121.0244], // [lat, lng]
    lastDonation: "2 months ago",
    available: true,
  },
  {
    id: 2,
    name: "Juan Dela Cruz",
    bloodType: "O-",
    location: "Quezon City",
    position: [14.676, 121.0437],
    lastDonation: "5 months ago",
    available: true,
  },
  {
    id: 3,
    name: "Ana Reyes",
    bloodType: "B+",
    location: "Pasig City",
    position: [14.5764, 121.0851],
    lastDonation: "1 month ago",
    available: false,
  },
  {
    id: 4,
    name: "Miguel Ramos",
    bloodType: "AB+",
    location: "Taguig City",
    position: [14.5176, 121.0509],
    lastDonation: "3 months ago",
    available: true,
  },
]

// Mock data for blood banks
const bloodBankData = [
  {
    id: 1,
    name: "Philippine Red Cross Blood Center",
    location: "Mandaluyong City",
    position: [14.5794, 121.0359],
    hours: "8:00 AM - 5:00 PM",
    phone: "+63 2 8527 0000",
    availableTypes: ["A+", "A-", "B+", "O+", "O-"],
  },
  {
    id: 2,
    name: "St. Luke's Medical Center Blood Bank",
    location: "Quezon City",
    position: [14.6262, 121.0185],
    hours: "24 hours",
    phone: "+63 2 8723 0101",
    availableTypes: ["A+", "AB+", "B+", "O+"],
  },
  {
    id: 3,
    name: "Philippine General Hospital Blood Bank",
    location: "Manila",
    position: [14.5796, 120.9826],
    hours: "7:00 AM - 7:00 PM",
    phone: "+63 2 8554 8400",
    availableTypes: ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
  },
]

interface MapViewProps {
  type: "donors" | "banks"
}

export function MapView({ type }: MapViewProps) {
  const [userLocation, setUserLocation] = useState<[number, number] | null>(null)
  const defaultCenter: [number, number] = [14.5995, 121.0365] // Manila, Philippines

  useEffect(() => {
    // Fix Leaflet icon issues
    fixLeafletIcon()

    // Get user's location if available
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          setUserLocation([position.coords.latitude, position.coords.longitude])
        },
        (error) => {
          console.error("Error getting location:", error)
        },
      )
    }
  }, [])

  const data = type === "donors" ? donorData : bloodBankData
  const center = userLocation || defaultCenter

  return (
    <div className="relative h-[400px] w-full overflow-hidden rounded-lg border">
      <MapContainer center={center} zoom={12} style={{ height: "100%", width: "100%" }} scrollWheelZoom={false}>
        <TileLayer
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />

        {/* User location marker */}
        {userLocation && (
          <Marker
            position={userLocation}
            icon={L.divIcon({
              className: "custom-icon",
              html: `<div style="background-color: #3b82f6; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                      <div style="width: 8px; height: 8px; background-color: white; border-radius: 50%;"></div>
                    </div>`,
              iconSize: [24, 24],
              iconAnchor: [12, 12],
            })}
          >
            <Popup>
              <div className="p-1 text-center">
                <p className="font-medium">Your Location</p>
              </div>
            </Popup>
          </Marker>
        )}

        {/* Render markers based on type */}
        {data.map((item) => (
          <Marker
            key={item.id}
            position={item.position as [number, number]}
            icon={createCustomIcon(type === "donors" ? "#dc2626" : "#7c3aed", type === "donors" ? "donor" : "bank")}
          >
            <Popup>
              <div className="p-1">
                <h3 className="font-medium">{item.name}</h3>
                <p className="text-sm text-gray-500">{item.location}</p>
                {type === "donors" ? (
                  <>
                    <div className="mt-1 flex items-center gap-1">
                      <span className="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                        {(item as (typeof donorData)[0]).bloodType}
                      </span>
                      <span className="text-xs text-gray-500">
                        Last donation: {(item as (typeof donorData)[0]).lastDonation}
                      </span>
                    </div>
                    <Button size="sm" className="mt-2 h-7 w-full bg-red-600 text-xs hover:bg-red-700">
                      Contact Donor
                    </Button>
                  </>
                ) : (
                  <>
                    <p className="text-xs text-gray-500">{(item as (typeof bloodBankData)[0]).hours}</p>
                    <div className="mt-1 flex flex-wrap gap-1">
                      {(item as (typeof bloodBankData)[0]).availableTypes.map((type) => (
                        <span
                          key={type}
                          className="rounded-full bg-red-50 px-1.5 py-0.5 text-xs font-medium text-red-700"
                        >
                          {type}
                        </span>
                      ))}
                    </div>
                    <Button size="sm" className="mt-2 h-7 w-full bg-red-600 text-xs hover:bg-red-700">
                      View Details
                    </Button>
                  </>
                )}
              </div>
            </Popup>
          </Marker>
        ))}
      </MapContainer>

      <div className="absolute bottom-4 left-4 right-4 rounded-lg bg-white p-3 shadow-lg">
        <p className="font-medium">
          {type === "donors" ? `${donorData.length} blood donors found` : `${bloodBankData.length} blood banks found`}
        </p>
        <p className="text-sm text-gray-500">
          Zoom in or move the map to see more {type === "donors" ? "donors" : "blood banks"}
        </p>
      </div>
    </div>
  )
}
