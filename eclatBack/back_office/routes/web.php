<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigLogoController;
use App\Http\Controllers\HeroContentController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\HeaderContactController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\NavbarBrandController;

Route::get('/', function () {
    return view('welcome');
});

// Login route for regular users (if needed)
Route::get('/login', function () {
    // For now, redirect to admin login
    return redirect()->route('admin.login');
})->name('login');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    
    // Registration routes
    Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AdminController::class, 'register'])->name('register.post');
    
    // Protected Admin Routes
    Route::middleware(['auth:admin'])->group(function () {
        // Use the new DashboardController for the dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password');
        Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password.update');
        
        // Logo Management Routes
        Route::resource('logos', ConfigLogoController::class);
        
        // Hero Content Management Routes
        Route::resource('hero_contents', HeroContentController::class)->parameters(['hero_contents' => 'heroContent']);
        
        // Hero Slides Management Routes
        Route::resource('hero-slides', HeroSlideController::class);
        
        // Services Management Routes
        Route::resource('services', ServiceController::class);
        
        // Pricing Plans Management Routes
        Route::resource('pricing_plans', PricingPlanController::class);
        
        // Blog Posts Management Routes
        Route::resource('blog_posts', BlogPostController::class);
        
        // Team Members Management Routes
        Route::resource('team_members', TeamMemberController::class);
        
        // Testimonials Management Routes
        Route::resource('testimonials', TestimonialController::class);
        
        // Appointments Management Routes
        Route::resource('appointments', AppointmentController::class);
        
        // Appointments Export Route
        Route::get('/appointments/export', [AppointmentController::class, 'export'])->name('appointments.export');
        
        // Appointments Import Route
        Route::post('/appointments/import', [AppointmentController::class, 'import'])->name('appointments.import');
        
        // Job Applications Management Routes
        Route::resource('job-applications', JobApplicationController::class);
        
        // Job Applications Status Update Route
        Route::patch('/job-applications/{jobApplication}/status', [JobApplicationController::class, 'updateStatus'])->name('job-applications.update-status');
        
        // Job Applications File Download Routes
        Route::get('/job-applications/{jobApplication}/cv', [JobApplicationController::class, 'downloadCv'])->name('job-applications.download-cv');
        Route::get('/job-applications/{jobApplication}/lettre-motivation', [JobApplicationController::class, 'downloadLettreMotivation'])->name('job-applications.download-lettre-motivation');
        
        // Sent Emails Management Routes
        Route::resource('sent-emails', SendMailController::class);
        
        // Email Configuration Routes
        Route::resource('email-configs', EmailConfigController::class);
        
        // Newsletter Subscribers Routes
        Route::resource('newsletter-subscribers', NewsletterSubscriberController::class);
        Route::delete('/newsletter-subscribers/bulk-delete', [NewsletterSubscriberController::class, 'bulkDelete'])->name('newsletter-subscribers.bulk-delete');
        Route::get('/newsletter-subscribers/export', [NewsletterSubscriberController::class, 'export'])->name('newsletter-subscribers.export');
        Route::post('/newsletter-subscribers/send-email', [NewsletterSubscriberController::class, 'sendEmail'])->name('newsletter-subscribers.send-email');
        
        // Job Postings Routes
        Route::resource('job-postings', JobPostingController::class);
        
        // Header Contact Management Routes
        Route::resource('header-contacts', HeaderContactController::class)->parameters(['header-contacts' => 'headerContact']);
        
        // Navbar Management Routes
        Route::resource('navbars', NavbarController::class)->parameters(['navbars' => 'navbar']);
        
        // Navbar Brand Management Routes
        Route::resource('navbar-brands', NavbarBrandController::class)->parameters(['navbar-brands' => 'navbarBrand']);
        
        // About Us Management Routes
        Route::resource('about-us', AboutUsController::class);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});