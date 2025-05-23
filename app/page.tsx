import Link from "next/link"
import { ArrowRight, Droplet, MapPin, Search, Users } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"

export default function Home() {
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
              <Button variant="outline" className="hidden sm:flex">
                Login
              </Button>
            </Link>
            <Link href="/register">
              <Button className="bg-red-600 hover:bg-red-700">Register</Button>
            </Link>
          </div>
        </div>
      </header>
      <main className="flex-1">
        <section className="bg-gradient-to-b from-red-50 to-white py-20">
          <div className="container flex flex-col items-center text-center">
            <h1 className="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl">
              Synchronize Lives, <span className="text-red-600">Save Together</span>
            </h1>
            <p className="mt-6 max-w-2xl text-lg text-gray-600">
              BLOODSYNCE connects blood donors with those in need. Join our network and help save lives in your
              community through synchronized blood donation.
            </p>
            <div className="mt-10 flex flex-wrap justify-center gap-4">
              <Link href="/register">
                <Button className="bg-red-600 hover:bg-red-700">
                  Become a Donor
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </Link>
              <Link href="/find-blood">
                <Button variant="outline">
                  Find Blood
                  <Search className="ml-2 h-4 w-4" />
                </Button>
              </Link>
            </div>
          </div>
        </section>

        <section className="py-16">
          <div className="container">
            <h2 className="mb-12 text-center text-3xl font-bold">How BLOODSYNCE Works</h2>
            <div className="grid gap-8 md:grid-cols-3">
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Users className="h-5 w-5 text-red-600" />
                    Register & Sync
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription>
                    Create your profile with blood type and location. Join our synchronized network of life-savers.
                  </CardDescription>
                </CardContent>
              </Card>
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <MapPin className="h-5 w-5 text-red-600" />
                    Connect & Find
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription>
                    Search for compatible donors or blood banks in your area using our advanced matching system.
                  </CardDescription>
                </CardContent>
              </Card>
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Droplet className="h-5 w-5 text-red-600" />
                    Donate & Save
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription>
                    Respond to requests and coordinate donations. Every drop counts in our synchronized effort.
                  </CardDescription>
                </CardContent>
              </Card>
            </div>
          </div>
        </section>

        <section className="bg-red-50 py-16">
          <div className="container text-center">
            <h2 className="mb-4 text-3xl font-bold">Ready to Save Lives?</h2>
            <p className="mb-8 text-lg text-gray-600">Join thousands of donors in the BLOODSYNCE network</p>
            <div className="flex flex-wrap justify-center gap-4">
              <Link href="/register">
                <Button size="lg" className="bg-red-600 hover:bg-red-700">
                  Register Now
                </Button>
              </Link>
              <Link href="/find-blood">
                <Button size="lg" variant="outline">
                  Find Blood
                </Button>
              </Link>
              <Link href="/dashboard">
                <Button size="lg" variant="outline">
                  Donate Blood
                </Button>
              </Link>
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
