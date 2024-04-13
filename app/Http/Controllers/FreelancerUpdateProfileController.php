<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ProfileApprovalNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class FreelancerUpdateProfileController extends Controller
{
    /**
     * Create or update a user profile.
     *
     * @param ProfileRequest $request
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
            $profile = Auth::user()->profile;

            if (!$profile) {
                throw new \Exception('Profile not found');
            }

            return response()->json(['profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
        if (!Auth::user()->hasPermissionTo('view_profiles')) {
            return response()->json(['error' => 'Unauthorized to view all profiles'], 403);
        }

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
        if (!Auth::user()->hasPermissionTo('approve_profiles')) {
            return response()->json(['error' => 'Unauthorized to approve profiles'], 403);
        }

        try {
            $profile = Profile::findOrFail($request->profile_id);
            $profile->update(['approved' => true]);

            $profile->user->notify(new ProfileApprovalNotification());

            return response()->json(['message' => 'Profile approved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    // Delete Profile
    public function deleteProfile(Request $request)
    {
        try {
            $profile = Profile::where('user_id', Auth::id())->firstOrFail();

            $profile->delete();

            return response()->json(['message' => 'Profile deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Profile not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
