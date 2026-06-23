<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\AdController as FrontendAdController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;

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

// کور پاڼه
Route::get('/', [HomeController::class, 'index'])->name('home');

// د ژبې بدلولو روټ
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ps', 'dr', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// د ننوتلو روټونه
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// د ثبت نوم روټونه (غیر فعال)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ډشبورډ
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// د اعلانونو مدیریت (Admin/Staff)
Route::resource('admin/ads', AdController::class)->middleware('auth')->names([
    'index'   => 'admin.ads.index',
    'create'  => 'admin.ads.create',
    'store'   => 'admin.ads.store',
    'show'    => 'admin.ads.show',
    'edit'    => 'admin.ads.edit',
    'update'  => 'admin.ads.update',
    'destroy' => 'admin.ads.destroy',
]);

// د کاروونکو مدیریت (یوازې Admin)
Route::resource('admin/users', UserController::class)->middleware('auth')->names([
    'index'   => 'admin.users.index',
    'create'  => 'admin.users.create',
    'store'   => 'admin.users.store',
    'edit'    => 'admin.users.edit',
    'update'  => 'admin.users.update',
    'destroy' => 'admin.users.destroy',
]);

// د پاسورډ بدلولو روټ
Route::get('/change-password', [UserController::class, 'changePasswordForm'])->middleware('auth')->name('change.password.form');
Route::post('/change-password', [UserController::class, 'changePassword'])->middleware('auth')->name('change.password');

// د تنظیماتو روټونه (یوازې Admin)
Route::get('/admin/settings', [SettingController::class, 'index'])->middleware('auth')->name('admin.settings.index');
Route::post('/admin/settings', [SettingController::class, 'update'])->middleware('auth')->name('admin.settings.update');

// د خدماتو مدیریت (Admin/Staff)
Route::resource('admin/services', ServiceController::class)->middleware('auth')->names([
    'index'   => 'admin.services.index',
    'create'  => 'admin.services.create',
    'store'   => 'admin.services.store',
    'edit'    => 'admin.services.edit',
    'update'  => 'admin.services.update',
    'destroy' => 'admin.services.destroy',
]);

// د پکېجونو مدیریت (Admin/Staff)
Route::resource('admin/packages', PackageController::class)->middleware('auth')->names([
    'index'   => 'admin.packages.index',
    'create'  => 'admin.packages.create',
    'store'   => 'admin.packages.store',
    'edit'    => 'admin.packages.edit',
    'update'  => 'admin.packages.update',
    'destroy' => 'admin.packages.destroy',
]);

// د FAQ مدیریت (Admin)
Route::resource('admin/faqs', FaqController::class)->middleware('auth')->names([
    'index'   => 'admin.faqs.index',
    'create'  => 'admin.faqs.create',
    'store'   => 'admin.faqs.store',
    'edit'    => 'admin.faqs.edit',
    'update'  => 'admin.faqs.update',
    'destroy' => 'admin.faqs.destroy',
]);

// د ګالري مدیریت (Admin)
Route::resource('admin/galleries', GalleryController::class)->middleware('auth')->names([
    'index'   => 'admin.galleries.index',
    'create'  => 'admin.galleries.create',
    'store'   => 'admin.galleries.store',
    'edit'    => 'admin.galleries.edit',
    'update'  => 'admin.galleries.update',
    'destroy' => 'admin.galleries.destroy',
]);

// د تماس فورم (Frontend)
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

// د پیغامونو مدیریت (Admin)
Route::get('/admin/messages', [ContactMessageController::class, 'index'])->middleware('auth')->name('admin.messages.index');
Route::get('/admin/messages/{message}', [ContactMessageController::class, 'show'])->middleware('auth')->name('admin.messages.show');
Route::delete('/admin/messages/{message}', [ContactMessageController::class, 'destroy'])->middleware('auth')->name('admin.messages.destroy');

// ==================== Frontend عامه مخونه ====================

// عامه اعلانونه
Route::get('/ads', [FrontendAdController::class, 'index'])->name('ads.index');
Route::get('/ads/{ad}', [FrontendAdController::class, 'show'])->name('ads.show');

// زموږ په اړه (About)
Route::get('/about', function () {
    $aboutText = \App\Models\Setting::get('about_text', []);
    return view('frontend.about', compact('aboutText'));
})->name('about');

// خدمات (Services) - عامه لېست
Route::get('/services', function () {
    $services = \App\Models\Service::where('is_active', true)->orderBy('sort_order')->get();
    return view('frontend.services', compact('services'));
})->name('services');

// پکېجونه (Packages) - عامه لېست
Route::get('/packages', function () {
    $packages = \App\Models\Package::where('is_active', true)->latest()->paginate(12);
    return view('frontend.packages', compact('packages'));
})->name('packages');

// د منزلونو مدیریت (Admin)
Route::resource('admin/destinations', DestinationController::class)->middleware('auth')->names([
    'index'   => 'admin.destinations.index',
    'create'  => 'admin.destinations.create',
    'store'   => 'admin.destinations.store',
    'edit'    => 'admin.destinations.edit',
    'update'  => 'admin.destinations.update',
    'destroy' => 'admin.destinations.destroy',
]);

// د ټیم غړو مدیریت (Admin)
Route::resource('admin/team', TeamMemberController::class)->middleware('auth')->names([
    'index'   => 'admin.team.index',
    'create'  => 'admin.team.create',
    'store'   => 'admin.team.store',
    'edit'    => 'admin.team.edit',
    'update'  => 'admin.team.update',
    'destroy' => 'admin.team.destroy',
]);

// د نظرونو مدیریت (Admin)
Route::resource('admin/testimonials', TestimonialController::class)->middleware('auth')->names([
    'index'   => 'admin.testimonials.index',
    'create'  => 'admin.testimonials.create',
    'store'   => 'admin.testimonials.store',
    'edit'    => 'admin.testimonials.edit',
    'update'  => 'admin.testimonials.update',
    'destroy' => 'admin.testimonials.destroy',
]);

// ==================== د پاسورډ هېر شوی روټونه ====================
// د "پاسورډ هېر شوی" فورم
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// د ریسېټ لینک استول
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// د نوي پاسورډ ټاکلو فورم
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// نوی پاسورډ خوندي کول
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');