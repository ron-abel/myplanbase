<?php

namespace App\Http\Middleware;

use App\Models\SubscriptionCustomer;
use App\Models\Tenant;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Log as Logging;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(auth()->user()->id);

        $domain_name = explode('.', URL::current());
        $subdomain = substr($domain_name[0], strrpos($domain_name[0], '/') + 1);
        $tenant = Tenant::where('tenant_name', $subdomain)->first();

        if (!$tenant) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $subscribedCustomer = SubscriptionCustomer::where('tenant_id', $tenant->id)->first();

        $route_name = Route::currentRouteName();
        if ($user && ($route_name != 'billing' && $route_name != 'profile_update')) {
            if (isset($subscribedCustomer->id) && SubscriptionCustomer::checkActiveSubscription($subscribedCustomer->id)) {
            } else if (!isset($subscribedCustomer) || !($subscribedCustomer->subscribed('default'))) {
                return redirect()->route('billing', ['subdomain' => $subdomain, 0])->with('info', 'Please complete Billing Process!');
            }
        }

        return $next($request);
    }
}
