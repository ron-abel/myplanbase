<?php

namespace App\Http\Controllers\Contractor;

use App\Helpers\ManageItems;
use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductGroupController extends Controller
{
    /**
     * [GET] : Product group index page.
     */
    public function index(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $productgroups = $contractor->productgroups;
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.productgroup.index', ['subdomain' => $subdomain, 'productgroups' => $productgroups, "floorplan" => $floorplan, "contractor" => $contractor]);
    }

    /**
     * [GET] : Product group detail page.
     */
    public function show(Request $request, $subdomain, $floorplan, $productgroup)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();
            $productgroup = ProductGroup::find($productgroup);
            $products = $contractor->products()->where('product_group_id', $productgroup->id)->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.productgroup.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan, 'productgroup' => $productgroup, 'products' => $products, "contractor" => $contractor]);
    }

    /**
     * [POST] : Add item handler.
     */
    public function add_item(Request $request, $subdomain, $floorplan)
    {
        $values = $request->validate([
            "product_id" => "required|exists:products,id",
            "color" => "nullable|string",
            "comment" => "nullable|string",
        ]);

        try {
            ManageItems::update_items($request, $values, $floorplan);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }

    /**
     * [PUT] : Update items color handler.
     */
    public function update_items_colors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "colors.*.color" => "required|string|max:255"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("color-list", true);
        }

        try {
            $validated = $validator->safe();

            ManageItems::update_colors($request, $validated);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }

    /**
     * [DELETE] : Delete item handler.
     */
    public function delete_item(Request $request, $subdomain, $item)
    {
        try {
            ManageItems::delete_item($request, $item);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }
}
