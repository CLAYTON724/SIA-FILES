"use client"

import { useState } from "react"
import Link from "next/link"
import { Droplet, Search } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { DonorSearchResults } from "@/components/donor-search-results"
import { DynamicMap } from "@/components/dynamic-map"
import { SearchFilters } from "@/components/search-filters"

export default function FindDonorsPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [showMap, setShowMap] = useState(false)

  return (
    <div className="flex min-h-screen flex-col">
      <header className="sticky top-0 z-10 bg-white shadow-sm">
        <div className="container flex h-16 items-center justify-between">
          <Link href="/" className="flex items-center gap-2 text-xl font-bold text-red-600">
            <Droplet className="h-6 w-6" />
            <span>BLOODSYNCE</span>
          </Link>
          <nav className="hidden md:flex items-center gap-6">
            <Link href="/find-donors" className="text-sm font-medium text-red-600">
              Find Donors
            </Link>
            <Link href="/blood-banks" className="text-sm font-medium hover:text-red-600">
              Blood Banks
            </Link>
            <Link href="/about" className="text-sm font-medium hover:text-red-600">
              About
            </Link>
            <Link href="/contact" className="text-sm font-medium hover:text-red-600">
              Contact
            </Link>
          </nav>
          <div className="flex items-center gap-4">
            <Link href="/login">
              <Button variant="outline">Login</Button>
            </Link>
            <Link href="/register">
              <Button className="bg-red-600 hover:bg-red-700">Register</Button>
            </Link>
          </div>
        </div>
      </header>

      <main className="flex-1 bg-gray-50 py-8">
        <div className="container">
          <div className="mb-8">
            <h1 className="text-3xl font-bold">Find Blood Donors</h1>
            <p className="text-gray-500">Connect with verified blood donors in your area</p>
          </div>

          <div className="grid gap-8 md:grid-cols-3">
            <div className="md:col-span-2">
              <Card>
                <CardHeader>
                  <div className="flex items-center justify-between">
                    <div>
                      <CardTitle>Blood Donors</CardTitle>
                      <CardDescription>Find compatible donors near you</CardDescription>
                    </div>
                    <div className="flex gap-2">
                      <Button
                        variant={!showMap ? "default" : "outline"}
                        onClick={() => setShowMap(false)}
                        className={!showMap ? "bg-red-600 hover:bg-red-700" : ""}
                      >
                        List View
                      </Button>
                      <Button
                        variant={showMap ? "default" : "outline"}
                        onClick={() => setShowMap(true)}
                        className={showMap ? "bg-red-600 hover:bg-red-700" : ""}
                      >
                        Map View
                      </Button>
                    </div>
                  </div>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    <div className="relative">
                      <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                      <Input
                        placeholder="Search by name, location, or blood type..."
                        className="pl-10"
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                      />
                    </div>
                    <SearchFilters />
                    {showMap ? <DynamicMap type="donors" /> : <DonorSearchResults query={searchQuery} />}
                  </div>
                </CardContent>
              </Card>
            </div>

            <div>
              <Card>
                <CardHeader>
                  <CardTitle>Quick Stats</CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    <div className="text-center">
                      <div className="text-2xl font-bold text-red-600">1,247</div>
                      <div className="text-sm text-gray-500">Active Donors</div>
                    </div>
                    <div className="text-center">
                      <div className="text-2xl font-bold text-red-600">89</div>
                      <div className="text-sm text-gray-500">Available Today</div>
                    </div>
                    <div className="text-center">
                      <div className="text-2xl font-bold text-red-600">15</div>
                      <div className="text-sm text-gray-500">Within 5km</div>
                    </div>
                  </div>
                </CardContent>
              </Card>

              <Card className="mt-4">
                <CardHeader>
                  <CardTitle>Need Help?</CardTitle>
                </CardHeader>
                <CardContent>
                  <p className="text-sm text-gray-600 mb-4">
                    Can't find a compatible donor? Contact our emergency hotline for immediate assistance.
                  </p>
                  <Button className="w-full bg-red-600 hover:bg-red-700">Emergency Hotline</Button>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </main>

      <footer className="border-t bg-gray-50 py-8">
        <div className="container text-center text-sm text-gray-500">
          <p>© 2024 BLOODSYNCE.com. All rights reserved. | Synchronizing lives, one donation at a time.</p>
        </div>
      </footer>
    </div>
  )
}
