<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BloodBankController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/find-blood', [App\Http\Controllers\FindBloodController::class, 'index'])->name('find-blood');
Route::post('/find-blood/emergency', [App\Http\Controllers\FindBloodController::class, 'submitEmergencyRequest'])->name('find-blood.emergency')->middleware('auth');
Route::get('/find-donors', [DonorController::class, 'index'])->name('find-donors');
Route::get('/blood-banks', [BloodBankController::class, 'index'])->name('blood-banks');
Route::get('/map', function() {
    return view('map');
})->name('map');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'storeSetup'])->name('profile.setup.store');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/donations', [DashboardController::class, 'donations'])->name('donations');
    Route::get('/donations/new', [DashboardController::class, 'newDonation'])->name('donations.new');
    Route::post('/donations', [DashboardController::class, 'storeDonation'])->name('donations.store');
    Route::get('/requests', [DashboardController::class, 'requests'])->name('requests');
    Route::get('/requests/{id}', [DashboardController::class, 'showRequest'])->name('requests.show');
});
