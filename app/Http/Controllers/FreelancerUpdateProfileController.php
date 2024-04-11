<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Exception;
use App\Events\ProfileSubmittedForApprovalEvent;
use App\Notifications\AccountApprovedNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\AccountApprovedEvent as EventsAccountApprovedEvent;


class FreelancerUpdateProfileController extends Controller
{
    // Create Profile
    public function createProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'profilename' => 'required|unique:profiles',
                'country_id' => 'required',
                'city_id' => 'required',
                'user_id'=>'required',
                'phone' => 'required|unique:profiles',
                'email' => 'required|email|unique:profiles',
                'uuid'=>'required',
                'location'=>'required'
                // Add more validation rules as needed
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $profile = new Profile();
            $profile->fill($request->all());
            $profile->user_id = Auth::id();
            $profile->save();

            return response()->json(['message' => 'Profile created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Edit Profile
    public function editProfile(Request $request)
    {
        try {
            $profile = Profile::where('user_id', Auth::id())->firstOrFail();

            $profile->update($request->all());

            return response()->json(['message' => 'Profile updated successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Profile not found'], 404);
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

    // Send Profile for Approval
    public function sendForApproval(Request $request)
{
    try {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            throw new \Exception('Profile not found');
        }

        if ($profile->approved) {
            throw new \Exception('Profile is already approved');
        }

        // Mark profile as pending approval and potentially add a timestamp
        $profile->update(['approved' => false, 'submitted_at' => now()]);

        event(new ProfileSubmittedForApprovalEvent($profile));

        return response()->json(['message' => 'Profile sent for approval']);
    } catch (\Exception $e) {
        Log::error('Sending profile for approval failed: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
    }
}



public function approveAccount(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        // Authorization check using Spatie Permissions (assuming it's enabled)
        if (!Auth::user()->hasPermissionTo('approve_account')) {
            throw new \Exception('Unauthorized to perform this action');
        }

        $user->update(['approved' => true, 'approved_at' => now()]);

        $user->notify(new AccountApprovedNotification());

        // Fire event after account approval
        event(new EventsAccountApprovedEvent($user));

        return response()->json(['message' => 'Account approved successfully']);
    } catch (\Exception $e) {
        Log::error('Account approval failed: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
    }
}




}
