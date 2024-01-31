<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * [GET] : Customer portal first page.
     */
    public function index(Request $request, $subdomain)
    {
        // $contractor = Contractor::find($request->contractor_details->id);

        // return view('contractor.index', ['subdomain' => $subdomain, "contractor" => $contractor]);

        return redirect()->route('contractor.floorplans.index', ['subdomain' => $subdomain]);
    }
}
