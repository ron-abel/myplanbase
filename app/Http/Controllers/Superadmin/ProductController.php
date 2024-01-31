<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\ManageAssets;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * [GET] :  Product list page for Super Admin
     */
    public function index(Request $request)
    {
        try {

            $productgroup_id = $request->query("productgroup");
            $products = [];
            $productgroup = null;

            if ($productgroup_id) {
                $productgroup = ProductGroup::find($productgroup_id);
                $products = $productgroup->products;
            } else
                $products = Product::all();

            $productgroups = ProductGroup::all();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view("superadmin.product.index", ["products" => $products, "productgroups" => $productgroups, "productgroup" => $productgroup]);
    }

    /**
     * [GET] :  Product create page for Super Admin
     */
    public function create()
    {
        try {
            $productgroups = ProductGroup::all();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.product.create', ['productgroups' => $productgroups]);
    }

    /**
     * [POST] : Product create handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "pdt_name" => "required|string|max:255",
            "pdt_group_id" => "required|exists:product_groups,id",
            "pdt_description" => "required|string|max:255",
            "pdt_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
        ]);

        try {
            $values["pdt_price"] = 0;
            $product = Product::create($values);

            ManageAssets::updateAssets($values['images'],$media=null, ["model" => "product", "instance" => $product]);

            return redirect()->route('super.products.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Product edit page for Super Admin
     */
    public function edit($product)
    {
        try {
            $product = Product::find($product);
            $productgroups = ProductGroup::all();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('superadmin.product.edit', ['product' => $product, "productgroups" => $productgroups]);
    }

    /**
     * [PUT] :  Product update handler for Super Admin
     */
    public function update(Request $request, $product)
    {
        $values = $request->validate([
            "pdt_name" => "required|string|max:255",
            "pdt_group_id" => "required|exists:product_groups,id",
            "pdt_description" => "required|string|max:255",
            "pdt_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
        ]);

        try {
            $product = Product::findOrFail($product);

            $product->update($values);

            ManageAssets::updateAssets($values['images'],$media=null, ["model" => "product", "instance" => $product]);

            return redirect()->route('super.products.index');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Product delete handler for Super Admin
     */
    public function destroy($product)
    {
        try {
            Product::destroy($product);

            return redirect()->route('super.products.index');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting product: ' . $e->getMessage());
        }
    }
}
