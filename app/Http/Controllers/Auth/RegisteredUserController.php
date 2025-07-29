<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        try{
            return view('auth.register');
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Registration failed'], 404);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try{
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'date_of_birth' => ['required', 'date:Y-m-d', 'before:today'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,     
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Mail::to($user->email)->send(new WelcomeEmail($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
        }
        catch(\Throwable $th)
        {
            return response()->view('errors.404', ['message' => 'Registration failed'], 404);
        }
    }
}
