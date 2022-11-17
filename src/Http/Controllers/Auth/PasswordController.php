<?php

namespace AhmetShen\StarterKits\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => [
                'required',
                'string',
                'max:'.setting('password_max', 'length'),
                Rules\Password::defaults(),
                'between:'.setting('password_min', 'length').','.setting('password_max', 'length'),
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'max:'.setting('password_max', 'length'),
                Rules\Password::defaults(),
                'between:'.setting('password_min', 'length').','.setting('password_max', 'length'),
                'confirmed',
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
