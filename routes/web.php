<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MyJobController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MyJobApplicationController;

//job routes
Route::get('', fn() => to_route('jobs.index'));
Route::resource('jobs', JobController::class)
     ->only(['index', 'show']);

//auth routes

/*login
     Route::get('login', fn() => to_route('auth.create'))->name('login');
 Route::resource('auth', AuthController::class)
     ->only(['create', 'store']);

     //logout
     Route::delete('logout', fn() => to_route('auth.destroy'))->name('logout');

 Route::delete('auth', [AuthController::class, 'destroy'])
     ->name('auth.destroy');*/


      // Show signup form

      Route::get('signup', [AuthController::class, 'create'])->name('auth.create');

// Handle signup form submission
Route::post('signup', [AuthController::class, 'store'])->name('auth.store');


     // Show login form
Route::get('login', [AuthController::class, 'login'])->name('auth.login');

// Handle login form submission
Route::post('login', [AuthController::class, 'loginValidate'])->name('auth.login.validate');


//show password reset request form
Route::get('forgot-password', [AuthController::class, 'forgot'])->name('password.request');
//handle the request and send email
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
//show password reset form
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
//update the password
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
// Logout
Route::delete('logout', [AuthController::class, 'destroy'])->name('auth.logout');


     //job application


 Route::middleware('auth')->group(function () {
     Route::resource('job.application', JobApplicationController::class)
         ->only(['create', 'store']);

         //cv download route
         Route::get('/applications/{application}/cv', [JobApplicationController::class, 'downloadCv'])->name('applications.download.cv');


         //my job applications

     Route::resource('my-job-applications', MyJobApplicationController::class)
     ->only(['index', 'destroy']);


     Route::resource('employer', EmployerController::class)
     ->only(['create', 'store']);

     Route::middleware('employer')
     ->resource('my-jobs', MyJobController::class);

     
 });