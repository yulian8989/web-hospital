<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingTransactionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\HospitalSpecialistController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('token-login', [AuthController::class, 'tokenLogin']); 
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
    Route::apiResource('specialists', SpecialistController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('hospitals', HospitalController::class);

    // {hospital} = id hospital, 1, 55, 23, dst...
    Route::post('hospitals/{hospital}/specialists', [HospitalSpecialistController::class, 'attach']);
    Route::delete('hospitals/{hospital}/specialists/{specialist}', [HospitalSpecialistController::class, 'detach']);

    Route::apiResource('transactions', BookingTransactionController::class);
    Route::patch('transactions/{id}/status', [BookingTransactionController::class, 'updateStatus']);
});

Route::middleware(['auth:sanctum', 'role:customer|manager'])->group(function () {
    Route::get('specialists', [SpecialistController::class, 'index']); 
    Route::get('specialists/{specialist}',[SpecialistController::class, 'show']); 

    Route::get('hospitals', [HospitalController::class, 'index']);
    Route::get('hospitals/{hospital}',[HospitalController::class, 'show']);

    Route::get('doctors', [DoctorController::class, 'index']);
    Route::get('doctors/{doctor}',[DoctorController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::get('/doctors-filter', [DoctorController::class, 'filterBySpecialistAndHospital']);
    Route::get('/doctors/{doctorId}/available-slots', [DoctorController::class, 'availableSlots']);

    Route::get('my-orders', [MyOrderController::class, 'index']);
    Route::post('my-orders', [MyOrderController::class, 'store']);
    Route::get('my-orders/{id}', [MyOrderController::class, 'show']);
});
