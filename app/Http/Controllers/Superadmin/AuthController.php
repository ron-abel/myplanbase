<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $sub_domain_name;
    public $cur_tenant_id;
    public function __construct()
    {
        Controller::setSubDomainName();
        $this->sub_domain_name = session()->get('subdomain');
        $this->cur_tenant_id = session()->get('tenant_id');
    }

    /**
     * [GET] login for Admin
     */
    public function show_login_form(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->user_role_id == 1) {
            return redirect()->route('super.dashboard');
        }

        return view('superadmin.login');
    }


    /**
     * [POST] login for Super Admin
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            $user_details = Auth::user();

            if (isset($user_details) && $user_details->user_role_id == 1) {
                $request->session()->regenerate();

                return redirect()->route("super.dashboard");
            } else {
                Auth::logout();
            }
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }


    public function logout(Request $request)
    {
        try {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('super.login');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
