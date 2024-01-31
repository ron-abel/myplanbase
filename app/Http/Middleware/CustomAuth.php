<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain_name = explode('.', URL::current());
        $subdomain = substr($domain_name[0], strrpos($domain_name[0], '/') + 1);
        $contractor_details = DB::table('contractors')->where('sub_domain', $subdomain)->first();

        if ($contractor_details) {
            $user_id = Auth::id();

            $request->merge(array("contractor_details" => $contractor_details));

            // $config_details = DB::table('config')->where('tenant_id', $contractor_details->id)->first();

            // $request->merge(array("settings_details" => $config_details));

            view()->share('subdomain', $contractor_details->sub_domain);

            $route_name = Route::currentRouteName();
            if (!Auth::check() && $route_name != 'contractor.admin.login') {
                return redirect()->route('contractor.admin.login', ['subdomain' =>  $contractor_details->sub_domain]);
            }
            if ($user_id || $route_name == 'login') {

                $user_details = Auth::user();
                // check tenant  and user's tenant
                if (isset($user_details['contractor_id'], $contractor_details->id)) {
                    if ($user_details['contractor_id'] == $contractor_details->id) {
                        view()->share('user_details', $user_details);
                        // view()->share('config_details', $config_details);
                        return $next($request);
                    }
                }

                // logout
                Auth::logout();

                return redirect()->route('contractor.admin.login', ['subdomain' =>  $contractor_details->sub_domain]);
            } else {
                //Check if URL Contains 'admin' 
                $adminCheck = substr(URL::current(), strrpos(URL::current(), '/') + 1);
                if ($adminCheck == 'admin') {
                    return redirect()->route('contractor.admin.login', ['subdomain' =>  $contractor_details->sub_domain]);
                }

                //Check if subdomain is tenant
                if ($subdomain == $contractor_details->sub_domain && strpos(URL::current(), 'admin') == false) {
                    return redirect()->route('client', ['subdomain' =>  $contractor_details->sub_domain]);
                }

                return $next($request);
                // return redirect()->route('admin.login',  ['subdomain' =>  $tenant_details->sub_domain]);
            }
        } else {
            return redirect()->route('super.welcome');
        }

        return redirect()->route('contractor.invalid');
    }
}
