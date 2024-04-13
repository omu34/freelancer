<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\FreelancerUpdateProfileController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile/userCreateOrUpdateProfile-Send-notification', [FreelancerUpdateProfileController::class, 'userCreateOrUpdateProfileAndSendNotification']);
    Route::get('/profile/user-fetch-ownProfile', [FreelancerUpdateProfileController::class, 'userFetchOwnProfile']);
    Route::get('/profile/admin-fetch-all-profile', [FreelancerUpdateProfileController::class, 'adminFetchAllProfiles']);
    Route::post('/profile/admin-approve-profile-and-send-notification', [FreelancerUpdateProfileController::class, 'adminApproveProfileAndSendNotification']);
    Route::delete('/profile/delete', [FreelancerUpdateProfileController::class, 'deleteProfile']);

});

// Route::get('/user', function (Request $request) {
    //     return new UserResource($request->user());
    // });
    // Route::post('/logout', function (Request $request) {
    //     $request->user()->tokens()->delete();

    //     return response()->json([
    //         'message' => 'Logged out successfully',
    //     ]);
    // });
