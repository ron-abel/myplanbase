<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\FloorPlan;
use Illuminate\Http\Request;

class FloorPlanController extends Controller
{
    /**
     * [GET] : Floor plan index page.
     */
    public function index(Request $request, $subdomain)
    {
        try {
            $contractor  = Contractor::find($request->contractor_details->id);
            $floorplans = $contractor->floorplans()->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('contractor.floorplan.index', ['subdomain' => $subdomain, 'floorplans' => $floorplans, "contractor" => $contractor]);
    }

    /**
     * [GET] : Floor plan detail page.
     */
    public function show(Request $request, $subdomain, $floorplan)
    {
        try {
            $contractor = Contractor::find($request->contractor_details->id);
            $floorplan = $contractor->floorplans()->where('floor_plan_id', $floorplan)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->first();
            $rest_floorplans = $contractor->floorplans()->where('floor_plan_id', "<>", $floorplan->id)->withPivot('is_keep_same_name', 'floor_plan_rename', 'is_not_display_price', 'floor_plan_price')->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return view('contractor.floorplan.show', ['subdomain' => $subdomain, 'floorplan' => $floorplan, "contractor" => $contractor, "floorplans" => $rest_floorplans]);
    }
}
