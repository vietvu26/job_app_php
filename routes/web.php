<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

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

Route::get(
    '/',
    // return view('front.home');
    [HomeController::class, 'index']
)->name('home');

Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/account/profile', function () {
    return view('front.account.profile');
})->middleware(['auth', 'verified'])->name('account');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'admin'])->group(function () {
    // Job
    Route::get('/admin/job/create', [JobController::class, 'create'])->name('admin.job.create');
    Route::post('/admin/job/create', [JobController::class, 'store'])->name('admin.job.store');

    Route::get('/admin/job/manage', [JobController::class, 'manage'])->name('admin.job.manage');

    Route::get('/admin/job/edit/{job}', [JobController::class, 'edit'])->name('admin.job.edit');
    Route::patch('/admin/job/edit/{job}', [JobController::class, 'update'])->name('admin.job.update');

    Route::get('/admin/job/delete/{id}', [JobController::class, 'delete'])->name('admin.job.delete');

    // Category
    Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/create', [CategoryController::class, 'store'])->name('admin.category.store');

    Route::get('/admin/category/manage', [CategoryController::class, 'manage'])->name('admin.category.manage');
});

require __DIR__ . '/auth.php';