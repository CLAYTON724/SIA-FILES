<header class="sticky top-0 z-10 bg-white shadow-sm">
    <div class="container mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v6m0 0v14m0-14l4-4m-4 4L8 4"></path>
                </svg>
                <span>BLOODSYNCE</span>
            </a>
        </div>
        
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('find-donors') }}" class="text-sm font-medium hover:text-red-600 {{ request()->routeIs('find-donors') ? 'text-red-600' : '' }}">
                Find Donors
            </a>
            <a href="{{ route('blood-banks') }}" class="text-sm font-medium hover:text-red-600 {{ request()->routeIs('blood-banks') ? 'text-red-600' : '' }}">
                Blood Banks
            </a>
            <a href="{{ route('map') }}" class="text-sm font-medium hover:text-red-600 {{ request()->routeIs('map') ? 'text-red-600' : '' }}">
                Map
            </a>
            <a href="{{ route('about') }}" class="text-sm font-medium hover:text-red-600 {{ request()->routeIs('about') ? 'text-red-600' : '' }}">
                About
            </a>
            <a href="{{ route('contact') }}" class="text-sm font-medium hover:text-red-600 {{ request()->routeIs('contact') ? 'text-red-600' : '' }}">
                Contact
            </a>
        </nav>
        
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="text-sm font-medium hover:text-red-600">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium hover:text-red-600">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-2 text-sm font-medium text-gray-900 shadow-sm hover:bg-gray-50">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                    Register
                </a>
            @endauth
        </div>
    </div>
</header>
