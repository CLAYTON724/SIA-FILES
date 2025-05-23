import Link from "next/link"
import { Droplet, Heart, Shield, Users, Zap } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"

export default function AboutPage() {
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
            <Link href="/about" className="text-sm font-medium text-red-600">
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

      <main className="flex-1">
        <section className="bg-gradient-to-b from-red-50 to-white py-20">
          <div className="container">
            <div className="mx-auto max-w-3xl text-center">
              <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">
                About <span className="text-red-600">BLOODSYNCE</span>
              </h1>
              <p className="mt-6 text-lg text-gray-600">
                We're revolutionizing blood donation by creating a synchronized network that connects donors,
                recipients, and blood banks in real-time.
              </p>
            </div>
          </div>
        </section>

        <section className="py-16">
          <div className="container">
            <div className="grid gap-12 lg:grid-cols-2">
              <div>
                <h2 className="text-3xl font-bold">Our Mission</h2>
                <p className="mt-4 text-gray-600">
                  BLOODSYNCE was founded with a simple yet powerful mission: to save lives by making blood donation more
                  accessible, efficient, and connected. We believe that by synchronizing the efforts of donors,
                  recipients, and medical institutions, we can create a world where no one dies due to blood shortage.
                </p>
                <p className="mt-4 text-gray-600">
                  Our platform leverages technology to bridge the gap between those who can give and those who need,
                  creating a seamless ecosystem of life-saving connections.
                </p>
              </div>
              <div className="flex items-center justify-center">
                <div className="relative">
                  <div className="h-64 w-64 rounded-full bg-red-100 flex items-center justify-center">
                    <Heart className="h-32 w-32 text-red-600" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section className="bg-gray-50 py-16">
          <div className="container">
            <h2 className="mb-12 text-center text-3xl font-bold">Why Choose BLOODSYNCE?</h2>
            <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Zap className="h-5 w-5 text-red-600" />
                    Real-time Matching
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription>
                    Our advanced algorithm instantly matches blood requests with compatible donors in your area,
                    ensuring rapid response times.
                  </CardDescription>
                </CardContent>
              </Card>
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Shield className="h-5 w-5 text-red-600" />
                    Verified Network
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription>
                    All donors and blood banks are verified through our rigorous screening process, ensuring safety and
                    reliability.
                  </CardDescription>
                </CardContent>
              </Card>
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Users className="h-5 w-5 text-red-600" />
                    Community Driven
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <CardDescription>
                    Join a community of life-savers who are committed to helping others and making a difference in their
                    communities.
                  </CardDescription>
                </CardContent>
              </Card>
            </div>
          </div>
        </section>

        <section className="py-16">
          <div className="container">
            <h2 className="mb-12 text-center text-3xl font-bold">Our Impact</h2>
            <div className="grid gap-8 md:grid-cols-4">
              <div className="text-center">
                <div className="text-4xl font-bold text-red-600">10,000+</div>
                <div className="text-gray-600">Registered Donors</div>
              </div>
              <div className="text-center">
                <div className="text-4xl font-bold text-red-600">5,000+</div>
                <div className="text-gray-600">Lives Saved</div>
              </div>
              <div className="text-center">
                <div className="text-4xl font-bold text-red-600">500+</div>
                <div className="text-gray-600">Partner Blood Banks</div>
              </div>
              <div className="text-center">
                <div className="text-4xl font-bold text-red-600">50+</div>
                <div className="text-gray-600">Cities Covered</div>
              </div>
            </div>
          </div>
        </section>

        <section className="bg-red-600 py-16 text-white">
          <div className="container text-center">
            <h2 className="mb-4 text-3xl font-bold">Join the BLOODSYNCE Network</h2>
            <p className="mb-8 text-lg">Be part of the synchronized effort to save lives. Every donation matters.</p>
            <Link href="/register">
              <Button size="lg" variant="secondary">
                Get Started Today
              </Button>
            </Link>
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
