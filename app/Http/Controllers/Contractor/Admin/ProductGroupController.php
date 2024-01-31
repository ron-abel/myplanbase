<?php

namespace App\Http\Controllers\Contractor\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Helpers\ManageAssets;
use Auth;

class ProductGroupController extends Controller
{
    /**
     * [GET] :  Product Group list for Contractor Admin
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $productgroups = ProductGroup::where(function($q) use($contractor_id) {
                $q->whereNull('contractor_id')->orWhere('contractor_id', $contractor_id);
            })->get();

            return view('contractor.admin.productgroup.index', ['productgroups' => $productgroups, "subdomain" => $subdomain, "contractor" => $request->contractor_details]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [PUT] :  Product group selection for Contractor Admin
     */
    public function update_selection(Request $request, $subdomain, $productgroup)
    {
        try {
            $productgroup = ProductGroup::find($productgroup);

            $values = $request->validate([
                "status" => "required|in:0,1"
            ]);

            if ($values["status"] == 1)
                $productgroup->contractors()->sync([$request->contractor_details->id]);
            else
                $productgroup->contractors()->detach();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route("contractor.admin.productgroups.index", ['subdomain' => $subdomain])
            ->with('success', 'Product group has been ' . ($values['status'] == 1 ? 'selected' : 'deselected') . ' successfully');
    }

    /**
    * [GET] :  Product group list page for Admin
    */
    public function list_productgroups(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $productgroups = ProductGroup::where('contractor_id', $contractor_id)->get();
            return view('contractor.admin.productgroup.list', ['productgroups' => $productgroups]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
    * [GET] :  Product group create page for Admin
    */
    public function create_productgroup($subdomain)
    {
        return view('contractor.admin.productgroup.create');
    }

    /**
    * [POST] : Product group create handler for Admin
    */
    public function store_productgroup(Request $request, $subdomain)
    {
        $values = $request->validate([
            "pdt_group_name" => "required|string|max:255",
            "pdt_group_description" => "required|string|max:255",
            "pdt_group_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
        ]);

        try {
            $contractor_id = $request->contractor_details->id;
            $values['contractor_id'] = $contractor_id;
            $productgroup = ProductGroup::create($values);

            $values = ManageAssets::updateAssets($values['images'],$media=null, ["model" => "productgroup", "instance" => $productgroup]);

            return redirect()->route('contractor.admin.productgroups.list', ['subdomain' => $subdomain])->with('success', 'Product group has been created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
    * [GET] :  Product group edit page for Admin
    */
    public function edit_productgroup(Request $request, $subdomain, $productgroup)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $productgroup = ProductGroup::where('id', $productgroup)->where('contractor_id', $contractor_id)->first();
            if(!isset($productgroup->id)) {
                return redirect()->route('contractor.admin.productgroups.list', ['subdomain' => $subdomain])->with('error', 'Requested product group not found!');
            }

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.admin.productgroup.edit', ['productgroup' => $productgroup]);
    }

    /**
    * [PUT] :  Product group update handler for Admin
    */
    public function update_productgroup(Request $request, $subdomain, $productgroup)
    {
        $values = $request->validate([
            "pdt_group_name" => "required|string|max:255",
            "pdt_group_description" => "required|string|max:255",
            "pdt_group_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
        ]);

        try {
            $contractor_id = $request->contractor_details->id;
            $productgroup = ProductGroup::where('id', $productgroup)->where('contractor_id', $contractor_id)->first();
            if(!isset($productgroup->id)) {
                return redirect()->route('contractor.admin.productgroups.list', ['subdomain' => $subdomain])->with('error', 'Requested product group not found!');
            }

            $productgroup->update($values);

            $values = ManageAssets::updateAssets($values['images'],$media=null, ["model" => "productgroup", "instance" => $productgroup]);

            return redirect()->route('contractor.admin.productgroups.list', ['subdomain' => $subdomain])->with('success', 'Product group has been updated');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    /**
    * [DELETE] :  Product group delete handler for Admin
    */
    public function destroy_productgroup(Request $request, $subdomain, $productgroup)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $deleted = ProductGroup::where('id', $productgroup)->where('contractor_id', $contractor_id)->delete();

            if(!$deleted) {
                return redirect()->route('contractor.admin.productgroups.list', ['subdomain' => $subdomain])->with('error', 'Unable to delete requested product group!');    
            }
            return redirect()->route('contractor.admin.productgroups.list', ['subdomain' => $subdomain])->with('success', 'Product group has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting product group: ' . $e->getMessage());
        }
    }
}
