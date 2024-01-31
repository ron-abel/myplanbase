<?php

namespace App\Http\Controllers\Contractor\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Contractor;

class AuthController extends Controller
{
    /**
     * [GET] : View login form.
     */
    public function login(Request $request, $subdomain)
    {
        if (Auth::user()) {
            $user = Auth::user();

            $contractor = Contractor::where('id' , '=',$user->contractor_id)->first();

            if ( isset($user->user_role_id, $contractor, $contractor->sub_domain) && ($user->user_role_id == 2 || $user->user_role_id == 3) && $contractor->sub_domain == $subdomain) {
                return redirect()->route('contractor.admin.dashboard', ['subdomain' => $subdomain]);
            }
        }

        return view('contractor.admin.login', ['subdomain' => $subdomain]);
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request, $subdomain)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $contractor = Contractor::where('id' , '=',$user->contractor_id)->first();

            if ( isset($user->user_role_id, $contractor, $contractor->sub_domain) && ($user->user_role_id == 2 || $user->user_role_id == 3) && $contractor->sub_domain == $subdomain) {
                $request->session()->regenerate();

                return redirect()->route('contractor.admin.floorplans.index', ['subdomain' => $subdomain]);
            }
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    /**
     * Handle logout attempt.
     */
    public function logout(Request $request, $subdomain)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('contractor.admin.login', ['subdomain' => $subdomain]);
    }


    /**
     * [GET] : Show dashboard for contractor admin.
     */
    public function dashboard(Request $request, $subdomain)
    {
        return view('contractor.admin.index', ['subdomain' => $subdomain, "contractor" => $request->contractor_details]);
    }


    /**
     * [GET] : Show sign up thanks page for contractor admin.
     */
    public function showThanks(Request $request, $subdomain)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $contractor->completed_setting_at = Carbon::now();
            $contractor->save();
        } catch (\Exception $e) {
            return back();
        }

        return view('contractor.admin.thanks', ['subdomain' => $subdomain, "contractor" => $request->contractor_details]);
    }

    /**
     * [GET] : redirecting to login page.
     */
    public function welcome(Request $request, $subdomain)
    {
        return redirect()->route("contractor.admin.login", ["subdomain" => $subdomain]);
    }
}
