<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\ManageAssets;
use App\Http\Controllers\Controller;
use App\Models\ProductGroup;
use Illuminate\Http\Request;

class ProductGroupController extends Controller
{
    /**
     * [GET] :  Product group list page for Super Admin
     */
    public function index()
    {
        $productgroups = ProductGroup::all();

        return view('superadmin.productgroup.index', ['productgroups' => $productgroups]);
    }

    /**
     * [GET] :  Product group create page for Super Admin
     */
    public function create()
    {
        return view('superadmin.productgroup.create');
    }

    /**
     * [POST] : Product group create handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "pdt_group_name" => "required|string|max:255",
            "pdt_group_description" => "required|string|max:255",
            "pdt_group_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
        ]);

        try {
            $productgroup = ProductGroup::create($values);

            $values = ManageAssets::updateAssets($values['images'],$media=null, ["model" => "productgroup", "instance" => $productgroup]);

            return redirect()->route('super.productgroups.index')->with('success', 'Product group has been created');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Product group edit page for Super Admin
     */
    public function edit($productgroup)
    {
        try {
            $productgroup = ProductGroup::find($productgroup);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.productgroup.edit', ['productgroup' => $productgroup]);
    }

    /**
     * [PUT] :  Product group update handler for Super Admin
     */
    public function update(Request $request, $productgroup)
    {
        $values = $request->validate([
            "pdt_group_name" => "required|string|max:255",
            "pdt_group_description" => "required|string|max:255",
            "pdt_group_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
        ]);

        try {
            $productgroup = ProductGroup::findOrFail($productgroup);

            $productgroup->update($values);

            $values = ManageAssets::updateAssets($values['images'],$media=null, ["model" => "productgroup", "instance" => $productgroup]);

            return redirect()->route('super.productgroups.index')->with('success', 'Product group has been updated');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Product group delete handler for Super Admin
     */
    public function destroy(ProductGroup $productgroup)
    {
        try {
            $productgroup->delete();

            return redirect()->route('super.productgroups.index')->with('success', 'Product group has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting product group: ' . $e->getMessage());
        }
    }
}
