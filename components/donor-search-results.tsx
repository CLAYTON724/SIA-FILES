"use client"

import Link from "next/link"
import { MapPin, MessageSquare, Phone } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"

interface DonorSearchResultsProps {
  query?: string
}

export function DonorSearchResults({ query = "" }: DonorSearchResultsProps) {
  // Mock data - in a real app, this would come from an API
  const donors = [
    {
      id: 1,
      name: "Maria Santos",
      bloodType: "A+",
      location: "Makati City",
      distance: "1.2 km",
      lastDonation: "2 months ago",
      available: true,
    },
    {
      id: 2,
      name: "Juan Dela Cruz",
      bloodType: "O-",
      location: "Quezon City",
      distance: "3.5 km",
      lastDonation: "5 months ago",
      available: true,
    },
    {
      id: 3,
      name: "Ana Reyes",
      bloodType: "B+",
      location: "Pasig City",
      distance: "4.8 km",
      lastDonation: "1 month ago",
      available: false,
    },
    {
      id: 4,
      name: "Miguel Ramos",
      bloodType: "AB+",
      location: "Taguig City",
      distance: "6.2 km",
      lastDonation: "3 months ago",
      available: true,
    },
  ]

  const filteredDonors = query
    ? donors.filter(
        (donor) =>
          donor.name.toLowerCase().includes(query.toLowerCase()) ||
          donor.location.toLowerCase().includes(query.toLowerCase()) ||
          donor.bloodType.toLowerCase().includes(query.toLowerCase()),
      )
    : donors

  return (
    <div className="space-y-4">
      {filteredDonors.length === 0 ? (
        <div className="rounded-lg border border-dashed p-8 text-center">
          <p className="text-gray-500">No donors found matching your criteria.</p>
          <Button variant="link" className="mt-2 text-red-600">
            Try adjusting your filters
          </Button>
        </div>
      ) : (
        filteredDonors.map((donor) => (
          <Card key={donor.id}>
            <CardContent className="p-4">
              <div className="flex items-start justify-between">
                <div className="flex items-start space-x-4">
                  <div className="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                    <span className="text-lg font-bold text-red-600">{donor.bloodType}</span>
                  </div>
                  <div>
                    <h3 className="font-medium">{donor.name}</h3>
                    <div className="mt-1 flex items-center text-sm text-gray-500">
                      <MapPin className="mr-1 h-3 w-3" />
                      {donor.location} ({donor.distance})
                    </div>
                    <div className="mt-2 flex flex-wrap gap-2">
                      <span className="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs">
                        Last donation: {donor.lastDonation}
                      </span>
                      {donor.available ? (
                        <span className="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">
                          Available
                        </span>
                      ) : (
                        <span className="inline-flex items-center rounded-full bg-amber-100 px-2 py-1 text-xs text-amber-800">
                          Unavailable
                        </span>
                      )}
                    </div>
                  </div>
                </div>
                <div className="flex gap-2">
                  <Button size="icon" variant="outline" className="h-8 w-8">
                    <MessageSquare className="h-4 w-4" />
                    <span className="sr-only">Message</span>
                  </Button>
                  <Button size="icon" variant="outline" className="h-8 w-8">
                    <Phone className="h-4 w-4" />
                    <span className="sr-only">Call</span>
                  </Button>
                  <Link href={`/donors/${donor.id}`}>
                    <Button size="sm" className="h-8 bg-red-600 hover:bg-red-700">
                      View Profile
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
