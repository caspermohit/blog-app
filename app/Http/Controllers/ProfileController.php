<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        try{
            return view('profile.edit', [
                'user' => $request->user(),
            ]);
            
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Profile not found'], 404);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try{
            $request->user()->fill($request->validated());
            

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Profile not updated'], 404);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try{
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Profile not deleted'], 404);
        }
    }
}
