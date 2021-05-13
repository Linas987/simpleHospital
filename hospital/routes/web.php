<?php

use App\Http\Controllers\EditDoctorController;
use App\Http\Controllers\PatientListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DoctorListController;
use App\Http\Controllers\MakeDoctorController;
use App\Http\Controllers\DateController;
use App\Models\Doctor;

Route::get('/', function(){
  return view('home');
})->name('home');


//------all_users
Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard')->middleware('auth');
    Route::delete('/dashboard',[DashboardController::class,'destroy']);
    Route::get('/dashboard/{id}', [DashboardController::class,'edit'])->name('EditUser');
    Route::patch('/dashboard/{id}',[DashboardController::class,'update'])->name('EditUser2');

    Route::post('/Date',[DateController::class,'store'])->name('Date');
    Route::delete('/Date',[DateController::class,'destroy']);
    Route::get('/Date/{id}', [DateController::class,'edit'])->name('EditDate');
    Route::patch('/Date/{id}', [DateController::class,'update'])->name('EditDate2');
    Route::get('/Card', [CardController::class,'index'])->name('Card');
    Route::get('/DoctorList', [DoctorListController::class,'index'])->name('DoctorList');
    Route::post('/DoctorList', [DoctorListController::class,'store']);
});
//---------------

//------Doctors
Route::group(['middleware' => ['auth:doctor']], function () {
    Route::get('/doctordashboard', [DashboardController::class,'index2'])->name('doctordashboard');

    Route::get('/WriteCard', [CardController::class,'index2'])->name('WriteCard');
    Route::post('/WriteCard', [CardController::class,'store']);
    Route::get('/WriteCard/{id}', [CardController::class,'edit'])->name('EditCard');
    Route::patch('/WriteCard/{id}',[CardController::class,'update'])->name('EditCard2');
    Route::delete('/WriteCard',[CardController::class,'destroy'])->name('DeleteCard');

    Route::get('/PatientList', [PatientListController::class,'index'])->name('PatientList');
    Route::get('/users-dt', [PatientListController::class, 'dt'])->name('PatientList-dt');
});
//-------------

//-----------admin
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/MakeDoctor', [MakeDoctorController::class, 'index'])->name('MakeDoctor');
    Route::post('/MakeDoctor', [MakeDoctorController::class, 'store']);
    Route::get('/EditDoctor', [EditDoctorController::class, 'index'])->name('EditDoctor');
    Route::delete('/EditDoctor', [EditDoctorController::class, 'destroy']);
    Route::get('/EditDoctor/{id}', [EditDoctorController::class, 'edit'])->name('EditDoctor2');
    Route::patch('/EditDoctor/{id}', [EditDoctorController::class, 'update'])->name('EditDoctor3');
});
//----------------

//---------everyone
Route::get('/logout', [LogoutController::class,'index'])->name('logout');
Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'store']);
Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store']);

Route::get('auth/{provider}',[LoginController::class,'redirectToProvider']);
Route::get('auth/{provider}/callback',[LoginController::class,'handleProviderCallback']);
//---------everyone
