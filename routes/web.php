<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FindController;

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

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/findjob', [FindController::class, 'index'])->name('find');
Route::get('/jobs/detail/{id}', [HomeController::class, 'detail'])->name('jobDetail');
Route::get('/my-job-applications/delete/{id}', [HomeController::class, 'deleteapply'])->name('deletejobapply');
Route::get('/my-job-save/delete/{id}', [HomeController::class, 'deletesave'])->name('deletejobsave');
Route::post('/apply-job', [HomeController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job', [HomeController::class, 'savedJob'])->name('savedJob');
Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
Route::get('/find', [FindController::class, 'findjob'])->name('findjob');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/admin/account/profile', function () {
//     return view('admin.account.profile');
// })->middleware(['auth', 'verified'])->name('account');

Route::middleware('auth')->group(function () {
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::patch('/update-profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::post('/account/profile', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
    Route::get('/create-cv', [AccountController::class, 'createcv'])->name('account.createcv');
    Route::post('/save-cv', [AccountController::class, 'savecv'])->name('account.saveCV');
    Route::get('/my-job-applications', [AccountController::class, 'myJobApplications'])->name('account.myJobApplications');
    Route::get('/my-job-save', [AccountController::class, 'savejobs'])->name('account.savejobs');

});

// Route::get('/account/profile', function () {
//     return view('account.profile');
// })->middleware(['auth', 'verified'])->name('account');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::middleware(['auth', 'admin'])->group(function () {
    // Job
    Route::get('/admin/job/create', [JobController::class, 'create'])->name('admin.job.create');
    Route::post('/admin/job/create', [JobController::class, 'store'])->name('admin.job.store');

    Route::get('/admin/job/manage', [JobController::class, 'manage'])->name('admin.job.manage');

    Route::get('/admin/job/edit/{job}', [JobController::class, 'edit'])->name('admin.job.edit');
    Route::patch('/admin/job/edit/{job}', [JobController::class, 'update'])->name('admin.job.update');

    Route::delete('/admin/job/delete/{id}', [JobController::class, 'delete'])->name('admin.job.delete');

    Route::get('/profile/{user_id}', [ProfileController::class, 'index'])->name('profile');

    Route::put('/admin/job/review/{id}', [JobController::class, 'review'])->name('admin.job.review');

    // Category
    Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/create', [CategoryController::class, 'store'])->name('admin.category.store');

    Route::get('/admin/category/manage', [CategoryController::class, 'manage'])->name('admin.category.manage');
});

require __DIR__ . '/auth.php';