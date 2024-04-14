<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProfileRequest;
use App\Notifications\AdminApproveNotification;
use App\Notifications\ProfileApprovalNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FreelancerUpdateProfileController extends Controller
{

    /**
     * Create or update a user profile.
     *
     * @param StoreProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCreateOrUpdateProfileAndSendNotification(StoreProfileRequest $request)
    {
        try {
            $profile = Profile::where('user_id', Auth::id())->firstOrNew();
            $profile->fill($request->validated());
            $profile->user_id = Auth::id();
            $profile->save();

            // Send verification email notification (uncomment if desired)
            Auth::user()->notify(new ProfileApprovalNotification());

            return response()->json(['message' => 'Profile updated/created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


 /**
     * Fetch the authenticated user's profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */


     public function userFetchOwnProfile(Request $request)
     {

         try {
             // Retrieve user ID from authenticated user
             $userId = Auth::user()->id;

             // Fetch profile based on user ID
             $profile = Profile::where('user_id', $userId)->firstOrFail();

             return response()->json(['profile' => $profile], 200);
         } catch (\Exception $e) {
             \Log::error('Error fetching user profile: ' . $e->getMessage());
             return response()->json(['error' => 'Failed to fetch profile'], 500);
         }
     }


    /**
     * Fetch all profiles (for Admin).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function adminFetchAllProfiles(Request $request)
    {
        // Implement authorization check here (e.g., using policies or middleware)
        // if (!Auth::user()->hasPermissionTo('approve_profiles')) {
        //     return response()->json(['error' => 'Unauthorized to view all profiles'], 403);
        // }

        try {
            $profiles = Profile::all();
            return response()->json(['profiles' => $profiles], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Approve a profile (for Admin).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function adminApproveProfileAndSendNotification(Request $request)
    {

        // Implement authorization check here (e.g., using policies or middleware)
        // if (!Auth::user()->hasPermissionTo('approve_profiles')) {
        //     return response()->json(['error' => 'Unauthorized to view all profiles'], 403);
        // }


        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Update user's approved status
            $user->update(['approved' => true, 'approved_at' => now()]);

            // Send notification to the user
            $user->notify(new AdminApproveNotification());

            return response()->json(['message' => 'Account approved successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Account approval failed: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
    }


    // Delete Profile
    public function deleteProfile(Request $request)
    {
        try {
            $profile = Profile::where('user_id', Auth::id())->firstOrFail();
            $profile->delete();
            return response()->json(['message' => 'Profile deleted successfully'],200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Profile not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
