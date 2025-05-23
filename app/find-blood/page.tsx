"use client"

import { useState } from "react"
import Link from "next/link"
import { Droplet, Filter, Search, Zap } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { BloodBankSearchResults } from "@/components/blood-bank-search-results"
import { DonorSearchResults } from "@/components/donor-search-results"
import { DynamicMap } from "@/components/dynamic-map"

export default function FindBloodPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [showMap, setShowMap] = useState(false)
  const [urgencyLevel, setUrgencyLevel] = useState("critical")
  const [bloodType, setBloodType] = useState("a-positive")
  const [location, setLocation] = useState("manila")

  return (
    <div className="flex min-h-screen flex-col">
      <header className="sticky top-0 z-10 bg-white shadow-sm">
        <div className="container flex h-16 items-center justify-between">
          <Link href="/" className="flex items-center gap-2 text-xl font-bold text-red-600">
            <Droplet className="h-6 w-6" />
            <span>BLOODSYNCE</span>
          </Link>
          <nav className="hidden md:flex items-center gap-6">
            <Link href="/find-donors" className="text-sm font-medium hover:text-red-600">
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

      <main className="flex-1 bg-gray-50">
        <section className="bg-gradient-to-b from-red-50 to-white py-12">
          <div className="container">
            <div className="mx-auto max-w-3xl text-center">
              <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">
                Find <span className="text-red-600">Blood</span>
              </h1>
              <p className="mt-6 text-lg text-gray-600">
                Search for blood donors and blood banks in your area. Get connected instantly.
              </p>
            </div>
          </div>
        </section>

        <section className="py-8">
          <div className="container">
            {/* Emergency Request Card */}
            <Card className="mb-8 border-red-200 bg-red-50">
              <CardHeader>
                <CardTitle className="flex items-center gap-2 text-red-700">
                  <Zap className="h-5 w-5" />
                  Emergency Blood Request
                </CardTitle>
                <CardDescription>
                  Need blood urgently? Submit an emergency request to notify all compatible donors in your area.
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div className="grid gap-4 md:grid-cols-4">
                  <div>
                    <Label htmlFor="emergency-blood-type">Blood Type Needed</Label>
                    <Select>
                      <SelectTrigger id="emergency-blood-type">
                        <SelectValue placeholder="Select type" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="a-positive">A+</SelectItem>
                        <SelectItem value="a-negative">A-</SelectItem>
                        <SelectItem value="b-positive">B+</SelectItem>
                        <SelectItem value="b-negative">B-</SelectItem>
                        <SelectItem value="ab-positive">AB+</SelectItem>
                        <SelectItem value="ab-negative">AB-</SelectItem>
                        <SelectItem value="o-positive">O+</SelectItem>
                        <SelectItem value="o-negative">O-</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                  <div>
                    <Label htmlFor="emergency-location">Location</Label>
                    <Input id="emergency-location" placeholder="Enter location" />
                  </div>
                  <div>
                    <Label htmlFor="emergency-urgency">Urgency Level</Label>
                    <Select>
                      <SelectTrigger id="emergency-urgency">
                        <SelectValue placeholder="Select urgency" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="critical">Critical (0-2 hours)</SelectItem>
                        <SelectItem value="urgent">Urgent (2-6 hours)</SelectItem>
                        <SelectItem value="moderate">Moderate (6-24 hours)</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                  <div className="flex items-end">
                    <Button className="w-full bg-red-600 hover:bg-red-700">Submit Emergency Request</Button>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Search Section */}
            <div className="grid gap-8 lg:grid-cols-4">
              <div className="lg:col-span-1">
                <Card>
                  <CardHeader>
                    <CardTitle className="flex items-center gap-2">
                      <Filter className="h-5 w-5" />
                      Search Filters
                    </CardTitle>
                  </CardHeader>
                  <CardContent className="space-y-4">
                    <div>
                      <Label htmlFor="blood-type-filter">Blood Type</Label>
                      <Select value={bloodType} onValueChange={setBloodType}>
                        <SelectTrigger id="blood-type-filter">
                          <SelectValue placeholder="Any blood type" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="">Any blood type</SelectItem>
                          <SelectItem value="a-positive">A+</SelectItem>
                          <SelectItem value="a-negative">A-</SelectItem>
                          <SelectItem value="b-positive">B+</SelectItem>
                          <SelectItem value="b-negative">B-</SelectItem>
                          <SelectItem value="ab-positive">AB+</SelectItem>
                          <SelectItem value="ab-negative">AB-</SelectItem>
                          <SelectItem value="o-positive">O+</SelectItem>
                          <SelectItem value="o-negative">O-</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div>
                      <Label htmlFor="location-filter">Location</Label>
                      <Select value={location} onValueChange={setLocation}>
                        <SelectTrigger id="location-filter">
                          <SelectValue placeholder="Select location" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="">All locations</SelectItem>
                          <SelectItem value="manila">Manila</SelectItem>
                          <SelectItem value="quezon">Quezon City</SelectItem>
                          <SelectItem value="makati">Makati</SelectItem>
                          <SelectItem value="pasig">Pasig</SelectItem>
                          <SelectItem value="taguig">Taguig</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <div>
                      <Label htmlFor="distance">Distance (km)</Label>
                      <Select>
                        <SelectTrigger id="distance">
                          <SelectValue placeholder="Any distance" />
                        </SelectTrigger>
                        <SelectContent>
                          <SelectItem value="5">Within 5 km</SelectItem>
                          <SelectItem value="10">Within 10 km</SelectItem>
                          <SelectItem value="25">Within 25 km</SelectItem>
                          <SelectItem value="50">Within 50 km</SelectItem>
                        </SelectContent>
                      </Select>
                    </div>
                    <Button className="w-full bg-red-600 hover:bg-red-700">Apply Filters</Button>
                  </CardContent>
                </Card>
              </div>

              <div className="lg:col-span-3">
                <Card>
                  <CardHeader>
                    <div className="flex items-center justify-between">
                      <div>
                        <CardTitle>Search Results</CardTitle>
                        <CardDescription>Find blood donors and blood banks near you</CardDescription>
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
                    <div className="mb-4">
                      <div className="relative">
                        <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <Input
                          placeholder="Search by name, location, or blood type..."
                          className="pl-10"
                          value={searchQuery}
                          onChange={(e) => setSearchQuery(e.target.value)}
                        />
                      </div>
                    </div>

                    <Tabs defaultValue="donors">
                      <TabsList className="grid w-full grid-cols-2">
                        <TabsTrigger value="donors">Blood Donors</TabsTrigger>
                        <TabsTrigger value="banks">Blood Banks</TabsTrigger>
                      </TabsList>
                      <TabsContent value="donors" className="mt-4">
                        {showMap ? <DynamicMap type="donors" /> : <DonorSearchResults query={searchQuery} />}
                      </TabsContent>
                      <TabsContent value="banks" className="mt-4">
                        {showMap ? <DynamicMap type="banks" /> : <BloodBankSearchResults query={searchQuery} />}
                      </TabsContent>
                    </Tabs>
                  </CardContent>
                </Card>
              </div>
            </div>
          </div>
        </section>
      </main>

      <footer className="border-t bg-gray-50 py-8">
        <div className="container text-center text-sm text-gray-500">
          <p>© 2024 BLOODSYNCE.com. All rights reserved. | Synchronizing lives, one donation at a time.</p>
        </div>
      </footer>
    </div>
  )
}
