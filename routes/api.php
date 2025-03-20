<?php


use App\Http\Controllers\Api\CourierController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Rate\StoreRateController;
use App\Http\Controllers\Api\Rate\UpdateRateController;
use App\Http\Controllers\Api\Rate\DeleteRateController;
use App\Http\Controllers\Api\Rate\GetUserRateByCourier;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function ()
{
    Route::get('/couriers', [CourierController::class, 'index']); // Παράθεση όλων των καταστημάτων
    Route::get('/couriers/{id}', [CourierController::class, 'show']); // Παράθεση επιλεγμένου καταστήματος

    Route::post('/rates', StoreRateController::class); // Αποθήκευση βαθμολογίας
    Route::put('/rates/{id}/{rate}', UpdateRateController::class); // Ενημέρωση βαθμολογίας
    Route::get('/rates/{courier_id}', GetUserRateByCourier::class); // Παράθεση βαθμολογίας χρήστη ανά κατάστημα
    Route::delete('/rates/{id}', DeleteRateController::class); // Διαγραφή βαθμολογίας

    Route::post('/logout', [LoginController::class, 'logout']); // Αποσύνδεση χρήστη
});
Route::post('/login', [LoginController::class, 'login']); // Σύνδεση χρήστη

