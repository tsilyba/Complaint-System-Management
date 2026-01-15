<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Database\QueryException;

class ProfileController extends Controller
{
   //view profile
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    //update profile
   public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $request->user()->fill($request->validated());

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');

        } catch (QueryException $e) {
            return Redirect::route('profile.edit')->with('error', 'Database Error: Failed to update profile.');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Update Failed: ' . $e->getMessage());
        }
    }

    // delete profile
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        try {
            $user = $request->user();

            // Logout first
            Auth::logout();

            // Attempt to delete user record
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');

        } catch (QueryException $e) {
            return Redirect::route('login')->with('error', 'Account deletion failed due to a database error.');
            
        } catch (\Exception $e) {
            return Redirect::route('login')->with('error', 'System Error: ' . $e->getMessage());
        }
    }
}
