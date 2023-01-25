<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhoneBook;
use App\Models\UserCountries;
use App\Notifications\WelcomeNewUserWithSms;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'phone' => 'required|string|unique:'.PhoneBook::class,
            'country_number' => 'required|string',
            'country_name' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $userPhone = PhoneBook::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'country_number' => $request->country_number,
        ]);

        $userCountry = UserCountries::create([
            'user_id' => $user->id,
            'country_name' => $request->country_name,
        ]);
        $response = $user->notify(new WelcomeNewUserWithSms());
        if($response){
            $request->session()->flash('alert-success', 'We`ve send you message via sms and email!');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
