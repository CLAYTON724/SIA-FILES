"use client"

import Link from "next/link"
import { Clock, ExternalLink, MapPin, Phone } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"

interface BloodBankSearchResultsProps {
  query?: string
}

export function BloodBankSearchResults({ query = "" }: BloodBankSearchResultsProps) {
  // Mock data - in a real app, this would come from an API
  const bloodBanks = [
    {
      id: 1,
      name: "Philippine Red Cross Blood Center",
      location: "Mandaluyong City",
      distance: "2.3 km",
      hours: "8:00 AM - 5:00 PM",
      phone: "+63 2 8527 0000",
      website: "https://redcross.org.ph",
      availableTypes: ["A+", "A-", "B+", "O+", "O-"],
    },
    {
      id: 2,
      name: "St. Luke's Medical Center Blood Bank",
      location: "Quezon City",
      distance: "4.1 km",
      hours: "24 hours",
      phone: "+63 2 8723 0101",
      website: "https://stlukes.com.ph",
      availableTypes: ["A+", "AB+", "B+", "O+"],
    },
    {
      id: 3,
      name: "Philippine General Hospital Blood Bank",
      location: "Manila",
      distance: "5.7 km",
      hours: "7:00 AM - 7:00 PM",
      phone: "+63 2 8554 8400",
      website: "https://pgh.gov.ph",
      availableTypes: ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
    },
  ]

  const filteredBloodBanks = query
    ? bloodBanks.filter(
        (bank) =>
          bank.name.toLowerCase().includes(query.toLowerCase()) ||
          bank.location.toLowerCase().includes(query.toLowerCase()),
      )
    : bloodBanks

  return (
    <div className="space-y-4">
      {filteredBloodBanks.length === 0 ? (
        <div className="rounded-lg border border-dashed p-8 text-center">
          <p className="text-gray-500">No blood banks found matching your criteria.</p>
          <Button variant="link" className="mt-2 text-red-600">
            Try adjusting your filters
          </Button>
        </div>
      ) : (
        filteredBloodBanks.map((bank) => (
          <Card key={bank.id}>
            <CardContent className="p-4">
              <div className="flex flex-col space-y-4 md:flex-row md:items-start md:justify-between md:space-y-0">
                <div>
                  <h3 className="font-medium">{bank.name}</h3>
                  <div className="mt-1 flex items-center text-sm text-gray-500">
                    <MapPin className="mr-1 h-3 w-3" />
                    {bank.location} ({bank.distance})
                  </div>
                  <div className="mt-1 flex items-center text-sm text-gray-500">
                    <Clock className="mr-1 h-3 w-3" />
                    {bank.hours}
                  </div>
                  <div className="mt-2">
                    <p className="text-xs text-gray-500">Available blood types:</p>
                    <div className="mt-1 flex flex-wrap gap-1">
                      {bank.availableTypes.map((type) => (
                        <span
                          key={type}
                          className="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700"
                        >
                          {type}
                        </span>
                      ))}
                    </div>
                  </div>
                </div>
                <div className="flex flex-wrap gap-2">
                  <Button size="sm" variant="outline" className="h-8">
                    <Phone className="mr-1 h-3 w-3" />
                    Call
                  </Button>
                  <Button size="sm" variant="outline" className="h-8">
                    <ExternalLink className="mr-1 h-3 w-3" />
                    Website
                  </Button>
                  <Link href={`/blood-banks/${bank.id}`}>
                    <Button size="sm" className="h-8 bg-red-600 hover:bg-red-700">
                      View Details
                    </Button>
                  </Link>
                </div>
              </div>
            </CardContent>
          </Card>
        ))
      )}
    </div>
  )
}
