"use client"

import { Input } from "@/components/ui/input"

import { useState, useEffect } from "react"
import Link from "next/link"
import { Droplet, Menu, MessageSquare, Search, User } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { BloodBankSearchResults } from "@/components/blood-bank-search-results"
import { DonorSearchResults } from "@/components/donor-search-results"
import { DynamicMap } from "@/components/dynamic-map"
import { SearchFilters } from "@/components/search-filters"
import { NotificationsDropdown } from "@/components/notifications-dropdown"

export default function DashboardPage() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
  const [searchQuery, setSearchQuery] = useState("")
  const [showMap, setShowMap] = useState(false)
  const [notifications, setNotifications] = useState([])
  const [unreadCount, setUnreadCount] = useState(0)

  useEffect(() => {
    const fetchNotifications = async () => {
      try {
        const response = await fetch("/api/notifications?userId=1")
        const data = await response.json()
        setNotifications(data.notifications)
        setUnreadCount(data.notifications.filter((n) => !n.isRead).length)
      } catch (error) {
        console.error("Failed to fetch notifications:", error)
      }
    }

    fetchNotifications()
  }, [])

  return (
    <div className="flex min-h-screen flex-col">
      <header className="sticky top-0 z-10 bg-white shadow-sm">
        <div className="container flex h-16 items-center justify-between">
          <div className="flex items-center gap-2">
            <Sheet>
              <SheetTrigger asChild>
                <Button variant="ghost" size="icon" className="md:hidden">
                  <Menu className="h-5 w-5" />
                  <span className="sr-only">Toggle menu</span>
                </Button>
              </SheetTrigger>
              <SheetContent side="left" className="w-64">
                <div className="flex items-center gap-2 pb-8 pt-4">
                  <Droplet className="h-5 w-5 text-red-600" />
                  <span className="text-lg font-bold">BLOODSYNCE</span>
                </div>
                <nav className="flex flex-col gap-4">
                  <Link href="/dashboard" className="flex items-center gap-2 text-sm font-medium">
                    Dashboard
                  </Link>
                  <Link href="/search" className="flex items-center gap-2 text-sm font-medium">
                    Find Blood
                  </Link>
                  <Link href="/donations" className="flex items-center gap-2 text-sm font-medium">
                    My Donations
                  </Link>
                  <Link href="/requests" className="flex items-center gap-2 text-sm font-medium">
                    Requests
                  </Link>
                  <Link href="/profile" className="flex items-center gap-2 text-sm font-medium">
                    Profile
                  </Link>
                  <Link href="/settings" className="flex items-center gap-2 text-sm font-medium">
                    Settings
                  </Link>
                  <Link href="/logout" className="flex items-center gap-2 text-sm font-medium text-red-600">
                    Logout
                  </Link>
                </nav>
              </SheetContent>
            </Sheet>
            <Link href="/" className="flex items-center gap-2 text-xl font-bold text-red-600">
              <Droplet className="h-6 w-6" />
              <span>BLOODSYNCE</span>
            </Link>
          </div>
          <div className="flex items-center gap-4">
            <NotificationsDropdown />
            <Button variant="ghost" size="icon">
              <MessageSquare className="h-5 w-5" />
              <span className="sr-only">Messages</span>
            </Button>
            <Link href="/profile">
              <Button variant="ghost" size="icon" className="rounded-full">
                <User className="h-5 w-5" />
                <span className="sr-only">Profile</span>
              </Button>
            </Link>
          </div>
        </div>
      </header>
      <main className="flex-1 bg-gray-50 py-8">
        <div className="container">
          <div className="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
              <h1 className="text-3xl font-bold">Dashboard</h1>
              <p className="text-gray-500">Find blood donors and blood banks near you</p>
            </div>
            <div className="flex gap-2">
              <Button
                variant={showMap ? "default" : "outline"}
                onClick={() => setShowMap(true)}
                className={showMap ? "bg-red-600 hover:bg-red-700" : ""}
              >
                Map View
              </Button>
              <Button
                variant={!showMap ? "default" : "outline"}
                onClick={() => setShowMap(false)}
                className={!showMap ? "bg-red-600 hover:bg-red-700" : ""}
              >
                List View
              </Button>
            </div>
          </div>

          <div className="grid gap-8 md:grid-cols-3">
            <div className="md:col-span-2">
              <Card>
                <CardHeader>
                  <CardTitle>Search</CardTitle>
                  <CardDescription>Find blood donors and blood banks near you</CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    <div className="relative">
                      <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                      <Input
                        placeholder="Search by location, blood type, or name..."
                        className="pl-10"
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                      />
                    </div>
                    <SearchFilters />

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
                  </div>
                </CardContent>
              </Card>
            </div>
            <div>
              <Card>
                <CardHeader>
                  <CardTitle>Your Profile</CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="flex flex-col items-center space-y-4 text-center">
                    <div className="relative h-20 w-20 rounded-full bg-red-100">
                      <span className="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-2xl font-bold text-red-600">
                        A+
                      </span>
                    </div>
                    <div>
                      <h3 className="text-lg font-medium">John Doe</h3>
                      <p className="text-sm text-gray-500">Manila, Philippines</p>
                    </div>
                    <div className="grid w-full grid-cols-2 gap-2 text-center">
                      <div className="rounded-lg bg-gray-100 p-2">
                        <p className="text-xs text-gray-500">Last Donation</p>
                        <p className="font-medium">3 months ago</p>
                      </div>
                      <div className="rounded-lg bg-gray-100 p-2">
                        <p className="text-xs text-gray-500">Total Donations</p>
                        <p className="font-medium">5</p>
                      </div>
                    </div>
                    <div className="w-full space-y-2">
                      <Link href="/profile">
                        <Button variant="outline" className="w-full">
                          Edit Profile
                        </Button>
                      </Link>
                      <Link href="/donations/new">
                        <Button className="w-full bg-red-600 hover:bg-red-700">Record Donation</Button>
                      </Link>
                    </div>
                  </div>
                </CardContent>
              </Card>

              <Card className="mt-4">
                <CardHeader>
                  <CardTitle>Nearby Requests</CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    <div className="rounded-lg border p-3">
                      <div className="flex justify-between">
                        <div className="font-medium">A+ Blood Needed</div>
                        <div className="text-sm font-medium text-red-600">Urgent</div>
                      </div>
                      <div className="mt-1 text-sm text-gray-500">Philippine General Hospital</div>
                      <div className="mt-2 flex justify-between">
                        <div className="text-xs text-gray-500">2.5 km away</div>
                        <Link href="/requests/1">
                          <Button variant="link" className="h-auto p-0 text-xs text-red-600">
                            View details
                          </Button>
                        </Link>
                      </div>
                    </div>
                    <div className="rounded-lg border p-3">
                      <div className="flex justify-between">
                        <div className="font-medium">O- Blood Needed</div>
                        <div className="text-sm font-medium text-amber-600">Medium</div>
                      </div>
                      <div className="mt-1 text-sm text-gray-500">St. Luke's Medical Center</div>
                      <div className="mt-2 flex justify-between">
                        <div className="text-xs text-gray-500">4.8 km away</div>
                        <Link href="/requests/2">
                          <Button variant="link" className="h-auto p-0 text-xs text-red-600">
                            View details
                          </Button>
                        </Link>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </main>
    </div>
  )
}
