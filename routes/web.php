<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UploadLeadsController;
use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Models\Package;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::get('register', [AuthenticatedSessionController::class, 'index'])
->name('register')
->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::post('register', [AuthenticatedSessionController::class, 'post'])
->name('register.post')
->middleware('guest');

Route::get('check', [AuthenticatedSessionController::class, 'check'])
->name('register.check')
->middleware('guest');


Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');


//Leads
Route::get('/leads', [LeadsController::class, 'create'])
    ->name('leads')
    ->middleware('auth');

Route::get('/leads/update', [LeadsController::class, 'update'])
->name('leads.update')
->middleware('auth');

Route::post('/leads/update', [LeadsController::class, 'store'])
->name('leads.store')
->middleware('auth');

Route::post('/import', [UploadLeadsController::class, 'import'])
    ->name('import.leads');



// Users
Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations
Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');



// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

//Client Package
Route::get('/package', [UserPackageController::class, 'index'])
    ->name('package')
    ->middleware('auth');

//Stripe
Route::get('/payment', [StripeController::class, 'index'])
    ->name('payment')
    ->middleware('auth');

Route::post('/payment', [StripeController::class, 'store'])
    ->name('subscribe')
    ->middleware('auth');

Route::get('/payment/cancel/{subscription_id}', [StripeController::class, 'destroy'])
->name('subscribe.cancel')
->middleware('auth');


//================Admin Routes =================
//Auth
Route::get('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'create'])
->name('admin.login');

Route::post('admin', [App\Http\Controllers\Auth\AdminLoginController::class, 'store'])
->name('admin.store');

Route::get('admin/user/delete/{user}', [UsersController::class, 'destroy'])
    ->name('admin.user.destroy')
    ->middleware('admin:admin');

Route::get('admin/user/restore/{user}', [UsersController::class, 'restore'])
    ->name('admin.user.restore')
    ->middleware('admin:admin');

//Dashboard
Route::get('/admin', [AdminDashboardController::class, 'index'])
->name('admin.dashboard');

//Upload Leads
Route::get('/admin/uploadleads', [UploadLeadsController::class, 'index'])
    ->name('admin.uploadleads');

Route::get('/admin/uploadleads/{id}', [UploadLeadsController::class, 'leads'])
->name('admin.uploadleads.view');

Route::get('/admin/user/view/{id}', [UploadLeadsController::class, 'user'])
    ->name('admin.user.view');

Route::get('/leads/delete/', [UploadLeadsController::class, 'delete'])
    ->name('leads.destroy');


// Admin Reports
Route::get('reports', [ReportsController::class, 'index'])
    ->name('admin.reports');


//Packages
Route::get('/admin/package', [PackageController::class, 'index'])
    ->name('admin.package');

Route::get('admin/package/create', [PackageController::class, 'create'])
->name('admin.package.create');

Route::post('/admin/package/store', [PackageController::class, 'store'])
->name('admin.package.store');

Route::get('/package/{id}', [PackageController::class, 'destroy'])
->name('package.delete');

//Forgot Password
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest')
        ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest')
        ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.update');