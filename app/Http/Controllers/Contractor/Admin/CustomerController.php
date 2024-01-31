<?php

namespace App\Http\Controllers\Contractor\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Customer;
use App\Models\CustomerSubmitProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CustomerController extends Controller
{
    /**
     * [GET] :  Customer index page
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $customers = $contractor->customers;
        } catch (\Exception $e) {
            return back()->with("error", "Fetching customers failed");
        }

        return view('contractor.admin.customer.index', ['customers' => $customers, 'subdomain' => $subdomain]);
    }

    /**
     * [GET] :  Customer detail page
     */
    public function show(Request $request, $subdomain, Customer $customer)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);

            $submits = $customer->submits()->where("contractor_id", $contractor->id)->with("floorplan")->get();

            $submit_products = CustomerSubmitProduct::whereIn("customer_submit_id", Arr::pluck($submits, "id"))->with("product")->get();
        } catch (\Exception $e) {
            return back()->with("error", "Fetching customer detail failed");
        }

        return view('contractor.admin.customer.show', ['customer' => $customer, 'subdomain' => $subdomain, 'contractor' => $contractor, "submits" => $submits, "submit_products" => $submit_products]);
    }
}
