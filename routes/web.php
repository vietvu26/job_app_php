<?php

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

Route::get('/', function () {
    return view('user.home');
});

Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
Route::middleware('auth')->group(function () {
Route::get('/account/profile',[AccountController::class,'profile'])->name('account.profile');
Route::patch('/update-profile', [AccountController::class, 'updateProfile'])->name('profile.update');
Route::post('/account/profile',[AccountController::class,'updateProfilePic'])->name('account.updateProfilePic');     
Route::get('/create-cv',[AccountController::class,'createcv'])->name('account.createcv');
Route::post('/save-cv',[AccountController::class,'savecv'])->name('account.saveCV');   
});

Route::get('/account/profile', function () {
    return view('user.account.profile');
})->middleware(['auth', 'verified'])->name('account.profile');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
