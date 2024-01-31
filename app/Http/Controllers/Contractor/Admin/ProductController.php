<?php

namespace App\Http\Controllers\Contractor\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ManageAssets;
use Auth;

class ProductController extends Controller
{
    /**
     * [GET] :  Product list for Contractor Admin
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $productgroup_id = $request->query('productgroup');
            $contractor = Contractor::find($request->contractor_details->id);

            $productgroup = $productgroup_id == "" ? null : ProductGroup::find($productgroup_id);

            if($productgroup_id == "") {
                $products = Product::where(function($q) use($contractor_id) {
                    $q->whereNull('contractor_id')->orWhere('contractor_id', $contractor_id);
                })->get();
            }
            else {
                $products =  $productgroup->products;
            }

            return view('contractor.admin.product.index', ['products' => $products, "subdomain" => $subdomain, 'contractor' => $contractor, 'productgroup' => $productgroup]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [PUT] :  Update selection of the product
     */
    public function update_selection(Request $request, $subdomain, $product)
    {
        try {
            $product = Product::find($product);

            $validator = Validator::make($request->all(), [
                "status" => "required|in:0,1"
            ]);

            $validator->sometimes('is_not_display_price', 'nullable|in:0,1', function ($input) {
                return $input->status === '1';
            });

            $validator->sometimes('is_enter_price', 'nullable|in:0,1', function ($input) {
                return $input->status === '1';
            });

            $validator->sometimes('product_price', 'required|numeric', function ($input) {
                return $input->is_enter_price === '1';
            });

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with("prevUrl", url()->current())->with("productName", $product->pdt_name);
            }

            $validated = $validator->safe()->only(['is_not_display_price', 'is_enter_price', 'product_price']);

            $product->contractors()->detach();

            if ($request["status"] == 1) {
                $validated['product_group_id'] = $product->pdt_group_id;

                $product->contractors()->sync([$request->contractor_details->id => $validated]);
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $route_params = ['subdomain' => $subdomain];
        if ($request->query('productgroup') !== "") $route_params['productgroup'] = $request->query('productgroup');

        return redirect()->route("contractor.admin.products.index", $route_params)
            ->with('success', 'Product has been ' . ($request['status'] == 1 ? 'selected' : 'deselected') . ' successfully');
    }

    /**
    * [GET] :  Product list page for Admin
    */
    public function list_products(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $productgroup_id = $request->query("productgroup");
            $products = [];
            $productgroup = null;

            if ($productgroup_id) {
                $productgroup = ProductGroup::where('id', $productgroup_id)
                ->where('contractor_id', $contractor_id)
                ->first();
                if(!isset($productgroup->id)) {
                    return back()->with('error', 'Requested product group not found');
                }
                $products = $productgroup->products;
            } else
                $products = Product::where('contractor_id', $contractor_id)->get();

            $productgroups = ProductGroup::where('contractor_id', $contractor_id)->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view("contractor.admin.product.list", ["products" => $products, "productgroups" => $productgroups, "productgroup" => $productgroup]);
    }

    /**
     * [GET] :  Product create page for Admin
     */
    public function create_product(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $productgroups = ProductGroup::where('contractor_id', $contractor_id)->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.admin.product.create', ['productgroups' => $productgroups]);
    }

    /**
     * [POST] : Product create handler for Admin
     */
    public function store_product(Request $request, $subdomain)
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
            $contractor_id = $request->contractor_details->id;
            $values["pdt_price"] = 0;
            $values['contractor_id'] = $contractor_id;
            $product = Product::create($values);

            ManageAssets::updateAssets($values['images'],$media=null, ["model" => "product", "instance" => $product]);

            return redirect()->route('contractor.admin.products.list', ['subdomain' => $subdomain])->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [GET] :  Product edit page for Admin
     */
    public function edit_product(Request $request, $subdomain, $product)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $product = Product::where('id', $product)->where('contractor_id', $contractor_id)->first();
            if(!isset($product->id)) {
                return redirect()->route('contractor.admin.products.list', ['subdomain' => $subdomain])->with('error', 'Requested product not found!');
            }
            $productgroups = ProductGroup::where('contractor_id', $contractor_id)->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.admin.product.edit', ['product' => $product, "productgroups" => $productgroups]);
    }

    /**
     * [PUT] :  Product update handler for Admin
     */
    public function update_product(Request $request, $subdomain, $product)
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
            $contractor_id = $request->contractor_details->id;
            $product = Product::where('id', $product)->where('contractor_id', $contractor_id)->first();
            if(!isset($product->id)) {
                return redirect()->route('contractor.admin.products.list', ['subdomain' => $subdomain])->with('error', 'Requested product not found!');
            }

            $product->update($values);

            ManageAssets::updateAssets($values['images'],$media=null, ["model" => "product", "instance" => $product]);

            return redirect()->route('contractor.admin.products.list', ['subdomain' => $subdomain])->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Product delete handler for Admin
     */
    public function destroy_product(Request $request, $subdomain, $product)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $deleted = Product::where('id', $product)->where('contractor_id', $contractor_id)->delete();
            if(!$deleted) {
                return redirect()->route('contractor.admin.products.list', ['subdomain' => $subdomain])->with('error', 'Unable to delete requested product!');    
            }
            return redirect()->route('contractor.admin.products.list', ['subdomain' => $subdomain])->with('success', 'Product has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting product: ' . $e->getMessage());
        }
    }
}
