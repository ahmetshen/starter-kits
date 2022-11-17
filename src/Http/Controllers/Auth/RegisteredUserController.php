<?php

namespace AhmetShen\StarterKits\Http\Controllers\Auth;

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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create(): View
    {
        return view(viewPath('auth', 'pages.register'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:'.setting('name_min', 'length'),
                'max:'.setting('name_max', 'length'),
                'between:'.setting('name_min', 'length').','.setting('name_max', 'length'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'min:'.setting('email_min', 'length'),
                'max:'.setting('email_max', 'length'),
                'between:'.setting('email_min', 'length').','.setting('email_max', 'length'),
                'unique:'.User::class,
            ],
            'password' => [
                'required',
                'string',
                'max:'.setting('password_max', 'length'),
                Rules\Password::defaults(),
                'between:'.setting('password_min', 'length').','.setting('password_max', 'length'),
                'confirmed',
            ],
            recaptchaFieldName() => recaptchaRuleName(),
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ip_address' => $request->ip(),
        ]);

        $user->assignRole(setting('default_role', 'general'));

        $user->setSetting('profile_card', setting('profile_card', 'color'), 'color');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
