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
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    });

    Route::post('/create', [FreelancerUpdateProfileController::class, 'createProfile']);
    Route::put('/profile/edit', [FreelancerUpdateProfileController::class, 'editProfile']);
    Route::delete('/profile/delete', [FreelancerUpdateProfileController::class, 'deleteProfile']);
    Route::post('/profile/approval', [FreelancerUpdateProfileController::class, 'sendForApproval']);
    Route::post('/account/approve', [FreelancerUpdateProfileController::class, 'approveAccount']);
});
