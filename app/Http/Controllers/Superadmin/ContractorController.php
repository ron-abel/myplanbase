<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\ManageAssets;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PSpell\Config;

class ContractorController extends Controller
{

    /**
     * [GET] :  Contractor List page for Super Admin
     */
    public function index()
    {
        $contractors = Contractor::where('sub_domain', '<>', config('app.superadmin'))->get();

        return view("superadmin.contractor.index", ["contractors" => $contractors]);
    }

    /**
     * [GET] :  Contractor create page for Super Admin
     */
    public function create()
    {
        return view("superadmin.contractor.create");
    }

    /**
     * [GET] :  Contractor edit page for Super Admin
     */
    public function edit($contractor)
    {
        try {
            $contractor = Contractor::find($contractor);

            $contractor->load("owner");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view("superadmin.contractor.edit", ['contractor' => $contractor]);
    }

    /**
     * [POST] :  Contractor create handler for Super Admin
     */
    public function store(Request $request)
    {
        $values = $request->validate([
            "company_name" => "required|string|max:255",
            "sub_domain" => "required|string|unique:contractors",
            "company_website" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
            "state" => "nullable|string|max:255",
            "county" => "nullable|string|max:255",
            "zip" => "nullable|string|max:255",
            "logo" => "nullable|string|max:255",
            "first_name"  => "required|string|max:255",
            "last_name"  => "required|string|max:255",
            "email"  => "required|email|unique:users",
            "password" => "required|string|max:255"
        ]);

        try {
            $contractor = Contractor::create($values);
            $values['contractor_id'] = $contractor->id;
            $values['user_role_id'] = 2;
            $values['password'] = bcrypt($values['password']);

            $user = User::create($values);

            if ($values['logo'] !== "")
                ManageAssets::updateLogo($values['logo'], ['instance' => $contractor]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        Mail::to($user->email)->send(new ConfirmationMail($user, $contractor));

        if (!Auth::user() || Auth::user()->user_role_id !== 1)
            return redirect()->route('contractor.admin.login', ["subdomain" => $contractor->sub_domain]);

        return redirect()->route('super.contractors.index')->with('success', 'Contractor created successfully');
    }

    /**
     * [PUT] :  Contractor update handler for Super Admin
     */
    public function update(Request $request, $contractor)
    {
        $values = $request->validate([
            "company_name" => "required|string|max:255",
            "sub_domain" => "required|string|unique:contractors,sub_domain," . $contractor,
            "company_website" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
            "state" => "nullable|string|max:255",
            "county" => "nullable|string|max:255",
            "zip" => "nullable|string|max:255",
            "logo" => "nullable|string|max:255",
        ]);

        try {
            $contractor = Contractor::find($contractor);

            $contractor->update($values);

            if (isset($values['logo']))
                ManageAssets::updateLogo($values['logo'], ['instance' => $contractor]);
        } catch (\Exception $e) {
            return back()->with('error',  $e->getMessage());
        }

        return redirect()->route('super.contractors.index')->with('success', 'Contractor updated successfully');
    }

    /**
     * [DELETE] :  Contractor delete handler for Super Admin
     */
    public function destroy($contractor)
    {
        try {
            $contractor = Contractor::find($contractor);
            $contractor->owner->delete();
            $contractor->delete();

            return redirect()->route('super.contractors.index')->with('success', 'Contractor has been deleted');
        } catch (\Exception $e) {
            // Handle the exception here
            return back()->with('error', 'An error occurred while deleting contractor: ' . $e->getMessage());
        }
    }
}
