<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('available-slots', [\App\Http\Controllers\Api\ApiController::class, 'getAvailableSlotsBySportCourt']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/razorpay/initiate-payment', [\App\Http\Controllers\Api\RazorpayPaymentController::class, 'initiatePayment']);
    Route::post('/razorpay/verify-payment', [\App\Http\Controllers\Api\RazorpayPaymentController::class, 'verifyPayment']);
    Route::get('/venues', [ApiController::class, 'getVenues']);
    Route::post('/venues', [ApiController::class, 'createVenues']);
    Route::put('/venues/{id}', [ApiController::class, 'updateVenues']);
    Route::delete('/venues/{id}', [ApiController::class, 'deleteVenues']);
    Route::post('/venues/{id}/status', [ApiController::class, 'upStatusVenues']);

    Route::get('/sports', [ApiController::class, 'getSports']);
    Route::post('/sports', [ApiController::class, 'createSports']);
    Route::put('/sports/{id}', [ApiController::class, 'updateSports']);
    Route::delete('/sports/{id}', [ApiController::class, 'deleteSports']);
    Route::post('/sports/{id}/status', [ApiController::class, 'upStatusSports']);
    Route::get('/sports/{id}', [ApiController::class, 'getSportsDetail']);

    Route::get('/courts', [ApiController::class, 'getCourts']);
    Route::post('/courts', [ApiController::class, 'createCourts']);
    Route::put('/courts/{id}', [ApiController::class, 'updateCourts']);
    Route::delete('/courts/{id}', [ApiController::class, 'deleteCourts']);
    Route::post('/courts/{id}/status', [ApiController::class, 'upStatusCourts']);
    Route::get('sports/{id}/courts', [ApiController::class, 'getCourtsBySport']);

    Route::get('slots', [ApiController::class, 'getSlots']);
    Route::post('slots', [ApiController::class, 'createSlots']);
    Route::put('slots/{id}', [ApiController::class, 'updateSlots']);
    Route::delete('slots/{id}', [ApiController::class, 'deleteSlots']);
    Route::post('slots/{id}/status', [ApiController::class, 'upStatusSlots']);
    Route::get('slots/{sport_id}/{date}', [ApiController::class, 'getSlotBySportDate']);

    Route::post('bookings', [ApiController::class, 'bookSlots']);
    Route::get('my-bookings', [ApiController::class, 'myBooking']);
    Route::get('bookings/{id}', [ApiController::class, 'bookingDetail']);
    Route::post('bookings/{id}/cancel', [ApiController::class, 'cancelBooking']);
    Route::get('bookings', [ApiController::class, 'getBookings']);
    Route::post('bookings/{id}/status', [ApiController::class, 'upStatusBooking']);

    Route::get('groups', [ApiController::class, 'getMyGroups']);
    Route::post('groups', [ApiController::class, 'createGroups']);
    Route::get('all-groups', [ApiController::class, 'getAllGroups']); 
    Route::post('groups/{id}/join', [ApiController::class, 'joinGroup']);
    Route::post('groups/{id}/leave', [ApiController::class, 'leaveGroup']);

    // Trainer CRUD APIs
    Route::get('trainers', [ApiController::class, 'getTrainers']);
    Route::post('trainers', [ApiController::class, 'createTrainer']);
    Route::put('trainers/{id}', [ApiController::class, 'updateTrainer']);
    Route::delete('trainers/{id}', [ApiController::class, 'deleteTrainer']);
    Route::post('trainers/{id}/status', [ApiController::class, 'upStatusTrainer']);

    // Trainer Booking APIs
    Route::get('my-trainer-bookings/{user_id}', [ApiController::class, 'myTrainerBookings']);
    Route::post('trainer-bookings', [ApiController::class, 'bookTrainer']);
    Route::get('trainer-bookings/{id}', [ApiController::class, 'trainerBookingDetail']);
    Route::post('trainer-bookings/{id}/cancel', [ApiController::class, 'cancelTrainerBooking']);
    Route::post('trainer-bookings/{id}/status', [ApiController::class, 'upStatusTrainerBooking']);
    // Route::get('trainer-bookings', [ApiController::class, 'getTrainerBookings']);

    // Game APIs
    Route::post('games', [ApiController::class, 'createGame']);
    Route::post('games/{gameId}/invite', [ApiController::class, 'inviteUser']);
    Route::get('my-games', [ApiController::class, 'listUserGames']);
});
