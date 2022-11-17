<?php

namespace AhmetShen\StarterKits\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        return view(viewPath('auth', 'pages.reset-password'), ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => [
                'required',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'min:'.setting('email_min', 'length'),
                'max:'.setting('email_max', 'length'),
                'between:'.setting('email_min', 'length').','.setting('email_max', 'length'),
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

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', trans($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => trans($status)]);
    }
}
