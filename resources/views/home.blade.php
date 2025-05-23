@extends('layouts.app')

@section('content')
<div class="flex min-h-screen flex-col">
    <main class="flex-1">
        <section class="bg-gradient-to-b from-red-50 to-white py-20">
            <div class="container mx-auto flex flex-col items-center text-center px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl">
                    Synchronize Lives, <span class="text-red-600">Save Together</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg text-gray-600">
                    BLOODSYNCE connects blood donors with those in need. Join our network and help save lives in your
                    community through synchronized blood donation.
                </p>
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                        Become a Donor
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('find-blood') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Find Blood
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="mb-12 text-center text-3xl font-bold">How BLOODSYNCE Works</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <h3 class="text-lg font-medium">Register & Sync</h3>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Create your profile with blood type and location. Join our synchronized network of life-savers.
                        </p>
                    </div>
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <h3 class="text-lg font-medium">Connect & Find</h3>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Search for compatible donors or blood banks in your area using our advanced matching system.
                        </p>
                    </div>
                    <div class="rounded-lg border bg-white p-6 shadow-sm">
                        <div class="mb-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v6m0 0v14m0-14l4-4m-4 4L8 4"></path>
                                </svg>
                                <h3 class="text-lg font-medium">Donate & Save</h3>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Respond to requests and coordinate donations. Every drop counts in our synchronized effort.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-red-50 py-16">
            <div class="container mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="mb-4 text-3xl font-bold">Ready to Save Lives?</h2>
                <p class="mb-8 text-lg text-gray-600">Join thousands of donors in the BLOODSYNCE network</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-red-700">
                        Register Now
                    </a>
                    <a href="{{ route('find-blood') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Find Blood
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Donate Blood
                    </a>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
