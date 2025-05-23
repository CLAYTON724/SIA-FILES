@extends('layouts.app')

@section('content')
<div class="container mx-auto flex min-h-screen items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
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
            <h2 class="text-2xl font-bold">Create an account</h2>
            <p class="text-sm text-gray-600">Enter your information to create an account</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="firstName" class="text-sm font-medium text-gray-700">First name</label>
                    <input id="firstName" name="firstName" type="text" value="{{ old('firstName') }}" required autofocus
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('firstName')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="lastName" class="text-sm font-medium text-gray-700">Last name</label>
                    <input id="lastName" name="lastName" type="text" value="{{ old('lastName') }}" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    @error('lastName')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label for="phone" class="text-sm font-medium text-gray-700">Phone number</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                @error('phone')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label for="bloodType" class="text-sm font-medium text-gray-700">Blood type</label>
                <select id="bloodType" name="bloodType" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    <option value="" disabled {{ old('bloodType') ? '' : 'selected' }}>Select blood type</option>
                    <option value="a-positive" {{ old('bloodType') == 'a-positive' ? 'selected' : '' }}>A+</option>
                    <option value="a-negative" {{ old('bloodType') == 'a-negative' ? 'selected' : '' }}>A-</option>
                    <option value="b-positive" {{ old('bloodType') == 'b-positive' ? 'selected' : '' }}>B+</option>
                    <option value="b-negative" {{ old('bloodType') == 'b-negative' ? 'selected' : '' }}>B-</option>
                    <option value="ab-positive" {{ old('bloodType') == 'ab-positive' ? 'selected' : '' }}>AB+</option>
                    <option value="ab-negative" {{ old('bloodType') == 'ab-negative' ? 'selected' : '' }}>AB-</option>
                    <option value="o-positive" {{ old('bloodType') == 'o-positive' ? 'selected' : '' }}>O+</option>
                    <option value="o-negative" {{ old('bloodType') == 'o-negative' ? 'selected' : '' }}>O-</option>
                    <option value="unknown" {{ old('bloodType') == 'unknown' ? 'selected' : '' }}>I don't know</option>
                </select>
                @error('bloodType')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                @error('password')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
            </div>
            
            <div>
                <button type="submit" class="w-full rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Create account
                </button>
            </div>
            
            <div class="text-center text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-red-600 hover:underline">
                    Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
