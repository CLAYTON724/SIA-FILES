"use client"

import type React from "react"

import { useState } from "react"
import Link from "next/link"
import { Droplet, Mail, MapPin, Phone, Send } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"

export default function ContactPage() {
  const [isSubmitting, setIsSubmitting] = useState(false)
  const [submitted, setSubmitted] = useState(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setIsSubmitting(true)

    // Simulate form submission
    setTimeout(() => {
      setIsSubmitting(false)
      setSubmitted(true)
    }, 1500)
  }

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
            <Link href="/contact" className="text-sm font-medium text-red-600">
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
                Contact <span className="text-red-600">BLOODSYNCE</span>
              </h1>
              <p className="mt-6 text-lg text-gray-600">
                Have questions? Need support? We're here to help you save lives.
              </p>
            </div>
          </div>
        </section>

        <section className="py-16">
          <div className="container">
            <div className="grid gap-12 lg:grid-cols-2">
              <div>
                <h2 className="text-3xl font-bold">Get in Touch</h2>
                <p className="mt-4 text-gray-600">
                  Our team is available 24/7 to assist with urgent blood requests and provide support for our platform
                  users.
                </p>

                <div className="mt-8 space-y-6">
                  <div className="flex items-start gap-4">
                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100">
                      <Phone className="h-5 w-5 text-red-600" />
                    </div>
                    <div>
                      <h3 className="font-medium">Emergency Hotline</h3>
                      <p className="text-gray-600">+63 2 8888 BLOOD (25663)</p>
                      <p className="text-sm text-gray-500">Available 24/7 for urgent requests</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100">
                      <Mail className="h-5 w-5 text-red-600" />
                    </div>
                    <div>
                      <h3 className="font-medium">Email Support</h3>
                      <p className="text-gray-600">support@bloodsynce.com</p>
                      <p className="text-sm text-gray-500">Response within 2 hours</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4">
                    <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100">
                      <MapPin className="h-5 w-5 text-red-600" />
                    </div>
                    <div>
                      <h3 className="font-medium">Headquarters</h3>
                      <p className="text-gray-600">
                        BLOODSYNCE Center
                        <br />
                        123 Lifeline Avenue
                        <br />
                        Makati City, Metro Manila 1200
                        <br />
                        Philippines
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <Card>
                <CardHeader>
                  <CardTitle>Send us a Message</CardTitle>
                  <CardDescription>
                    Fill out the form below and we'll get back to you as soon as possible.
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  {submitted ? (
                    <div className="text-center py-8">
                      <div className="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <Send className="h-6 w-6 text-green-600" />
                      </div>
                      <h3 className="text-lg font-medium">Message Sent!</h3>
                      <p className="text-gray-600">We'll get back to you within 2 hours.</p>
                      <Button onClick={() => setSubmitted(false)} variant="outline" className="mt-4">
                        Send Another Message
                      </Button>
                    </div>
                  ) : (
                    <form onSubmit={handleSubmit} className="space-y-4">
                      <div className="grid grid-cols-2 gap-4">
                        <div className="space-y-2">
                          <Label htmlFor="first-name">First name</Label>
                          <Input id="first-name" required />
                        </div>
                        <div className="space-y-2">
                          <Label htmlFor="last-name">Last name</Label>
                          <Input id="last-name" required />
                        </div>
                      </div>
                      <div className="space-y-2">
                        <Label htmlFor="email">Email</Label>
                        <Input id="email" type="email" required />
                      </div>
                      <div className="space-y-2">
                        <Label htmlFor="subject">Subject</Label>
                        <Input id="subject" required />
                      </div>
                      <div className="space-y-2">
                        <Label htmlFor="message">Message</Label>
                        <Textarea id="message" rows={4} required />
                      </div>
                      <Button type="submit" className="w-full bg-red-600 hover:bg-red-700" disabled={isSubmitting}>
                        {isSubmitting ? "Sending..." : "Send Message"}
                        <Send className="ml-2 h-4 w-4" />
                      </Button>
                    </form>
                  )}
                </CardContent>
              </Card>
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
