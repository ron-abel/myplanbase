<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CheckContractor
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

        $tenant_details = DB::table('contractors')->where('sub_domain', $subdomain)->first();

        if ($tenant_details) {
            $request->merge(array("contractor_details" => $tenant_details));

            return $next($request);
        }

        return redirect()->route('contractor.login', ["subdomain" => $subdomain]);
    }
}
