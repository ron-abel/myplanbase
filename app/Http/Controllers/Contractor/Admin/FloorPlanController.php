<?php

namespace App\Http\Controllers\Contractor\Admin;

use App\Http\Controllers\Controller;
use App\Models\FloorPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ManageAssets;
use Auth;

class FloorPlanController extends Controller
{
    /**
     * [GET] :  Floor plan list for Contractor Admin
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $floorplans = FloorPlan::where(function($q) use($contractor_id) {
                $q->whereNull('contractor_id')->orWhere('contractor_id', $contractor_id);
            })->get();

            return view("contractor.admin.floorplan.index", ["floorplans" => $floorplans, "subdomain" => $subdomain, 'contractor' => $request->contractor_details]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * [PUT] :  Floor plan selection handler for Contractor Admin
     */
    public function update_selection(Request $request, $subdomain, $floorplan)
    {
        try {
            $floorplan = FloorPlan::find($floorplan);


            $validator = Validator::make($request->all(), [
                "status" => "required|in:0,1"
            ]);

            $validator->sometimes('is_keep_same_name', 'required|in:0,1', function ($input) {
                return $input->status === '1';
            });


            $validator->sometimes('floor_plan_rename', 'required|max:255', function ($input) {
                return $input->is_keep_same_name === '0';
            });

            $validator->sometimes('is_not_display_price', 'nullable|in:0,1', function ($input) {
                return $input->status === '1';
            });

            $validator->sometimes('floor_plan_price', 'required|numeric', function ($input) {
                return $input->is_not_display_price === '0';
            });

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with("prevUrl", url()->current())->with("planName", $floorplan->plan_name);
            }

            $validated = $validator->safe()->only(['is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price']);

            $floorplan->contractors()->detach();

            if ($request["status"] == 1)
                $floorplan->contractors()->sync([$request->contractor_details->id => $validated]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route("contractor.admin.floorplans.index", ['subdomain' => $subdomain])
            ->with('success', 'Floor plan has been ' . ($request['status'] == 1 ? 'selected' : 'deselected') . ' successfully');
    }

    /**
    * Floor plans management for contractor admin
    */

    /**
    * [GET] :  Floor plan List page for Admin
    */
    public function list_floorplans(Request $request, $subdomain)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $floorplans = FloorPlan::where('contractor_id', $contractor_id)->get();
            return view('contractor.admin.floorplan.list', ['floorplans' =>  $floorplans]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
    * [GET] :  Floor plan create page for Admin
    */
    public function create_floorplan($subdomain)
    {
        return view('contractor.admin.floorplan.create');
    }

    /**
    * [POST] :  Floor plan create handler for Admin
    */
    public function store_floorplan(Request $request, $subdomain)
    {
        $values = $request->validate([
            "plan_name" => "required|string|max:255",
            "plan_description" => "required|string|max:255",
            "plan_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
            'media.*.vid_name' => 'required|string|max:255',
            'media.*.vid_url' => 'required|string|max:20480',
        ]);

        try {
            $contractor_id = $request->contractor_details->id;
            $values['plan_price'] = 0;
            $values['contractor_id'] = $contractor_id;
            $floorPlan = FloorPlan::create($values);

            $values = ManageAssets::updateAssets($values['images'],$values['media'], ["model" => "floorplan", "instance" => $floorPlan]);

            return redirect()->route('contractor.admin.floorplans.list', ['subdomain' => $subdomain])->with('success', 'Floor plan created successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
    * [GET] :  Floor plan edit page for Admin
    */
    public function edit_floorplan(Request $request, $subdomain, $floorPlan)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $floorPlan = FloorPlan::where('id', $floorPlan)->where('contractor_id', $contractor_id)->first();
            if(!isset($floorPlan->id)) {
                return redirect()->route('contractor.admin.floorplans.list', ['subdomain' => $subdomain])->with('error', 'Requested floor plan not found!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.admin.floorplan.edit', ['floorplan' => $floorPlan, 'subdomain' => $subdomain]);
    }

    /**
    * [PUT] :  Floor plan update handler for Admin
    */
    public function update_floorplan(Request $request, $subdomain, $floorPlan)
    {
        $values = $request->validate([
            "plan_name" => "required|string|max:255",
            "plan_description" => "required|string|max:255",
            "plan_additional_text" => "required|string",
            'images.*.pic_name' => 'required|string|max:255',
            'images.*.pic_url' => 'required|string',
            'media.*.vid_name' => 'required|string|max:255',
            'media.*.vid_url' => 'required|string|max:20480',
        ]);

        try {
            $contractor_id = $request->contractor_details->id;
            $floorPlan = FloorPlan::where('id', $floorPlan)->where('contractor_id', $contractor_id)->first();
            if(!isset($floorPlan->id)) {
                return redirect()->route('contractor.admin.floorplans.list', ['subdomain' => $subdomain])->with('error', 'Requested floor plan not found!');
            }

            $floorPlan->update($values);

            $values = ManageAssets::updateAssets($values['images'],$values['media'], ["model" => "floorplan", "instance" => $floorPlan]);

            return redirect()->route('contractor.admin.floorplans.list', ['subdomain' => $subdomain])->with('success', 'Floor plan updated successfully');
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }
    }

    /**
     * [DELETE] :  Floor plan delete handler for Admin
     */
    public function destroy_floorplan(Request $request, $subdomain, $floorPlan)
    {
        try {
            $contractor_id = $request->contractor_details->id;
            $deleted = FloorPlan::where('id', $floorPlan)->where('contractor_id', $contractor_id)->delete($floorPlan);

            if(!$deleted) {
                return redirect()->route('contractor.admin.floorplans.list', ['subdomain' => $subdomain])->with('error', 'Unable to delete requested floor plan!');    
            }
            return redirect()->route('contractor.admin.floorplans.list', ['subdomain' => $subdomain])->with('success', 'Floor plan has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting floor plan: ' . $e->getMessage());
        }
    }

}
