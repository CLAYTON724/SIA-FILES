@extends('layouts.app')

@section('content')
<div class="container mx-auto flex h-screen items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-md rounded-lg border bg-white p-6 shadow-sm">
        <div class="space-y-1 text-center">
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v6m0 0v14m0-14l4-4m-4 4L8 4"></path>
                    </svg>
                    <span>BLOODSYNCE</span>
                </a>
            </div>
            <h2 class="text-2xl font-bold">Login to your account</h2>
            <p class="text-sm text-gray-600">Enter your email and password to login</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-red-600 hover:underline">
                        Forgot password?
                    </a>
                </div>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                @error('password')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>
            
            <div>
                <button type="submit" class="w-full rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Login
                </button>
            </div>
            
            <div class="text-center text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-red-600 hover:underline">
                    Register
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
