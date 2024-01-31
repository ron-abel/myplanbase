<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * [GET] : Show forgot password form.
     */
    public function show_forgot_password_form(Request $request, $subdomain)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.forgot-password', ['subdomain' => $subdomain, "contractor" => $contractor]);
    }

    /**
     * [POST] : Forgot password handler.
     */
    public function forgot_password(Request $request, $subdomain)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails())
            return back()->with('error', "Email is required");

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['error' => __($status)]);
    }

    /**
     * [GET] : Reset password form.
     */
    public function show_reset_password_form(Request $request, $subdomain, $token)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.reset_password', ["subdomain" => $subdomain, 'contractor' => $contractor, "token" => $token]);
    }

    /**
     * [POST] : Reset password handler.
     */
    public function reset_password(Request $request, $subdomain)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails())
            return back()->with('error', "Fill the form with exact values");

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('contractor.admin.login', ['subdomain' => $subdomain])->with('success', __($status))
            : back()->with(['error' => [__($status)]]);
    }
}
